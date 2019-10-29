@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Brands</h1>
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
                {{ $brands->total() }}
            </div>

            <a href="{{ route('admin.shop.catalog.brands.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus-circle"></i> Add
            </a>
        </div>
        <div class="card-body p-0">
            <form action="" method="post" class="list-form">
                @csrf
                <table class="table table-hover table-striped mb-0">
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th class="w-50">Name</th>
                        <th class="w-25">Edit</th>
                    </tr>
                    @foreach($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>
                                <img
                                    src="{{ $brand->getResizedUrl(80, 80) }}"
                                    alt=""
                                    class="img-thumbnail"
                                    style="max-width: 80px; max-height: 80px"
                                >
                            </td>
                            <td>{{ $brand->name }}</td>
                            <td>
                                <div class="float-right">
                                    <a
                                        href="{{ route('admin.shop.catalog.brands.edit', $brand) }}"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-toggle="tooltip"
                                        data-original-title="Edit"
                                    ><i class="fa fa-pencil"></i></a>
                                    <a
                                        href="{{ route('admin.shop.catalog.brands.destroy', $brand) }}"
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
            {{ $brands->appends(request()->all())->links() }}
        </div>
    </div>
@endsection
