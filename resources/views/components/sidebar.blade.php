<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('atlantis-assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            Hizrian
                            <span class="user-level">Administrator</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#edit">
                                    <span class="link-collapse">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#settings">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i><p>Dashboard</p></a></li>

                @switch(Auth::user()->role->level)
                    @case('1')
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Master Data</h4></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-book"></i><p>Data Daftar Akuntansi</p></a></li>
                        <li class="nav-item"><a href="{{ route('user.index') }}"><i class="fas fa-user"></i><p>Data Admin</p></a></li>
                        <li class="nav-item"><a href="{{ route('role.index') }}"><i class="fas fa-user-circle"></i><p>Data Jabatan</p></a></li>
                        <li class="nav-item"><a href="{{ route('customer.index') }}"><i class="fas fa-users"></i><p>Data Pelanggan</p></a></li>
                        <li class="nav-item"><a href="{{ route('package.index') }}"><i class="fas fa-archive"></i><p>Data Paket</p></a></li>
                        <li class="nav-item"><a href="{{ route('supplier.index') }}"><i class="fas fa-user-secret"></i><p>Data Supplier</p></a></li>

                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Transaksi</h4></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-money-bill-wave"></i><p>Pembelian</p></a></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-receipt"></i><p>Penjualan</p></a></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-piggy-bank"></i><p>Pengeluaran Kas</p></a></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-bookmark"></i><p>Jurnal Umum</p></a></li>

                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Laporan</h4></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-book-open"></i><p>Buku Besar</p></a></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-file-invoice"></i><p>Laporan Pembelian</p></a></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-file-invoice-dollar"></i><p>Laporan Penjualan</p></a></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-chart-line"></i><p>Laporan Laba Rugi</p></a></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-hand-holding-usd"></i><p>Laporan Posisi Keuangan</p></a></li>
                        <li class="nav-item"><a href="{{ route('account.index') }}"><i class="fas fa-balance-scale"></i><p>Neraca Saldo</p></a></li>
                    @break

                    @case('2')
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Transaksi</h4></li>
                    @break

                    @default
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Laporan</h4></li>
                @endswitch

            </ul>
        </div>
    </div>
</div>
