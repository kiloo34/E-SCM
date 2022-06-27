@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{__("Tambah Data Detail Bahan Baku")}} {{ucfirst($menu->name)}}</h4>
                <div class="card-header-action"></div>
            </div>
            <div class="card-body">
                <form action="{{ route('manager.menu.storeDetailSupplyMenu', $menu->id) }}" method="post">
                {{-- <form action="#" method="post"> --}}
                    @csrf
                    <div class="form-group">
                        <label>{{__('Nama Bahan Baku')}}</label>
                        <select name="supply" id="supply" class="form-control @error('supply') is-invalid @enderror"></select>
                        @error('supply')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label>{{__('Nama')}}</label>
                        <input name="name" id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" autocomplete="name" onkeyup="totalHarga()" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> --}}
                    <div class="form-group">
                        <label>{{__('Bahan yang Dibutukan')}}</label>
                        <input name="kuantitas" id="kuantitas" type="text" class="form-control @error('kuantitas') is-invalid @enderror"
                            value="{{ old('kuantitas') }}" autocomplete="kuantitas" autofocus>
                        @error('kuantitas')
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
        $("#supply").select2();
        getSupply();
    });

    function getSupply() {
        var url = '{{ route("manager.menu.getSupplyField") }}';
        var select = $('#supply');
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