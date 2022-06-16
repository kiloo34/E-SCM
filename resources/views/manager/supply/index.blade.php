@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <h4>Daftar {{$title == 'supply' ? 'Bahan Baku' : ucfirst($title)}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="supply-table" class="table table-striped">
                        <thead>
                            <th>{{__('No')}}</th>
                            <th>{{__('Nama')}}</th>
                            <th>{{__('Stock Sisa')}}</th>
                            <th>{{__('Aksi')}}</th>
                        </thead>
                        <tbody>
                            {{-- <?php $no=1 ?>
                            @foreach ($order as $o)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$o->invoice_number}}</td>
                                <td>{{$o->status_transaksi->name}}</td>
                                <td>{{$o->created_at == null ? '-' : $o->created_at}}</td>
                                <td>
                                    @if ($o->status_id != 4)
                                    <a href="{{ route('ingoing.edit', $o->id) }}" 
                                        class="btn btn-sm btn-icon icon-left btn-primary update-status-obat" 
                                        data-id="{{ $o->id }}">
                                        <i class="far fa-edit"></i> 
                                        @if ($o->status_id == 1)
                                        {{__('Bayar')}}
                                        @elseif ($o->status_id == 2)
                                        {{__('Kirim')}}
                                        @elseif ($o->status_id == 3)
                                        {{__('Selesai')}}
                                        @endif
                                    </a>
                                    <a href="{{ route('ingoing.destroy', $o->id) }}"
                                        class="btn btn-sm btn-danger hapus-obat" data-toggle="tooltip" data-placement="top"
                                        title="Hapus Data" data-id="{{ $o->id }}">
                                        <i class="fa fa-trash"></i> Batal
                                    </a>
                                    @endif
                                    <a href="{{ route('ingoing.show', $o->id) }}" class="btn btn-sm btn-icon icon-left btn-info" ><i class="far fa-info"></i> {{__('Detail')}}</a>
                                </td>
                                <?php $no++ ?>
                            </tr>
                            @endforeach --}}
                        </tbody>
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
                "emptyTable": "Data Stock Barang Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('manager.getSupply') }}",
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'stock', name: 'stock'}, 
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ],
        });
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