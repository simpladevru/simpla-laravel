@extends('layouts.wrap')

@section('wrap-content')
    <div class="page-header clearfix mb-3">
        <h1 class="page-title pull-left">Features</h1>
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

            <a href="{{ route('admin.shop.catalog.features.create') }}" class="btn btn-primary float-right">
                <i class="fa fa-plus-circle"></i> Add
            </a>
        </div>
        <div class="card-body p-0">
            <form action="" method="post" class="list-form">
                @csrf
                <table class="table table-hover table-striped mb-0">
                    <tr>
                        <th class="w-1 text-center">Id</th>
                        <th class="w-40">Name</th>
                        <th>Categories</th>
                        <th class="w-10 text-right">Edit</th>
                    </tr>
                    @foreach($features as $feature)
                        <tr>
                            <td class="text-center">{{ $feature->id }}</td>
                            <td>{{ $feature->name }}</td>
                            <td>
                                @foreach($feature->categories as $category)
                                    <span class="badge badge-info">{{ $category->name }}</span>
                                @endforeach
                            </td>
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
