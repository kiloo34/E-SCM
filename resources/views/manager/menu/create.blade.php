@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Buat {{ucfirst($title)}}</h4>
                <div class="card-header-action"></div>
            </div>
            <div class="card-body">
                <form action="{{ route('menu.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{__('Kategori')}}</label>
                        <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror"></select>
                        @error('kategori')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{__('Nama')}}</label>
                        <input name="name" id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{__('Harga')}}</label>
                        <input name="harga" id="harga" type="text" class="form-control @error('harga') is-invalid @enderror"
                            value="{{ old('harga') }}" autocomplete="harga" autofocus>
                        @error('harga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-primary float-right" value="Tambah">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $("#kategori").select2();
        getKategori();
    });

    function getKategori() {
        var url = '{{ route("manager.menu.getKategori") }}';
        var select = $('#kategori');
        const a = '<option value="">Pilih Kategori Menu</option>'

        $.get(url, function(data) {
            // console.log(data);
            select.empty();
            select.append(a)
            $.each(data, function(key, value) {
                console.log(value);
                select.append('<option value=' + value.id + '>' + value.name + '</option>');
            });
        });
    }
</script>
@endpush
@include('import.select2')