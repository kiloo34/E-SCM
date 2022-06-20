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
            <li class="menu-header">{{__("Pesan")}}</li>
            <li class="{{ $active == 'pesan' ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="far fa-comment"></i>
                    <span>{{__('Pesan')}}</span>
                </a>
            </li>
            @elseif (auth()->user()->role_id == 2)
            {{-- <li class="{{ $active == 'kasir' ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="far fa-tag"></i>
                    <span>{{__('Kasir')}}</span>
                </a>
            </li> --}}
            @elseif (auth()->user()->role_id == 3)
            <li class="{{ $active == 'stok' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('supplier.index') }}">
                    <i class="far fa-cubes"></i>
                    <span>{{__('Stok Barang')}}</span>
                </a>
            </li>
            <li class="menu-header">{{__("Pesan")}}</li>
            <li class="{{ $active == 'pesan' ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="far fa-comment"></i>
                    <span>{{__('Pesan')}}</span>
                </a>
            </li>
            @endif
            {{-- <li class="nav-item dropdown {{ $active == 'produksi' || $active == 'permintaan' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-seedling"></i><span>Buah Naga</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $active == 'produksi' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('produksi.index') }}">{{__('Produksi')}}</a>
                    </li>
                    <li class="{{ $active == 'permintaan' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('permintaan.index') }}">{{__('Permintaan')}}</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="{{ $active == 'obat' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('obat.index') }}">
                    <i class="far fa-pills"></i>
                    <span>{{__('Obat')}}</span>
                </a>
            </li>
            <li class="menu-header">{{__("Transaksi")}}</li> --}}
            {{-- <li class="{{ $active == 'order' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('order.index') }}">
                    <i class="far fa-tag"></i>
                    <span>{{__('Stok Obat')}}</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item dropdown {{ $active == 'outgoing' || $active == 'permintaan' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-tag"></i><span>{{__('Stok Obat')}}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $active == 'permintaan' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('ingoing.index') }}">{{__('Obat Masuk')}}</a>
                    </li>
                    <li class="{{ $active == 'outgoing' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('outgoing.index') }}">{{__('Obat Keluar')}}</a>
                    </li>
                </ul>
            </li>
            <li class="{{ $active == 'peramalan' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.forecasting') }}">
                    <i class="far fa-bullseye"></i>
                    <span>{{__('Peramalan')}}</span>
                </a>
            </li>
            <li class="{{ $active == 'rekap' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('rekap.index') }}">
                    <i class="far fa-seedling"></i>
                    <span>{{__('Rekap Data')}}</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item dropdown {{ $active == '' || $active == 'permintaan' ? '' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-seedling"></i><span>{{__('Rekap Data')}}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $active == '' ? 'active' : '' }}">
                        <a class="nav-link" href="#">{{__('Masuk')}}</a>
                    </li>
                    <li class="{{ $active == 'permintaan' ? 'active' : '' }}">
                        <a class="nav-link" href="#">{{__('Keluar')}}</a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="nav-item dropdown {{ $active == 'forePro' || $active == 'forePer' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Peramalan</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ $active == 'forePro' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('forecast.produksi.index') }}">Produksi</a>
                    </li>
                    <li class="{{ $active == 'forePer' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('forecast.permintaan.index') }}">Permintaan</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">{{__("Pengaturan")}}</li>
            <li class="nav-item dropdown {{ $active == 'profil' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('mantri.index') }}">
                    <i class="far fa-cogs"></i>
                    <span>{{__('Profil')}}</span>
                </a>
            </li> --}}
            {{-- @endif --}}
        </ul>
    </aside>
</div>
