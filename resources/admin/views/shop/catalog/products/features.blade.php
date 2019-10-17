<div id="featuresBlock">
    <div class="form-group row mb-0" v-for="feature in features">
        <label class="col-md-4 col-form-label">
            <span class="feature-name">@{{ feature.name }}</span>
        </label>
        <div class="col-md-8">
            <div class="input-group input-group-sm mb-2" v-for="(attribute, index) in getAttributes(feature.id)">
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
                    <button v-if="index === 0" class="btn btn-outline-secondary" @click="add(feature.id, index)" type="button">
                        <i class="fa fa-plus-circle"></i>
                    </button>
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
            props: ['features', 'attributes', 'errors'],
            methods: {
                getInputName(featureId, index, key) {
                    return "attributes[" + featureId + "][" + index + "][" + key + "]";
                },
                getAttributes: function (featureId) {
                    if (this.attributes[featureId].length === 0) {
                        this.add(featureId);
                    }
                    return this.attributes[featureId];
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
                load: function (features, attributes, errors) {
                    features.map(function (feature) {
                        if (typeof attributes[feature.id] === 'undefined') {
                            attributes[feature.id] = [];
                        }
                    });

                    this.features = features;
                    this.attributes = attributes;
                    this.errors = errors;
                },
            }
        });

        Features.load(
            @json($features),
            @json(old('attributes', $product->attributes()->get()->groupBy('feature_id'))),
            @json($errors->get('attributes.*'))
        );
    </script>
@endpush
