<div id="categoryImageBlock" class="mb-3">
    <input type="hidden" name="image" :value="original">
    <div v-if="resize">
        <img :src="resize" alt="" class="img-thumbnail d-block" style="max-width: 200px; max-height: 200px">
        <button class="btn btn-danger d-block mt-2" @click="removeImage" type="button">
            {{ trans('actions.delete') }}
        </button>
    </div>
    <div class="custom-file mt-2">
        <input
            @change="selectImage"
            type="file"
            name="upload_image"
            id="uploadImage"
            class="custom-file-input"
        >
        <label class="custom-file-label" for="uploadImage">Choose file</label>
    </div>
</div>

@push('scripts-footer')
    <script>
        let CategoryImage = new Vue({
            el: '#categoryImageBlock',
            props: ['original', 'resize'],
            methods: {
                load: function (original, resize) {
                    this.original = original;
                    this.resize = resize;
                },
                selectImage: function (e) {
                    let self = this;
                    let reader = new FileReader();

                    reader.onload = function (event) {
                        self.resize = event.target.result;
                    };

                    reader.readAsDataURL(e.target.files[0]);
                },
                removeImage: function () {
                    this.original = null;
                    this.resize = null;

                }
            }
        });

        CategoryImage.load('{{ $brand->image }}', '{{ $brand->getResizedUrl(200, 200) }}');
    </script>
@endpush
