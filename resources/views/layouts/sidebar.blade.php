<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            @if (auth()->user()->role->name == 'manager')
            <a href="{{ route('manager.dashboard') }}">    
            @elseif (auth()->user()->role->name == 'kasir')
            <a href="{{ route('kasir.dashboard') }}">
            @elseif (auth()->user()->role->name == 'supplier')
            <a href="{{ route('supplier.dashboard') }}">
            @else
            <a href="#">
            @endif
                {{__("ECMS")}}
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            @if (auth()->user()->role->name == 'manager')
            <a href="{{ route('manager.dashboard') }}">    
            @elseif (auth()->user()->role->name == 'kasir')
            <a href="{{ route('kasir.dashboard') }}">
            @elseif (auth()->user()->role->name == 'supplier')
            <a href="{{ route('supplier.dashboard') }}">
            @else
            <a href="#">
            @endif
                {{__("CMS")}}
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ $active == 'dashboard' ? 'active' : '' }}">
                @if (auth()->user()->role->name == 'manager')
                <a class="nav-link" href="{{ route('manager.dashboard') }}">    
                @elseif (auth()->user()->role->name == 'kasir')
                <a class="nav-link" href="{{ route('kasir.dashboard') }}">
                @elseif (auth()->user()->role->name == 'supplier')
                <a class="nav-link" href="{{ route('supplier.dashboard') }}">
                @else
                <a class="nav-link" href="#">
                @endif
                    <i class="far fa-home"></i>
                    <span>{{__('Dashboard')}}</span>
                </a>
            </li>
            <li class="menu-header">{{__("Menu")}}</li>
            @if (auth()->user()->role_id == 1)
            <li class="{{ $active == 'supply' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('supply.index') }}">
                    <i class="far fa-cubes"></i>
                    <span>{{__('Bahan Baku')}}</span>
                </a>
            </li>
            <li class="nav-item dropdown {{ $active == 'kategori' || $active == 'menu' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Menu</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $active == 'kategori' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('kategori.index') }}">{{__('Kategori Menu')}}</a>
                    </li>
                    <li class="{{ $active == 'menu' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('menu.index') }}">{{__('Menu')}}</a>
                    </li>
                </ul>
            </li>
            <li class="{{ $active == 'pesanan' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('pesanan.index') }}">
                    <i class="far fa-tag"></i>
                    <span>{{__('Order Bahan Baku')}}</span>
                </a>
            </li>
            @elseif (auth()->user()->role_id == 2)
            <li class="{{ $active == 'transaksi' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kasir_transaksi.index') }}">
                    <i class="far fa-tag"></i>
                    <span>{{__('Data Order')}}</span>
                </a>
            </li>
            @elseif (auth()->user()->role_id == 3)
            <li class="{{ $active == 'supply' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('supplier.index') }}">
                    <i class="far fa-cubes"></i>
                    <span>{{__('Stok Bahan Baku')}}</span>
                </a>
            </li>
            <li class="{{ $active == 'pesan' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('supplier_pesanan.index') }}">
                    <i class="far fa-tag"></i>
                    <span>{{__('Pesanan Bahan Baku')}}</span>
                </a>
            </li>
            @endif
        </ul>
    </aside>
</div>
