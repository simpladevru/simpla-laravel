<div id="imagesBlock" class="mb-3">
    <draggable v-model="images" draggable=".draggable-image" class="row" style="margin: -4px;">
        <div v-for="(image, index) in images" class="col col-4 mb-0 p-1 d-inline-flex draggable-image">
            <div class="border text-center p-2" style="width: 100%">
                <img :src="image.file" class="img-fluid d-inline-block" style="max-height: 100px;">
                <input type="hidden" name="images[]" :value="image.id">
                <button @click="remove(index)" type="button" class="btn btn-sm btn-danger mt-2">Remove</button>
            </div>
        </div>
    </draggable>

    <div class="input-group mt-3">
        <div class="custom-file">
            <input
                @change="selectImages"
                type="file"
                class="custom-file-input"
                id="uploadImages"
                name="upload_images[]"
                multiple
            >
            <label class="custom-file-label" for="uploadImages">Choose file</label>
        </div>
    </div>
</div>

@push('scripts-footer')
    <script>
        let Images = new Vue({
            el: '#imagesBlock',
            props: ['images'],
            methods: {
                load: function (images) {
                    this.images = images;
                },
                remove: function (index) {
                    this.images.splice(index, 1);
                },
                selectImages(e) {
                    let self = this;

                    for (i = 0; i < e.target.files.length; i++) {
                        let reader = new FileReader();

                        reader.onload = function (event) {
                            self.images.push({id: null, file: event.target.result});
                        };

                        reader.readAsDataURL(e.target.files[i]);
                    }
                }
            }
        });

        Images.load(@json($product->images()->orderBy('sort')->get()->map(function ($image) {
            return [
                'id'   => $image->id,
                'file' => Storage::disk('public')->url('products/') . $image->getResizedFilename(120, 120)
            ];
        })));
    </script>
@endpush
