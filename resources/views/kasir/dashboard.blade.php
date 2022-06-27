@extends('layouts.myview')
@section('content')
{{-- <div class="row">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Menux</h4>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="menu-table">
                    <thead>
                        <th class="text-center">#</th>
                        <th>{{__('Nama')}}</th>
                        <th>{{__('stok')}}</th>
                        <th>{{__('aksi')}}</th>
                    </thead>
                </table>
            </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-4 col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4>Detail Order </h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mt-3">
                    <span>Nama Menu</span> 
                    <span>
                        <span>Harga</span><br>
                        <span>Qty</span>
                    </span>
                </div>
                <hr> --}}
                {{-- if --}}
                {{-- @foreach ($collection as $item)
                    
                @endforeach --}}
                {{-- {{-- <div class="d-flex justify-content-between mt-3">
                    <span>contracted Price</span> <span>$186.86</span>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <span>Amount Deductible</span> 
                    <span class="lh-sm">
                        <span>$0.0</span><br/>
                        <span>x3</span>
                    </span>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <span>Coinsurance(0%)</span> 
                    <span>+ $0.0</span>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <span>Copayment </span> <span>+ 40.00</span>
                </div>
                <hr />
                <div class="d-flex justify-content-between mt-3">
                    <span class="lh-sm"
                    >Total Deductible,<br />
                    Coinsurance and copay
                    </span>
                    <span>$40.00</span>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <span class="lh-sm"
                    >Maximum out-of-pocket <br />
                    on insurance policy</span
                    >
                    <span>$40.00</span>
                </div>
                <hr />
                <div class="d-flex justify-content-between mt-3">
                    <span>Insurance Responsibility </span> <span>$71.76</span>
                </div> --}}
                {{-- <div class="d-flex justify-content-between mt-3">
                    <span>Nama Menu </span> 
                    <span>
                        <span>item</span><br>
                        <span>harga</span>
                    </span>
                </div> 
                <hr />
                <div class="d-flex justify-content-between mt-3">
                    <span>Total </span> <span class="text-success">$85.00</span>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Detail</h4>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table-2">
                    <thead>
                        <th class="text-center">#</th>
                        <th>Task Name</th>
                        <th>Progress</th>
                        <th>Members</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
@push('scripts')
<script>
    // $(document).ready(function() { 
    //     $('#menu-table').DataTable({
    //         "language": {
    //             "emptyTable": "Menu Kosong"
    //         },
    //         "processing": true,
    //         "serverSide": true,
    //         "ajax": "{{ route('kasir.getMenu') }}",
    //         "columns": [
    //             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //             {data: 'name', name: 'name'},
    //             {data: 'stock', name: 'stock'},
    //             {
    //                 data: 'action', 
    //                 name: 'action', 
    //                 orderable: false, 
    //                 searchable: false
    //             },
    //         ],
    //     });
    //     $('#menu-table').on('draw.dt', function() {
    //         $('[data-toggle="tooltip"]').tooltip();
    //     })
    // })
</script>
@endpush
{{-- @include('import.datatable') --}}