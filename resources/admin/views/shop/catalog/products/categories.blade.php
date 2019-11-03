<select
    id="categoryIds"
    data-style="border"
    class="form-control{{ $errors->has('category_ids') ? ' is-invalid' : '' }}"
    name="category_ids[]"
    multiple
    data-show-subtext="true"
    data-live-search="true"
    data-selected-text-format="count"
>
    @foreach ($categories as $parent)
        <option
            value="{{ $parent->id }}"
            {{ in_array($parent->id, $productCategoryIds) ? 'selected' : '' }}
        >
            @for ($i = 0; $i < $parent->depth; $i++) &mdash; @endfor
            {{ $parent->name }}
        </option>
    @endforeach;
</select>

@push('scripts-footer')
    <script>
        let $categoriesSelect = $('select[name*=category_ids]');
        let categoryId = $categoriesSelect.find('option:selected').val();

        $('select[name*=category_ids]').change(function () {
            let firstId = $(this).find('option:selected').val();

            if (categoryId !== firstId) {
                categoryId = firstId;
                Features.loadCategoryFeatures(firstId);
            }
        });
    </script>
@endpush