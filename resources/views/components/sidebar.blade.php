<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i><p>Dashboard</p></a></li>
                @if (Auth::user()->role->level !== null)
                @switch(Auth::user()->role->level)
                    @case('1')
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Master Data</h4></li>
                        <li class="nav-item">
                            <a data-toggle="collapse" href="#akun"><i class="fas fa-book"></i><p>Daftar Akun</p><span class="caret"></span></a>
                            <div class="collapse" id="akun">
                                <ul class="nav nav-collapse">
                                    <li><a href="{{ route('account.index') }}"><span class="sub-item">Daftar Akuntansi</span></a></li>
                                    <li><a href="{{ route('account-detail.index') }}"><span class="sub-item">Daftar Rincian Akuntansi</span></a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item"><a href="{{ route('user.index') }}"><i class="fas fa-user"></i><p>Data Admin</p></a></li>
                        <li class="nav-item"><a href="{{ route('role.index') }}"><i class="fas fa-user-circle"></i><p>Data Jabatan</p></a></li>
                        <li class="nav-item"><a href="{{ route('customer.index') }}"><i class="fas fa-users"></i><p>Data Pelanggan</p></a></li>
                        <li class="nav-item"><a href="{{ route('supplier.index') }}"><i class="fas fa-user-secret"></i><p>Data Supplier</p></a></li>
                        <li class="nav-item"><a href="{{ route('service.index') }}"><i class="fas fa-archive"></i><p>Data Servis</p></a></li>
                        <li class="nav-item"><a href="{{ route('item.index') }}"><i class="fas fa-cubes"></i><p>Data Barang</p></a></li>

                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Transaksi</h4></li>
                        <li class="nav-item"><a href="{{ route('purchase.index') }}"><i class="fas fa-coins"></i><p>Pembelian</p></a></li>
                        <li class="nav-item"><a href="{{ route('sale.index') }}"><i class="fas fa-receipt"></i><p>Penjualan</p></a></li>
                        <li class="nav-item"><a href="{{ route('cash-payment.index') }}"><i class="fas fa-piggy-bank"></i><p>Pengeluaran Kas</p></a></li>
                        <li class="nav-item"><a href="{{ route('cash-receipt.index') }}"><i class="fas fa-hand-holding-usd"></i><p>Penerimaan Kas</p></a></li>

                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Laporan</h4></li>
                        <li class="nav-item"><a href="{{ route('general-entry.index') }}"><i class="fas fa-bookmark"></i><p>Jurnal Umum</p></a></li>
                        <li class="nav-item"><a href="{{ route('ledger.index') }}"><i class="fas fa-book-open"></i><p>Buku Besar</p></a></li>
                        <li class="nav-item"><a href="{{ route('trial-balance.index') }}"><i class="fas fa-balance-scale"></i><p>Neraca Saldo</p></a></li>
                        <li class="nav-item"><a href="{{ route('purchase-report.index') }}"><i class="fas fa-file-invoice"></i><p>Laporan Pembelian</p></a></li>
                        <li class="nav-item"><a href="{{ route('sale-report.index') }}"><i class="fas fa-file-invoice-dollar"></i><p>Laporan Penjualan</p></a></li>
                        <li class="nav-item"><a href="{{ route('income-statement.index') }}"><i class="fas fa-chart-line"></i><p>Laporan Laba Rugi</p></a></li>
                        <li class="nav-item"><a href="{{ route('statement-of-financial-position.index') }}"><i class="fas fa-stamp"></i><p>Laporan Posisi Keuangan</p></a></li>
                    @break

                    @case('2')
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Transaksi</h4></li>
                        <li class="nav-item"><a href="{{ route('purchase.index') }}"><i class="fas fa-coins"></i><p>Pembelian</p></a></li>
                        <li class="nav-item"><a href="{{ route('sale.index') }}"><i class="fas fa-receipt"></i><p>Penjualan</p></a></li>
                        <li class="nav-item"><a href="{{ route('cash-payment.index') }}"><i class="fas fa-piggy-bank"></i><p>Pengeluaran Kas</p></a></li>
                        <li class="nav-item"><a href="{{ route('cash-receipt.index') }}"><i class="fas fa-hand-holding-usd"></i><p>Penerimaan Kas</p></a></li>
                    @break

                    @default
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Laporan</h4></li>
                        <li class="nav-item"><a href="{{ route('general-entry.index') }}"><i class="fas fa-bookmark"></i><p>Jurnal Umum</p></a></li>
                        <li class="nav-item"><a href="{{ route('ledger.index') }}"><i class="fas fa-book-open"></i><p>Buku Besar</p></a></li>
                        <li class="nav-item"><a href="{{ route('trial-balance.index') }}"><i class="fas fa-balance-scale"></i><p>Neraca Saldo</p></a></li>
                        <li class="nav-item"><a href="{{ route('purchase-report.index') }}"><i class="fas fa-file-invoice"></i><p>Laporan Pembelian</p></a></li>
                        <li class="nav-item"><a href="{{ route('sale-report.index') }}"><i class="fas fa-file-invoice-dollar"></i><p>Laporan Penjualan</p></a></li>
                        <li class="nav-item"><a href="{{ route('income-statement.index') }}"><i class="fas fa-chart-line"></i><p>Laporan Laba Rugi</p></a></li>
                        <li class="nav-item"><a href="{{ route('statement-of-financial-position.index') }}"><i class="fas fa-stamp"></i><p>Laporan Posisi Keuangan</p></a></li>
                @endswitch

                @else
                    <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Master Data</h4></li>
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#akun"><i class="fas fa-book"></i><p>Daftar Akun</p><span class="caret"></span></a>
                        <div class="collapse" id="akun">
                            <ul class="nav nav-collapse">
                                <li><a href="{{ route('account.index') }}"><span class="sub-item">Daftar Akuntansi</span></a></li>
                                <li><a href="{{ route('account-detail.index') }}"><span class="sub-item">Daftar Rincian Akuntansi</span></a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item"><a href="{{ route('user.index') }}"><i class="fas fa-user"></i><p>Data Admin</p></a></li>
                    <li class="nav-item"><a href="{{ route('role.index') }}"><i class="fas fa-user-circle"></i><p>Data Jabatan</p></a></li>
                    <li class="nav-item"><a href="{{ route('customer.index') }}"><i class="fas fa-users"></i><p>Data Pelanggan</p></a></li>
                    <li class="nav-item"><a href="{{ route('supplier.index') }}"><i class="fas fa-user-secret"></i><p>Data Supplier</p></a></li>
                    <li class="nav-item"><a href="{{ route('service.index') }}"><i class="fas fa-archive"></i><p>Data Servis</p></a></li>
                    <li class="nav-item"><a href="{{ route('item.index') }}"><i class="fas fa-cubes"></i><p>Data Barang</p></a></li>

                    <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Transaksi</h4></li>
                    <li class="nav-item"><a href="{{ route('purchase.index') }}"><i class="fas fa-coins"></i><p>Pembelian</p></a></li>
                    <li class="nav-item"><a href="{{ route('sale.index') }}"><i class="fas fa-receipt"></i><p>Penjualan</p></a></li>
                    <li class="nav-item"><a href="{{ route('cash-payment.index') }}"><i class="fas fa-piggy-bank"></i><p>Pengeluaran Kas</p></a></li>
                    <li class="nav-item"><a href="{{ route('cash-receipt.index') }}"><i class="fas fa-hand-holding-usd"></i><p>Penerimaan Kas</p></a></li>

                    <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Laporan</h4></li>
                    <li class="nav-item"><a href="{{ route('general-entry.index') }}"><i class="fas fa-bookmark"></i><p>Jurnal Umum</p></a></li>
                    <li class="nav-item"><a href="{{ route('ledger.index') }}"><i class="fas fa-book-open"></i><p>Buku Besar</p></a></li>
                    <li class="nav-item"><a href="{{ route('trial-balance.index') }}"><i class="fas fa-balance-scale"></i><p>Neraca Saldo</p></a></li>
                    <li class="nav-item"><a href="{{ route('purchase-report.index') }}"><i class="fas fa-file-invoice"></i><p>Laporan Pembelian</p></a></li>
                    <li class="nav-item"><a href="{{ route('sale-report.index') }}"><i class="fas fa-file-invoice-dollar"></i><p>Laporan Penjualan</p></a></li>
                    <li class="nav-item"><a href="{{ route('income-statement.index') }}"><i class="fas fa-chart-line"></i><p>Laporan Laba Rugi</p></a></li>
                    <li class="nav-item"><a href="{{ route('statement-of-financial-position.index') }}"><i class="fas fa-stamp"></i><p>Laporan Posisi Keuangan</p></a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
