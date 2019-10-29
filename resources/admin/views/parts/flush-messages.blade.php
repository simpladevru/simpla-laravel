@if (session()->has('updated_all'))
    <div class="alert alert-success" role="alert">Записи обновлены</div>@endif
@if (session()->has('updated'))
    <div class="alert alert-success" role="alert">Запись обновлена</div>@endif
@if (session()->has('created'))
    <div class="alert alert-success" role="alert">Запись создана</div>@endif
@if (session()->has('deleted'))
    <div class="alert alert-danger" role="alert">Запись удалена</div>@endif
@if (session()->has('error'))
    <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>@endif
@if (session()->has('errors'))
    @foreach($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
@endif