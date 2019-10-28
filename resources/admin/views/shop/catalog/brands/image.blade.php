<div id="brandImageBlock" class="mb-3">
    <img :src="image" alt="" class="img-thumbnail" style="max-width: 200px; max-height: 200px">
    <div class="custom-file mt-2">
        <input
            @change="selectImage"
            type="file"
            name="image"
            id="uploadImage"
            class="custom-file-input"
        >
        <label class="custom-file-label" for="uploadImage">Choose file</label>
    </div>
</div>

@push('scripts-footer')
    <script>
        let BrandImage = new Vue({
            el: '#brandImageBlock',
            props: ['image'],
            methods: {
                load: function (image) {
                    this.image = image;
                },
                selectImage(e) {
                    let self = this;
                    let reader = new FileReader();

                    reader.onload = function (event) {
                        self.image = event.target.result;
                    };

                    reader.readAsDataURL(e.target.files[0]);
                }
            }
        });

        BrandImage.load('{{ $brand->getResizedUrl(200, 200) }}');
    </script>
@endpush
