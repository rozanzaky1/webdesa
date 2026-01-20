 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Cari Sesuatu..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                @php
                                    $pendingCount = isset($submissions) ? count($submissions) : 0;
                                @endphp
                                @if($pendingCount > 0)
                                    <span class="badge badge-danger badge-counter">{{ $pendingCount }}</span>
                                @endif
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifikasi Pengajuan Surat
                                </h6>
                                @if(isset($submissions) && count($submissions) > 0)
                                    @foreach(array_slice($submissions, 0, 5) as $submission)
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('online-submission.show', $submission['id']) }}">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">{{ \Carbon\Carbon::parse($submission['created_at'])->diffForHumans() }}</div>
                                            <span class="font-weight-bold">Pengajuan {{ $submission['letter_type'] ?? '-' }}</span>
                                            <div class="small text-truncate">Dari: {{ $submission['user_name'] ?? $submission['user_email'] ?? 'User' }}</div>
                                        </div>
                                    </a>
                                    @endforeach
                                    <a class="dropdown-item text-center small text-gray-500" href="{{ route('online-submission.index') }}">Lihat Semua Pengajuan</a>
                                @else
                                    <div class="dropdown-item text-center text-gray-500 py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0 small">Tidak ada pengajuan baru</p>
                                    </div>
                                @endif
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                @if(isset($submissions) && count($submissions) > 0)
                                    <span class="badge badge-danger badge-counter">{{ count($submissions) }}</span>
                                @endif
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Pesan Pengajuan Surat
                                </h6>
                                @if(isset($submissions) && count($submissions) > 0)
                                    @foreach(array_slice($submissions, 0, 4) as $submission)
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('online-submission.show', $submission['id']) }}">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="{{ asset('template/img/undraw_profile.svg') }}" alt="...">
                                            <div class="status-indicator bg-warning"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate font-weight-bold">{{ $submission['user_name'] ?? $submission['user_email'] ?? 'User' }}</div>
                                            <div class="text-truncate small">Mengajukan {{ $submission['letter_type'] ?? '-' }}</div>
                                            <div class="small text-gray-500">{{ \Carbon\Carbon::parse($submission['created_at'])->diffForHumans() }}</div>
                                        </div>
                                    </a>
                                    @endforeach
                                    <a class="dropdown-item text-center small text-gray-500" href="{{ route('online-submission.index') }}">Lihat Semua Pesan</a>
                                @else
                                    <div class="dropdown-item text-center text-gray-500 py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0 small">Tidak ada pesan baru</p>
                                    </div>
                                @endif
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name ?? 'Admin' }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('template/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                    <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Lihat Landing Page
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>