<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            @if (Auth::user()->role_id == 1)
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('admin.dashboard') }}">
                        <span data-feather="home"></span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/admin*') ? 'active' : '' }}"
                        href="{{ route('admin.admin.index') }}">
                        <span data-feather="file"></span>
                        Admin
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}"
                        href="{{ route('admin.user.index') }}">
                        <span data-feather="shopping-cart"></span>
                        Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/roomtype*') ? 'active' : '' }}"
                        href="{{ route('admin.roomType.index') }}">
                        <span data-feather="shopping-cart"></span>
                        Room Type
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/rooms*') ? 'active' : '' }}"
                        href="{{ route('admin.rooms.index') }}">
                        <span data-feather="shopping-cart"></span>
                        Room
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/booking*') ? 'active' : '' }}"
                        href="{{ route('admin.booking.index') }}">
                        <span data-feather="layers"></span>
                        Booking
                    </a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('user/dashboard') || request()->is('user/dashboard/room*') ? 'active' : '' }}"
                        href="{{ route('user.dashboard') }}">
                        <span data-feather="shopping-cart"></span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('user/dashboard/transactions*') ? 'active' : '' }}"
                        href="{{ route('user.transactions') }}">
                        <span data-feather="shopping-cart"></span>
                        Your Bookings
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
