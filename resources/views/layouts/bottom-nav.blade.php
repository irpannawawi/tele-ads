        <!-- Bottom Navbar -->
        <nav id="bottomNavbar"
            class="navbar navbar-dark navbar-expand rounded-pill d-md-none d-lg-none d-xl-none d-xxl-none fixed-bottom mb-2 shadow mx-2">
            <ul class="navbar-nav nav-justified w-100">
                <li class="nav-item p-0 active">
                    <a href="{{ route('home') }}" class="nav-link text-center menu-label">
                    <img class="menu-icon img-fluid" src="{{ asset('assets/icon/house.png') }}" alt="">
                        <br>
                        Home
                    </a>
                </li>
                <li class="nav-item p-0">
                    <a href="{{ route('withdrawals') }}" class="nav-link text-center menu-label">
                        <img class="menu-icon img-fluid" src="{{ asset('assets/icon/salary.png') }}" alt="">
                        <br>Tarik Dana
                    </a>
                </li>
                <li class="nav-item p-0">
                    <a href="{{ route('history') }}" class="nav-link text-center menu-label">
                    <img class="menu-icon img-fluid" src="{{ asset('assets/icon/transaction-history.png') }}"
                        alt="">
                        <br>
                        Riwayat
                    </a>
                </li>
                <li class="nav-item p-0">
                    <a href="#" class="nav-link text-center menu-label">
                    <img class="menu-icon img-fluid" src="{{ asset('assets/icon/stack-of-books.png') }}" alt="">
                        <br>Tutorial
                    </a>
                </li>
            </ul>
        </nav>