@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">{{ __('titles.features.all') }}</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="p-2 float-left">
                {{ $features->total() }}
            </div>
            <div class="float-right">
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseFilter" role="button" aria-expanded="false" aria-controls="collapseFilter">
                        <i class="fa fa-filter"></i> {{ trans('actions.filter') }}
                    </button>
                    @if( request()->has('keyword') )
                        <a href="{{ request()->url() }}" class="btn btn-outline-secondary">
                            <i class="fa fa-times"></i> {{ trans('actions.reset') }}
                        </a>
                    @endif
                </div>
                <a href="{{ route('admin.shop.catalog.features.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('actions.add') }}
                </a>
            </div>
        </div>
        <div class="collapse p-3 @if( request()->has('keyword') ) show @endif bg-light" id="collapseFilter">
            <form method="get">
                <div class="row">
                    @if($categories)
                        <div class="col col-3 mb-3">
                            <select multiple name='category_id[]' data-style="border" class="form-control selectpicker" data-live-search="true">
                                <option></option>
                                @foreach ($categories as $parent)
                                    <option
                                        value="{{ $parent->id }}"
                                        {{ in_array($parent->id, (array) request()->get('category_id')) ? 'selected' : '' }}
                                    >
                                        @for ($i = 0; $i < $parent->depth; $i++) &mdash; @endfor
                                        {{ $parent->name }}
                                    </option>
                                @endforeach;
                            </select>
                        </div>
                    @endif
                    <div class="col col-3 mb-3">
                        <button class="btn btn-outline-primary" type="submit">Найти</button>
                    </div>
                </div>
                <div class="input-group">
                    <input name="keyword" type="text" class="form-control" placeholder="{{ __('actions.searching') }}" value="{{ request()->get('keyword') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <form action="" method="post" class="list-form">
                @csrf
                <table class="table table-hover table-striped mb-0">
                    <tr>
                        <th class="w-1 text-center">Id</th>
                        <th class="w-40">Name</th>
                        <th class="w-10 text-right">Actions</th>
                    </tr>
                    @foreach($features as $feature)
                        <tr>
                            <td class="text-center">{{ $feature->id }}</td>
                            <td>{{ $feature->name }}</td>
                            <td>
                                <div class="float-right">
                                    <a
                                        href="{{ route('admin.shop.catalog.features.edit', $feature) }}"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-toggle="tooltip"
                                        data-original-title="Edit"
                                    ><i class="fa fa-pencil"></i></a>
                                    <a
                                        href="{{ route('admin.shop.catalog.features.destroy', $feature) }}"
                                        data-method="DELETE"
                                        data-confirm="Confirm"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-toggle="tooltip"
                                        data-original-title="Delete"
                                    ><i class="fa fa-trash-o"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </form>
        </div>
        <div class="card-footer pt-4 pb-2">
            {{ $features->appends(request()->all())->links() }}
        </div>
    </div>
@endsection
