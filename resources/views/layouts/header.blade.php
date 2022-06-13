<div class="section-header">
    <h1>
        {{-- @if ($title == 'outgoing')
        {{__('Obat Keluar')}}    
        @elseif ($title == 'ingoing')
        {{__('Obat Masuk')}}
        @else --}}
        {{ucfirst($title)}}
        {{-- @endif --}}
    </h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item">
            @if (auth()->user()->role->name == 'manager')
            <a href="{{ route('manager.dashboard') }}">    
            @elseif (auth()->user()->role->name == 'kasir')
            <a href="{{ route('kasir.dashboard') }}">
            @elseif (auth()->user()->role->name == 'supplier')
            <a href="{{ route('supplier.dashboard') }}">
            @else
            <a href="#">
            @endif
                ECMS
            </a>
        </div>
        @if ($subtitle == null)
        <div class="breadcrumb-item active">
            @if (auth()->user()->role->name == 'manager')
            <a href="{{ route('manager.dashboard') }}">    
            @elseif (auth()->user()->role->name == 'kasir')
            <a href="{{ route('kasir.dashboard') }}">
            @elseif (auth()->user()->role->name == 'supplier')
            <a href="{{ route('supplier.dashboard') }}">
            @else
            <a href="#">
            @endif
                {{ $title }}
            </a>
        </div>
        @else
        @if ($title == 'dashboard')
        <div class="breadcrumb-item"><a href="#">{{ucfirst($title)}}</a></div>
        @else
        <div class="breadcrumb-item"><a href="{{ route($title.'.index', $id ?? '') }}">{{ucfirst($title)}}</a></div>
        @endif
        <div class="breadcrumb-item active">{{ucfirst($subtitle)}}</div>
        @endif
    </div>
</div>
