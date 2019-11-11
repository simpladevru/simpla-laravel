<div id="variantsBlock">
    <div class="form-row">
        <div class="col-md-4">
            <label>Name</label>
        </div>
        <div class="col-md-2">
            <label>Price</label>
        </div>
        <div class="col-md-2">
            <label>Compare price</label>
        </div>
        <div class="col-md-2">
            <label>Sku</label>
        </div>
        <div class="col-md-2">
            <label>Amount</label>
        </div>
    </div>
    <draggable v-model="variants" class="variants-list">
        <div class="form-row mb-2" v-for="(variant, index) in variants">
            <div class="col-md-4">
                <input type="hidden" :name="getInputName(index, 'id')" :value="variant.id">
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control"
                        :class="{'is-invalid': hasErrors(index, 'name')}"
                        :name="getInputName(index, 'name')"
                        v-model="variant.name"
                    >
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" @click="remove(index)" type="button">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
                <div class="invalid-feedback">
                    <strong v-for="error in getErrors(index, 'name')">@{{ error }}</strong>
                </div>
            </div>
            <div class="col-md-2">
                <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': hasErrors(index, 'price')}"
                    :name="getInputName(index, 'price')"
                    v-model="variant.price"
                >
                <div class="invalid-feedback">
                    <strong v-for="error in getErrors(index, 'price')">@{{ error }}</strong>
                </div>
            </div>
            <div class="col-md-2">
                <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': hasErrors(index, 'compare_price')}"
                    :name="getInputName(index, 'compare_price')"
                    v-model="variant.compare_price"
                >
                <div class="invalid-feedback">
                    <strong v-for="error in getErrors(index, 'compare_price')">@{{ error }}</strong>
                </div>
            </div>
            <div class="col-md-2">
                <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': hasErrors(index, 'sku')}"
                    :name="getInputName(index, 'sku')"
                    v-model="variant.sku"
                >
                <div class="invalid-feedback">
                    <strong v-for="error in getErrors(index, 'stock')">@{{ sku }}</strong>
                </div>
            </div>
            <div class="col-md-2">
                <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': hasErrors(index, 'stock')}"
                    :name="getInputName(index, 'stock')"
                    v-model="variant.stock"
                >
                <div class="invalid-feedback">
                    <strong v-for="error in getErrors(index, 'stock')">@{{ error }}</strong>
                </div>
            </div>
        </div>
    </draggable>
    <button class="btn btn-secondary" @click="add" type="button">
        <i class="fa fa-plus-circle"></i> Add
    </button>
</div>

@push('scripts-footer')
    <script>
        let Variants = new Vue({
            el: '#variantsBlock',
            props: ['variants', 'errors'],
            methods: {
                getInputName(index, key) {
                    return "variants[" + index + "][" + key + "]";
                },
                hasErrors(index, field) {
                    return typeof this.errors['variants.' + index + '.' + field] !== 'undefined';
                },
                getErrors(index, field) {
                    return this.errors['variants.' + index + '.' + field];
                },
                add: function () {
                    this.variants.push({
                        id: null,
                        name: null,
                        price: null,
                        compare_price: null,
                        sku: null,
                        stock: null
                    });
                },
                remove: function (index) {
                    this.variants.splice(index, 1);
                    if (this.variants.length === 0) {
                        this.add();
                    }
                },
                load: function (items, errors) {
                    this.variants = items;
                    this.errors = errors;
                    if (items.length === 0) {
                        this.add();
                    }
                }
            }
        });

        Variants.load(
            @json(old('variants', $product->variants()->orderBy('sort')->get())),
            @json($errors->get('variants.*'))
        );
    </script>
@endpush
