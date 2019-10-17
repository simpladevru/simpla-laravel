@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Features</h1>
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
