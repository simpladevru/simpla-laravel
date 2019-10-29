@if(!empty($items))
    <ol class="breadcrumb">
        @foreach(array_filter($items) as $item)
            @if(!$loop->last)
                <li class="breadcrumb-item active"><a href="{{ $item['route'] }}">{{ $item['name'] }}</a></li>
            @else
                <li class="breadcrumb-item">{{ $item['name'] }}</li>
            @endif
        @endforeach
    </ol>
@endif
