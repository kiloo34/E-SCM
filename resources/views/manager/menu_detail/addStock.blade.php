@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{__("Tambah Stock")}} {{ucfirst($title)}} {{ucfirst($menu->name)}}</h4>
                <div class="card-header-action">
                    <a href="{{ route('menu.index') }}" class="btn btn-danger">{{__("Kembali")}}</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('manager.menu.storeStock', $menu->id) }}" method="post">
                {{-- <form action="#" method="post"> --}}
                    @csrf
                    <div class="form-group">
                        <label>{{__('Menu')}}</label>
                        <input type="hidden" name="name" value="{{$menu->id}}">
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ $menu->name }}" autocomplete="name" autofocus readonly>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{__('Kuantitas')}}</label>
                        <input name="kuantitas" id="kuantitas" type="number" class="form-control @error('kuantitas') is-invalid @enderror"
                            value="{{ old('kuantitas') }}" autocomplete="harga" autofocus>
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
        // $("#kategori").select2();
        // getKategori();
    });
</script>
@endpush
@include('import.select2')