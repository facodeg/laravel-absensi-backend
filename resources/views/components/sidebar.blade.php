<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">MHM</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class='{{ Request::is('home') ? 'mm-active' : '' }}'>
            <a href="{{ route('home') }}" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>

                <div class="menu-title">Dashboard</div>

            </a>

        </li>

        <li class="menu-label">PENGATURAN</li>

        <li class='{{ Request::is('companies') ? 'mm-active' : '' }}'>
            <a href="{{ route('companies.show', 1) }}">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Company</div>
            </a>
        </li>

        <li class='{{ Request::is('attendances') ? 'mm-active' : '' }}'>
            <a href="{{ route('attendances.index') }}">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Presensi</div>
            </a>
        </li>

        <li class='{{ Request::is('izins') ? 'mm-active' : '' }}'>
            <a href="{{ route('izins.index') }}">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Izin</div>
            </a>
        </li>

        <li class='{{ Request::is('users') ? 'mm-active' : '' }}'>
            <a href="{{ route('users.index') }}">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">User</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
