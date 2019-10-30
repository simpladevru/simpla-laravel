@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">
            <a href="{{ route('admin.shop.catalog.categories.index') }}">{{ trans('titles.categories') }}</a>
            / {{ $category->name }}
        </h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>@endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <form
        method="POST"
        action="{{
            $category->id
                ? route('admin.shop.catalog.categories.update', $category)
                : route('admin.shop.catalog.categories.store')
        }}"
        enctype="multipart/form-data"
    >
        @csrf
        @if($category->id)
            @method('PUT')
        @endif

        <div class="card">
            <h4 class="card-header">
                {{ $category->id ? trans('actions.edit') : trans('actions.add') }}
                {{ Str::lower(trans('titles.categories.editor')) }}
                <a href="{{ route('admin.shop.catalog.categories.index') }}" class="btn btn-link">{{ trans('actions.back') }}</a>
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
                                    value="{{ old('name', $category->name) }}"
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
                            <label for="parentId" class="col-md-3 col-form-label">Parent</label>
                            <div class="col-md-9">
                                <select
                                    id="parentId"
                                    data-style="border"
                                    class="form-control{{ $errors->has('parent_id') ? ' is-invalid' : '' }}"
                                    name="parent_id"
                                >
                                    <option value="">Root</option>
                                    @foreach ($categories as $parent)
                                        <option
                                            value="{{ $parent->id }}"
                                            {{ $parent->id == old('parent', $category->parent_id) ? 'selected' : '' }}
                                            {{ $parent->isSelfOrDescendantOf($category) ? 'disabled' : '' }}
                                        >
                                            @for ($i = 0; $i < $parent->depth; $i++) &mdash; @endfor
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach;
                                </select>
                                @if ($errors->has('parent_id'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('parent_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-3 col-form-label">Image</label>
                            <div class="col-md-9">
                                @include('shop.catalog.categories.image')
                                @if ($errors->has('image'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('image') }}</strong>
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
                                >{{ old('description', $category->description) }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group border-top mt-4 mb-4"></div>

                        <div class="form-group row">
                            <label for="slug" class="col-md-3 col-form-label">Slug</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input
                                        id="slug"
                                        class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                        name="slug"
                                        value="{{ old('slug', $category->slug) }}"
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
                                >{{ old('meta_title', $category->meta_title) }}</textarea>
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
                                >{{ old('meta_keywords', $category->meta_keywords) }}</textarea>
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
                                >{{ old('meta_description', $category->meta_description) }}</textarea>
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
                                    <input class="form-control" value="{{ $category->created_at  }}" disabled>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Updated</label>
                            <div class="col-md-9">
                                <label>
                                    <input class="form-control" value="{{ $category->updated_at  }}" disabled>
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

