<div id="featuresBlock">
    <div class="form-group row mb-0" v-for="feature in features">
        <label class="col-md-4 col-form-label">
            <span class="feature-name">@{{ feature.name }}</span>
        </label>
        <div class="col-md-8">
            <div
                v-for="(attribute, index) in attributes[feature.id]"
                class="input-group input-group-sm mb-2"
            >
                <input
                    type="hidden"
                    :name="getInputName(feature.id, index, 'id')"
                    :value="attribute.id"
                >
                <input
                    type="hidden"
                    :name="getInputName(feature.id, index, 'feature_id')"
                    :value="attribute.feature_id"
                >
                <input
                    type="text"
                    class="form-control"
                    :name="getInputName(feature.id, index, 'value')"
                    v-model="attribute.value"
                >
                <div class="input-group-append">
                    <button
                        v-if="index === 0"
                        @click="add(feature.id, index)"
                        class="btn btn-outline-secondary"
                        type="button"
                    ><i class="fa fa-plus-circle"></i></button>
                    <button v-else class="btn btn-outline-secondary" @click="remove(feature.id, index)" type="button">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>

@push('scripts-footer')
    <script>
        let Features = new Vue({
            el: '#featuresBlock',
            data: {
                features: [],
                attributes: [],
                errors: [],
            },
            methods: {
                getInputName: function (featureId, index, key) {
                    return "attributes[" + featureId + "][" + index + "][" + key + "]";
                },
                add: function (featureId) {
                    this.attributes[featureId].push({
                        id: null,
                        feature_id: featureId,
                        value: null,
                    });
                },
                remove: function (featureId, index) {
                    this.attributes[featureId].splice(index, 1);

                    if (this.attributes[featureId] === 0) {
                        this.add();
                    }
                },
                load: function (attributes, errors) {
                    this.attributes = attributes;
                    this.errors = errors;
                },
                loadByCategory: function (categoryId) {
                    let self = this;

                    if (categoryId === null) {
                        self.features = [];
                        return;
                    }

                    axios.get('/admin/shop/catalog/categories/' + categoryId + '/ajax-features').then(function (response) {
                        self.features = response.data;

                        self.features.map(function (feature) {
                            if (typeof self.attributes[feature.id] === 'undefined') {
                                self.$set(self.attributes, feature.id, [])
                            }
                            if (self.attributes[feature.id].length === 0) {
                                self.add(feature.id);
                            }
                        });
                    });
                }
            }
        });

        @if($productCategoryIds)
            Features.load(
                @json(old('attributes', $product->getAttributesGroupedByFeatureId()->toArray())),
                @json($errors->get('attributes.*'))
            );
        @endif
    </script>
@endpush
