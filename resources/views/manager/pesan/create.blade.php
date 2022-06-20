@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Buat Pesanan {{$title == 'supply' ? 'Bahan Baku' : ucfirst($title)}}</h4>
                <div class="card-header-action">
                    <a href="{{ route('pesanan.index') }}" class="btn btn-danger">Kembali </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('supply.store') }}" method="post">
                    @csrf
                    <div class="table-responsive">
                        <table id="detail-supply-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{__('#')}}</th>
                                    <th>{{__('Nama')}}</th>
                                    <th>{{__('@')}}</th>
                                    <th>{{__('Kuantitas')}}</th>
                                    <th>{{__('Total Harga')}}</th>
                                    <th>{{__('Aksi')}}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <th colspan="4" class="text-right">{{__('Total')}}</th>
                                <th>hasil</th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                    {{-- <div class="form-group">
                        <label>{{__('Tipe Obat')}}</label>
                        <select name="tipe" id="tipe" class="form-control @error('tipe') is-invalid @enderror">
                            @foreach ($tipe as $t)
                                <option value="{{$t->id}}">{{$t->name}}</option>
                            @endforeach
                        </select>
                        @error('tipe')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
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
                    <div class="form-group">
                        <label>{{__('Satuan')}}</label>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mt-2">
                                <div class="form-group">
                                <div class="input-group">
                                    <input name="mg" type="text" class="form-control @error('mg') is-invalid @enderror"
                                        value="{{ old('mg') }}" autocomplete="mg" autofocus>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            mg
                                        </div>
                                    </div>
                                </div>
                                @error('mg')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mt-2">
                                <div class="form-group">
                                <div class="input-group">
                                    <input name="ml" type="text" class="form-control @error('ml') is-invalid @enderror"
                                        value="{{ old('ml') }}" autocomplete="ml" autofocus>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            ml
                                        </div>
                                    </div>
                                </div>
                                @error('ml')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                </div>
                            </div>    
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary float-right" value="Tambah"> --}}
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('supply.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{__('Nama')}}</label>
                        <select name="name" id="name" class="form-control @error('tipe') is-invalid @enderror"></select>
                        {{-- <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" autocomplete="name" autofocus> --}}
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Kuantitas')}}</label>
                                <input name="qty" id="qty" type="text" class="form-control @error('qty') is-invalid @enderror"
                                    value="{{ old('qty') }}" autocomplete="qty" onkeyup="totalHarga()" autofocus>
                                @error('qty')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('Harga')}}</label>
                                <input name="price" id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" autocomplete="price" autofocus readonly>
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__('Total Harga')}}</label>
                        <input name="total" id="total" type="text" class="form-control @error('total') is-invalid @enderror"
                            value="{{ old('total') }}" autocomplete="total" autofocus readonly>
                        @error('total')
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
        $("#name").select2();
        getNama();

        $('#detail-supply-table').DataTable({
            "language": {
                "emptyTable": "Data Order Supply Barang Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('manager.getSupplyDetailOrder') }}",
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name',orderable: false, searchable: false},
                {data: 'satuan', name: 'satuan',orderable: false, searchable: false}, 
                {data: 'qty', name: 'qty',orderable: false, searchable: false}, 
                {data: 'price', name: 'price',orderable: false, searchable: false}, 
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ],
        });
        $('#supply-table').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
    });

    function getNama() {
        var url = '{{ route("manager.getAllSupply") }}';
        var select = $('#name');
        const a = '<option value=null>Pilih Nama Bahan Baku</option>'

        $.get(url, function(data) {
            select.empty();
            select.append(a)
            $.each(data, function(key, value) {
                select.append('<option value=' + value.id + '>' + value.name + '</option>');
            });
        });
    }

    $('#name').change(function() {
        var target = $(this).val();
        var url = '{{ route("manager.getPrice", ':id') }}';
        url = url.replace(':id', target);
        console.log(url);
        $.get(url, function(data) {
            var input = $('#price');
            input.empty();
            input.val(data.price)
        });
    })

    function totalHarga() {
        var qty = $('#qty').val();
        var harga = $('#price').val();
        var hasil = 0;
        var input = $('#total');

        if (harga == '') {
            iziToast.error({
                title: 'Error!',
                message: 'isi Data Bahan Baku dahulu',
                position: 'topRight'
            });
        } else {
            input.empty();
            hasil = qty * harga;
            input.val(hasil)
        }
    }

    // $('.hapus-obat').on('click', function (e) {
    //     e.preventDefault();

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     var id = $(this).data("id");
    //     // var url = $('.hapus').attr('href');
    //     var url = "{{ route('supply.destroy', ":id") }}";
    //     url = url.replace(':id', id);
    //     $object=$(this);

    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "Yakin ingin menghapus Data Obat ini!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Ya!'
    //     }).then((result) => {
    //         if (result.value) {
    //             $.ajax({
    //                 url: url,
    //                 type: 'DELETE',
    //                 data: {id: id},
    //                 success: function (response) {
    //                     $($object).parents('tr').remove();
    //                     Swal.fire({
    //                         title: "Data Dihapus!",
    //                         text: response.message,
    //                         icon: 'success',
    //                     });
    //                     reloadPage(2000);
    //                 },
    //                 error: function (data) {
    //                     console.log(data);
    //                     Swal.fire({
    //                         title: "Data Gagal Dihapus!",
    //                         icon: 'error',
    //                     })
    //                 }
    //             });
    //         }
    //     });
    // })

    // $('.update-status-obat').on('click', function (e) {
    //     e.preventDefault();
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     var id = $(this).data("id");
    //     var url = "{{ route('supply.update', ":id") }}";
    //     url = url.replace(':id', id);
    //     $object=$(this);

    //     console.log(url, id);

    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "Yakin Ubah status Data Order ini!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Ya!'
    //     }).then((result) => {
    //         if (result.value) {
    //             $.ajax({
    //                 url: url,
    //                 type: 'PUT',
    //                 data: {id: id, '_method':'PUT'},
    //                 success: function (response) {
    //                     // $($object).parents('tr').remove();
    //                     Swal.fire({
    //                         title: "Data Diupdate!",
    //                         text: response.message,
    //                         icon: 'success',
    //                     });
    //                     reloadPage(2500);
    //                 },
    //                 error: function (jqXHR, textStatus, errorThrown) {
    //                     console.log(jqXHR, textStatus, errorThrown);
    //                     Swal.fire({
    //                         title: "Data Gagal Diupdate!",
    //                         icon: 'error',
    //                     })
    //                 }
    //             });
    //         }
    //     });
    // })

    // function reloadPage(counter) {
    //     setTimeout(function () { 
    //         location.reload();
    //     }, counter)
    // }
</script>
@endpush
@include('import.datatable')
@include('import.select2')
@include('import.toastr')