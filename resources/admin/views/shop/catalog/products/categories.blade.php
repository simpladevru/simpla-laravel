<div id="categoriesBlock">
    <div>
        <div class="mb-3">
            <draggable v-model="selected" @change="onSort">
                <span class="badge badge-secondary p-2 mr-1 mb-1" v-for="category in selected">
                    <input
                        type="hidden"
                        name="category_ids[]"
                        :value="category.id"
                    >
                    @{{ category.name }}
                </span>
            </draggable>
        </div>

        <select
            multiple
            id="categoryIds"
            data-style="border"
            class="form-control selectpicker"
            data-show-subtext="true"
            data-live-search="true"
            data-selected-text-format="count"
            v-model="selectedIds"
            @change="onChange"
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
            methods: {
                onSort: function () {
                    if (
                        this.selected.length
                        && this.selected[0].id !== this.firstId
                    ) {
                        Features.loadByCategory(this.selected[0].id);
                    }
                },
                onChange: function () {
                    this.findSelected();
                },
                findSelected: function () {
                    let self = this;
                    self.selected = [];
                    this.selectedIds.map(function (id) {
                        self.selected.push(
                            self.categories.find(category => category.id === id)
                        );
                    });
                },
                load: function (selectedIds) {
                    let self = this;

                    self.selectedIds = selectedIds;

                    axios.get('/admin/shop/catalog/categories/ajax-all-with-depth').then(function (response) {
                        self.categories = response.data;

                        self.findSelected();

                        if (selectedIds.length) {
                            self.firstId = selectedIds[0];
                            Features.loadByCategory(self.firstId);
                        }

                        $('#categoryIds').selectpicker('destroy').selectpicker();
                    });
                },
            }
        });

        Categories.load(@json(old('category_ids', $productCategoryIds)));
    </script>
@endpush