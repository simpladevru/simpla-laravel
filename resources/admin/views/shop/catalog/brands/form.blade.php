@extends('admin.layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Brands</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>@endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <form
        method="POST"
        action="{{
            $brand->id
                ? route('admin.shop.catalog.brands.update', $brand)
                : route('admin.shop.catalog.brands.store')
        }}"
    >
        @csrf
        @if($brand->id)
            @method('PUT')
        @endif

        <div class="card">
            <h4 class="card-header">
                {{ $brand->id ? 'Edit' : 'Create' }} brand
                <a href="{{ route('admin.shop.catalog.brands.index') }}" class="btn btn-link">Back</a>
            </h4>
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-md-9 offset-md-1">
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">Name</label>
                            <div class="col-md-9">
                                <input
                                    id="name"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    name="name"
                                    value="{{ old('name', $brand->name) }}"
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
                            <label for="slug" class="col-md-3 col-form-label">Slug</label>
                            <div class="col-md-9">
                                <input
                                    id="slug"
                                    class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                    name="slug"
                                    value="{{ old('slug', $brand->slug) }}"
                                >
                                @if ($errors->has('slug'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group border-top mt-4 mb-4"></div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label">Description</label>
                            <div class="col-md-9">
                                <textarea
                                    name="description"
                                    id="description"
                                    cols="30"
                                    rows="10"
                                    class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                >{{ old('description', $brand->description) }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group border-top mt-4 mb-4"></div>

                        <div class="form-group row">
                            <label for="metaTitle" class="col-md-3 col-form-label">Meta Title</label>
                            <div class="col-md-9">
                                <textarea
                                    name="meta_title"
                                    id="metaTitle"
                                    cols="30"
                                    rows="3"
                                    class="form-control{{ $errors->has('meta_title') ? ' is-invalid' : '' }}"
                                >{{ old('meta_title', $brand->meta_title) }}</textarea>
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
                                >{{ old('meta_keywords', $brand->meta_keywords) }}</textarea>
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
                                >{{ old('meta_description', $brand->meta_description) }}</textarea>
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
                                    <input class="form-control" value="{{ $brand->created_at  }}" disabled>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Updated</label>
                            <div class="col-md-9">
                                <label>
                                    <input class="form-control" value="{{ $brand->updated_at  }}" disabled>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">{{ $brand->id ? 'Save' : 'Add'}}</button>
            </div>
        </div>
    </form>
@endsection
