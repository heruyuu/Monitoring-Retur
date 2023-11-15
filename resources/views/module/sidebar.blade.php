<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="#">Monitoring Retur</a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Home</li>

                <li class="sidebar-item">
                    <a href="{{ asset('/') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Menu &amp; Forms</li>
                @if (auth()->user()->level == 'Admin')
                    <li class="sidebar-item">
                        <a href="{{ asset('user') }}" class='sidebar-link'>
                            <i class="fa fa-users"></i>
                            <span>User</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ asset('toko') }}" class='sidebar-link'>
                            <i class="fa fa-store"></i>
                            <span>Toko</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ asset('produk') }}" class='sidebar-link'>
                            <i class="fa fa-boxes"></i>
                            <span>Produk</span>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->level == 'Toko')
                    <li class="sidebar-item">
                        <a href="{{ asset('retur') }}" class='sidebar-link'>
                            <i class="fa fa-file-medical"></i>
                            <span>Buat Retur</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
