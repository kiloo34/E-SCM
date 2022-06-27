@extends('layouts.myview')
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-header">
                <h4>{{__("Daftar Bahan Baku")}} {{ucfirst($menu->name)}}</h4>
                <div class="card-header-action">
                    <a href="{{ route('menu.index') }}" class="btn btn-danger">{{__("Kembali")}}</a>
                    <a href="{{ route('manager.menu.addDetailSupplyMenu', $menu->id) }}" class="btn btn-success">{{__("Tambah Bahan Baku")}} {{ucfirst($menu->name)}}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- <input type="hidden" name=""> --}}
                    <table id="detail-supply-menu-table" class="table table-striped">
                        <thead>
                            <th>{{__('No')}}</th>
                            {{-- <th>{{__('Nama Bahan Baku')}}</th> --}}
                            <th>{{__('Bahan yang dibutuhkan')}}</th>
                            <th>{{__('Kuantitas')}}</th>
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

        var urlDetailOrder = "{{ route('manager.menu.getDetailSupplyMenu', ":id") }}"
        var id = {{$menu->id}}
        urlDetailMenu = urlDetailOrder.replace(':id', id)

        $('#detail-supply-menu-table').DataTable({
            "language": {
                "emptyTable": "Data Kosong"
            },
            "processing": true,
            "serverSide": true,
            "ajax": urlDetailMenu,
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
        $('#detail-supply-menu-table').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
    });
</script>
@endpush
@include('import.datatable')