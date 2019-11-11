@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Products</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>@endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{
            $product->id
                ? route('admin.shop.catalog.products.update', $product)
                : route('admin.shop.catalog.products.store')
        }}"
    >
        @csrf
        @if($product->id)
            @method('PUT')
        @endif

        <div class="card">
            <h4 class="card-header">
                {{ $product->id ? 'Edit' : 'Create'}} product
                <a href="{{ route('admin.shop.catalog.products.index') }}" class="btn btn-link">Back</a>
            </h4>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">Name</label>
                            <div class="col-md-9">
                                <input
                                    id="name"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="name"
                                    value="{{ old('name', $product->name) }}"
                                    required
                                >
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label"></label>
                            <div class="col-md-9">
                                <div class="custom-control custom-switch d-inline-block mr-4">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="isActive"
                                        name="is_active"
                                        value="1"
                                        {{ $product->is_active ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="isActive">Active</label>
                                </div>
                                <div class="custom-control custom-switch d-inline-block">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="isFeatured"
                                        name="is_featured"
                                        value="1"
                                        {{ $product->is_featured ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="isFeatured">Featured</label>
                                </div>
                            </div>
                        </div>

                        <h3 class="border-bottom mt-5 mb-3 pb-2">Variants</h3>

                        @include('shop.catalog.products.variants')

                        <div class="row mt-5">
                            <div class="col-md-6">
                                @if(count($brands) > 0)
                                    <div class="mb-4">
                                        <h3 class="border-bottom mb-3 pb-2">Brand</h3>
                                        <select
                                            id="brandId"
                                            data-style="border"
                                            data-live-search="true"
                                            class="form-control selectpicker {{ $errors->has('brand_id') ? ' is-invalid' : '' }}"
                                            name="brand_id"
                                        >
                                            <option value=""></option>
                                            @foreach ($brands as $brand)
                                                <option
                                                    value="{{ $brand->id }}"
                                                    {{ $product->brand_id == $brand->id ? 'selected' : '' }}
                                                >
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach;
                                        </select>
                                        @if ($errors->has('brand_id'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('brand_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif

                               {{--@if(count($categories) > 0)--}}
                                    <div class="mb-4">
                                        <h3 class="border-bottom mb-3 pb-2">Categories</h3>
                                        @include('shop.catalog.products.categories')
                                        @if ($errors->has('category_ids'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('category_ids') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    <h3 class="border-bottom mb-3 pb-2">Features</h3>
                                    @include('shop.catalog.products.features')
                                {{--@endif--}}
                            </div>
                            <div class="col-md-6">
                                <h3 class="border-bottom mb-3 pb-2">Images</h3>
                                @include('shop.catalog.products.images')

                                <h3 class="border-bottom mb-3 mt-4 pb-2">Relation products</h3>
                            </div>
                        </div>

                        <h3 class="border-bottom mt-5 mb-3 pb-2">Description</h3>

                        <div class="form-group row">
                            <label for="annotation" class="col-md-3 col-form-label">Annotation</label>
                            <div class="col-md-9">
                                <textarea
                                    name="annotation"
                                    id="annotation"
                                    cols="30"
                                    rows="3"
                                    class="form-control{{ $errors->has('annotation') ? ' is-invalid' : '' }}"
                                >{{ old('annotation', $product->annotation) }}</textarea>
                                @if ($errors->has('annotation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('annotation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label">Description</label>
                            <div class="col-md-9">
                                <textarea
                                    name="description"
                                    id="description"
                                    cols="30"
                                    rows="10"
                                    class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                >{{ old('description', $product->description) }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <h3 class="border-bottom mt-5 mb-3 pb-2">Seo</h3>

                        <div class="form-group row">
                            <label for="slug" class="col-md-3 col-form-label">Slug</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input
                                        id="slug"
                                        class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                        name="slug"
                                        value="{{ old('slug', $product->slug) }}"
                                    >
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary translit-slug-button" type="button" data-name="name" data-slug="slug">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                    </div>
                                </div>
                                @if ($errors->has('slug'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="metaTitle" class="col-md-3 col-form-label">Meta Title</label>
                            <div class="col-md-9">
                                <textarea
                                    name="meta_title"
                                    id="metaTitle"
                                    cols="30"
                                    rows="3"
                                    class="form-control{{ $errors->has('meta_title') ? ' is-invalid' : '' }}"
                                >{{ old('meta_title', $product->meta_title) }}</textarea>
                                @if ($errors->has('meta_title'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('meta_title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="metaKeywords" class="col-md-3 col-form-label">Meta Keywords</label>
                            <div class="col-md-9">
                                <textarea
                                    name="meta_keywords"
                                    id="metaKeywords"
                                    cols="30"
                                    rows="3"
                                    class="form-control{{ $errors->has('meta_keywords') ? ' is-invalid' : '' }}"
                                >{{ old('meta_keywords', $product->meta_keywords) }}</textarea>
                                @if ($errors->has('meta_keywords'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('meta_keywords') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="metaDescription" class="col-md-3 col-form-label">Meta Description</label>
                            <div class="col-md-9">
                                <textarea
                                    name="meta_description"
                                    id="metaDescription"
                                    cols="30"
                                    rows="3"
                                    class="form-control{{ $errors->has('meta_description') ? ' is-invalid' : '' }}"
                                >{{ old('meta_description', $product->meta_description) }}</textarea>
                                @if ($errors->has('meta_description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('meta_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group border-top mt-4 mb-4"></div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Created</label>
                            <div class="col-md-9">
                                <label>
                                    <input class="form-control" value="{{ $product->created_at  }}" disabled>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Updated</label>
                            <div class="col-md-9">
                                <label>
                                    <input class="form-control" value="{{ $product->updated_at  }}" disabled>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-outline-primary mr-2" name="submit-save" value="1">{{ trans('actions.save') }}</button>
                <button type="submit" class="btn btn-outline-dark" name="submit-apply" value="1">{{ trans('actions.apply') }}</button>
            </div>
        </div>
    </form>
@endsection
