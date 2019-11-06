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
            props: ['categories'],
            data: {
                firstId: null,
                selected: [],
                selectedIds: [],
            },
            watch: {
                selectedIds: function (value) {
                    let self = this;
                    self.selected = [];
                    value.map(function (id) {
                        self.selected.push(self.categories.find(category => category.id === id));
                    });
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
                load: function (selectedIds) {
                    let self = this;
                    axios.get('/admin/shop/catalog/categories/ajax-all-with-depth').then(function (response) {
                        self.categories = response.data;
                        self.selectedIds = selectedIds;
                        $('#categoryIds').selectpicker('destroy').selectpicker();
                    });
                },
            }
        });

        Categories.load(@json(old('category_ids', $productCategoryIds)));
    </script>
@endpush