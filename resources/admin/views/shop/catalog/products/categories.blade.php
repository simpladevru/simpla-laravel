<div id="categoriesBlock">
    <div>
        <div class="mb-3">
            <draggable v-model="selected">
                <span class="badge badge-secondary p-2 mr-1 mb-1" v-for="category in selected">
                    <input type="hidden" name="category_ids[]" :value="category.id">
                    @{{ category.name }}
                    <i class="cursor-pointer fa fa-times" @click="remove(index)"></i>
                </span>
            </draggable>
        </div>

        <select
            multiple
            id="categoryIds"
            data-style="border"
            class="form-control selectpicker"
            data-live-search="true"
            data-selected-text-format="count > 0"
            v-model="selectedIds"
        >
            <option
                v-for="category in categories"
                :value="category.id"
            >@{{ ('-').repeat(category.depth) }} @{{ category.name }}</option>
        </select>
    </div>
</div>

@push('scripts-footer')
    <script>
        let Categories = new Vue({
            el: '#categoriesBlock',
            data: {
                firstId: null,
                selected: [],
                selectedIds: [],
                categories: [],
            },
            watch: {
                categories: function () {
                    this.findSelected()
                },
                selectedIds: function () {
                    this.findSelected()
                },
                selected: function (value) {
                    if (value.length === 0) {
                        this.firstId = null;
                        return;
                    }

                    if (value[0].id !== this.firstId) {
                        this.firstId = value[0].id;
                    }
                },
                firstId: function (value) {
                    Features.loadByCategory(value);
                },
            },
            methods: {
                remove: function (index) {
                    this.selectedIds.splice(index, 1);
                    $('#categoryIds').selectpicker('refresh');
                },
                findSelected: function () {
                    let self = this;

                    self.selected = [];

                    if (self.categories.length && self.selectedIds.length) {
                        self.selectedIds.map(function (id) {
                            self.selected.push(self.categories.find(category => category.id === id));
                        });

                        self.firstId = self.selected[0].id;
                    }
                },
                loadCategories: function () {
                    let self = this;
                    axios.get('/admin/shop/catalog/categories/ajax-all-with-depth').then(function (response) {
                        self.categories = response.data;
                        $('#categoryIds').selectpicker('destroy').selectpicker();
                    });
                },
                setSelectedIds: function (selectedIds) {
                    let self = this;
                    if (selectedIds.length) {
                        selectedIds.map(function (id) {
                            self.selectedIds.push(parseInt(id));
                        });
                    }
                },
            },
            created: function() {
                this.loadCategories();
            }
        });

        Categories.setSelectedIds(@json(old('category_ids', $productCategoryIds)));
    </script>
@endpush