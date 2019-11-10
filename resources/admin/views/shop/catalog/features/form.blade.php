@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">
            <a href="{{ route('admin.shop.catalog.features.index') }}">{{ __('titles.features.all') }}</a>
            / {{ $feature->id ? $feature->name : __('actions.create') }}
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
            $feature->id
                ? route('admin.shop.catalog.features.update', $feature)
                : route('admin.shop.catalog.features.store')
        }}"
    >
        @csrf
        @if($feature->id)
            @method('PUT')
        @endif

        <div class="card">
            <h4 class="card-header">
                {{ $feature->id ? 'Edit' : 'Create' }} brand
                <a href="{{ route('admin.shop.catalog.features.index') }}" class="btn btn-link">Back</a>
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
                                    value="{{ old('name', $feature->name) }}"
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
                            <label for="inFilter" class="col-md-3 col-form-label">In filter</label>
                            <div class="col-md-9">
                                <div class="custom-control custom-switch d-inline-block mr-4">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="inFilter"
                                        name="in_filter"
                                        value="1"
                                        {{ old('in_filter', $feature->in_filter) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label" for="inFilter"></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="categoryIds" class="col-md-3 col-form-label">Use in categories</label>
                            <div class="col-md-9">
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
                                            {{ in_array($parent->id, $categoriesIds) ? 'selected' : '' }}
                                        >
                                            @for ($i = 0; $i < $parent->depth; $i++) &mdash; @endfor
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach;
                                </select>
                                @if ($errors->has('category_ids'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('category_ids') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group border-top mt-4 mb-4"></div>

                        <div class="form-group row">
                            <label for="sort" class="col-md-3 col-form-label">Sort</label>
                            <div class="col-md-9">
                                <input
                                    id="sort"
                                    class="form-control{{ $errors->has('sort') ? ' is-invalid' : '' }}"
                                    name="sort"
                                    value="{{ old('sort', $feature->sort) }}"
                                    required
                                >
                                @if ($errors->has('sort'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('sort') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Created</label>
                            <div class="col-md-9">
                                <label>
                                    <input class="form-control" value="{{ $feature->created_at  }}" disabled>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Updated</label>
                            <div class="col-md-9">
                                <label>
                                    <input class="form-control" value="{{ $feature->updated_at  }}" disabled>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">{{ $feature->id ? 'Save' : 'Add'}}</button>
            </div>
        </div>
    </form>
@endsection
