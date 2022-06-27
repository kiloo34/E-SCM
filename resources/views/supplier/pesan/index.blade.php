@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <h4>Daftar {{$title == 'supply' ? 'Bahan Baku' : ucfirst($title)}}</h4>
                <div class="card-header-action">
                    <a href="{{ route('supplier.create') }}" class="btn btn-success">Tambah {{$title == 'pesanan' ? 'Bahan Baku' : ucfirst($title)}}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="supply-table" class="table table-striped">
                        <thead>
                            <th>{{__('No')}}</th>
                            <th>{{__('Nama Item')}}</th>
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
        $('#supply-table').DataTable({
            "language": {
                "emptyTable": "Data Order Supply Barang Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('supplier.getSupplyOrder') }}",
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nama_item', name: 'nama_item'},
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
    });

    function toastEvent(title, message, position, type) {
        if (type == 'error') {
            iziToast.error({
                title: title,
                message: message,
                position: position
            });   
        } else {
            iziToast.success({
                title: title,
                message: message,
                position: position
            });
        }
    }

    function reloadTable(selector, counter) {
        // updateTotal()
        setTimeout(function() {
            $(selector).DataTable().ajax.reload();
        }, 100);
    }

    function cancelItem(id) {
        var url = "{{ route('supplier.cancelOrder', ":id") }}";
        url = url.replace(':id', id);
        
        console.log(url);

        Swal.fire({
            title: 'Apa anda Yakin?',
            text: "Yakin ingin menolak Order Bahan Baku ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {id: id},
                    success: function (response) {
                        toastEvent('Success!', response.message, 'topRight', 'success')
                        reloadTable('#supply-table', 100);
                    },
                    error: function (data) {
                        toastEvent('Error!', 'internal server error (500)', 'topRight', 'error')
                    }
                });
            }
        });
    }

    function updateItem(id) {
        var url = "{{ route('supplier_pesanan.update', ":id") }}";
        url = url.replace(':id', id);
        
        console.log(url);

        Swal.fire({
            title: 'Apa anda Yakin?',
            text: "Yakin ingin Mengubah Status Order Bahan Baku?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {id: id, '_method':'PUT'},
                    success: function (response) {
                        console.log('masuk success');
                        console.log(response);
                        toastEvent('Success!', response.message, 'topRight', 'success')
                        reloadTable('#supply-table', 100);
                    },
                    error: function (data) {
                        console.log('masuk error');
                        toastEvent('Error!', 'internal server error (500)', 'topRight', 'error')
                    }
                });
            }
        });
    }

    // $('.hapus-obat').on('click', function (e) {
    //     e.preventDefault();

    //     var id = $(this).data("id");
    //     // var url = $('.hapus').attr('href');
    //     var url = "{{ route('supplier.cancelOrder', ":id") }}";
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