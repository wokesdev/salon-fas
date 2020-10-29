<!-- Sidebar -->
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
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @switch(Auth::user()->role->level)
                    @case('1')
                        <li class="nav-section"><span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span><h4 class="text-section">Admin</h4></li>
                        <li class="nav-item"><a href="{{ route('user.index') }}"><i class="fas fa-user"></i><p>Data Admin</p></a></li>
                        <li class="nav-item"><a href="{{ route('role.index') }}"><i class="fas fa-user-circle"></i><p>Data Jabatan</p></a></li>
                        <li class="nav-item"><a href="{{ route('customer.index') }}"><i class="fas fa-users"></i><p>Data Pelanggan</p></a></li>
                    @break

                    @case('2')
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Admin</h4>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}">
                                <i class="fas fa-user"></i>
                                <p>Data Admin</p>
                            </a>
                        </li>
                    @break

                    @default
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Admin</h4>
                        </li>
                @endswitch

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
