<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item dropdown hidden-caret">
                <button class="btn btn-default" form="logout-form">Logout</button>
                <form id="logout-form" name="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
                {{-- <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{ asset('atlantis-assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>

                        </li>
                    </div>
                </ul> --}}
            </li>
        </ul>
    </div>
</nav>
