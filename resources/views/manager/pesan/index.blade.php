@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <h4>Daftar Pesanan {{$title == 'pesanan' ? 'Bahan Baku' : ucfirst($title)}}</h4>
                <div class="card-header-action">
                    <a href="{{ route('pesanan.create') }}" class="btn btn-success">Tambah {{$title == 'pesanan' ? 'Bahan Baku' : ucfirst($title)}}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="pesanan-table" class="table table-striped">
                        <thead>
                            <th>{{__('No')}}</th>
                            <th>{{__('Total Item')}}</th>
                            <th>{{__('Total Harga')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Aksi')}}</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#pesanan-table').DataTable({
            "language": {
                "emptyTable": "Data Stock Barang Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('manager.getAllSupplyOrder') }}",
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'total_item', name: 'total_item'},
                {data: 'price_total', name: 'price_total'}, 
                {data: 'status', name: 'status'}, 
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