@extends('layouts.wrap')

@section('breadcrumb')
    @include('parts.breadcrumb', ['items' => array_merge(
        [['name'  => trans('titles.categories.all'), 'route' => route('admin.shop.catalog.categories.index')]],
        $category ? $category->getAncestorsAndSelf()->map(function ($ancestor) {
            return ['name' => $ancestor->name, 'route' => route('admin.shop.catalog.categories.children', $ancestor)];
        })->toArray() : []
    )])
@endsection

@section('wrap-content')
    <div class="page-header clearfix">
        <h1 class="page-title pull-left">{{ trans('titles.categories') }}</h1>
    </div>

    @yield('breadcrumb')

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="p-2 float-left">
                {{ $categories->total() }}
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
                <a href="{{ route('admin.shop.catalog.categories.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> {{ trans('actions.add') }}
                </a>
            </div>
        </div>
        <div class="collapse p-3 @if( request()->has('keyword') ) show @endif bg-light" id="collapseFilter">
            <form method="get">
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
                        <th class="w-5 text-center">Image</th>
                        <th class="w-50">Name</th>
                        <th class="w-15">Count products</th>
                        <th class="w-15 text-right">Edit</th>
                    </tr>
                    @foreach($categories as $category)
                        <tr>
                            <td class="text-center">{{ $category->id }}</td>
                            <td class="text-center">
                                <img
                                    src="{{ $category->getResizedUrl(45, 45) }}"
                                    alt=""
                                    class="img-thumbnail"
                                    style="max-width: 45px; max-height: 45px"
                                >
                            </td>
                            <td>
                                @if(request()->has('keyword') && $category->ancestors->count() > 0)
                                    <small class="text-secondary">{{ implode(' / ', $category->ancestors->pluck('name')->toArray()) }}</small><br>
                                @endif
                                @if( $category->descendants_count == 0 )
                                    {{ $category->name }}
                                @else
                                    <a href="{{ route('admin.shop.catalog.categories.children', $category->id) }}">
                                        {{ $category->name }}
                                    </a>
                                    <small class="text-secondary">
                                        ({{ $category->descendants_count }} {{ Str::lower(trans_choice('titles.categories.plural', $category->descendants_count)) }})
                                    </small>
                                @endif
                            </td>
                            <td>
                                {{ $counter->get($category->id, 0) }}
                            </td>
                            <td>
                                <div class="float-right">
                                    <a
                                        href="{{ route('admin.shop.catalog.categories.edit', $category) }}"
                                        class="btn btn-outline-secondary btn-sm"
                                        data-toggle="tooltip"
                                        data-original-title="Edit"
                                    ><i class="fa fa-pencil"></i></a>
                                    <a
                                        href="{{ route('admin.shop.catalog.categories.destroy', $category) }}"
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
            {{ $categories->appends(request()->all())->links() }}
        </div>
    </div>
@endsection
