@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Products</h1>
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
            <a href="{{ route('admin.shop.catalog.products.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus-circle"></i> Add
            </a>
        </div>
        <form action="{{ route('admin.shop.catalog.products.groupAction') }}" method="post" class="list-form">
            <div class="card-body p-0">
                @csrf
                <table class="table table-hover table-striped mb-0">
                    <tr>
                        <th>Id</th>
                        <th>image</th>
                        <th class="w-50">Name</th>
                        <th class="w-25">Variants</th>
                        <th></th>
                    </tr>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                <img
                                    src="{{ $product->image ? $product->image->getResizedUrl(45, 45) : '' }}"
                                    alt=""
                                    class="img-thumbnail"
                                    style="max-width: 45px; max-height: 45px"
                                >
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @foreach($product->variants as $variant)
                                    <div class="variants">

                                        <div class="form-row">
                                            <div class="col-md-4">
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
