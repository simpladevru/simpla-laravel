@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">{{ trans('titles.products') }}</h1>
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
                {{ $products->total() }}
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
                <a href="{{ route('admin.shop.catalog.products.create') }}" class="btn btn-primary">
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

                    @if($brands)
                        <div class="col col-3 mb-3">
                            <select name="brand_id[]" data-style="border" class="form-control selectpicker" data-live-search="true" multiple>
                                <option value=""></option>
                                @foreach($brands as $brand)
                                <option
                                    value="{{ $brand->id }}"
                                    {{ in_array($brand->id, request()->get('brand_id', [])) ? 'selected' : '' }}
                                >{{ $brand->name }}</option>
                                @endforeach
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
        <form action="{{ route('admin.shop.catalog.products.groupAction') }}" method="post" class="list-form">
            <div class="card-body p-0">
                @csrf
                <table class="table table-hover table-striped mb-0">
                    <tr>
                        <th class="w-1">Id</th>
                        <th class="w-1">image</th>
                        <th class="w-50">Name</th>
                        <th class="w-25">Variants</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                <img
                                    src="{{ $product->image ? $product->image->getResizedUrl(60, 60) : '' }}"
                                    alt=""
                                    class="img-thumbnail"
                                    style="max-width: 60px; max-height: 60px"
                                >
                            </td>
                            <td>
                                <a href="{{ route('admin.shop.catalog.products.edit', $product) }}">{{ $product->name }}</a>
                                @if($product->brand)
                                    <div class="text-small">
                                        <span class="text-muted">Бренд:</span> {{ $product->brand->name }}
                                    </div>
                                @endif
                                @if($product->category)
                                    <div class="text-small">
                                        <span class="text-muted">Категория:</span> {{ $product->category->name }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @foreach($product->variants as $variant)
                                    <div class="variants">
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <input
                                                    type="hidden"
                                                    name="variants[{{ $variant->id }}][id]"
                                                    value="{{ $variant->id }}"
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm mb-1"
                                                    placeholder="Name"
                                                    name="variants[{{ $variant->id }}][name]"
                                                    value="{{ $variant->name }}"
                                                >
                                            </div>
                                            <div class="col-md-4">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm mb-1"
                                                    placeholder="Price"
                                                    name="variants[{{ $variant->id }}][price]"
                                                    value="{{ $variant->price }}"
                                                >
                                            </div>
                                            <div class="col-md-4">
                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm mb-1"
                                                    placeholder="Stock"
                                                    name="variants[{{ $variant->id }}][stock]"
                                                    value="{{ $variant->stock }}"
                                                >
                                            </div>
                                        </div>
                                @endforeach
                            </td>
                            <td>
                                <div class="float-right">
                                    <a
                                        href="{{ route('admin.shop.catalog.products.edit', $product) }}"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-toggle="tooltip"
                                        data-original-title="Edit"
                                    ><i class="fa fa-pencil"></i></a>
                                    <a
                                        href="{{ route('admin.shop.catalog.products.copy', $product) }}"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-toggle="tooltip"
                                        data-original-title="Copy"
                                    ><i class="fa fa-clone"></i></a>
                                    <a
                                        href="{{ route('admin.shop.catalog.products.destroy', $product) }}"
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
            </div>
            <div class="card-footer pt-4 pb-2">
                <button type="submit" class="btn btn-primary float-right">Save</button>
                {{ $products->appends(request()->all())->links() }}
            </div>
        </form>
    </div>
@endsection
