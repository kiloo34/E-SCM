@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Data {{$title == 'supply' ? 'Bahan Baku' : ucfirst($title)}}</h4>
                <div class="card-header-action">
                    <a href="{{ route('supplier.index') }}" class="btn btn-danger">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('supplier.store') }}" id="supply-form" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{__('Nama')}}</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('Status')}}</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"></select>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('Kuantitas')}}</label>
                                <input name="qty" id="qty" type="text" class="form-control @error('qty') is-invalid @enderror"
                                    value="{{ old('qty') }}" autocomplete="qty" autofocus value="0" readonly>
                                @error('qty')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{__('Harga')}}</label>
                                <input name="price" id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" autocomplete="price" autofocus>
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
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
        $("#status").select2();
        getStatus();
        // $('#supply-form').validate({
        //     rules: {
        //         qty: {
        //             digits: true
        //         },
        //         price: {
        //             digits: true
        //         }
        //     }
        // });
    });
</script>
@endpush
@include('import.datatable')
@include('import.select2')
@include('import.toastr')