<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}" style="flex-direction: column; padding: 0.8rem 0; height: auto; min-height: 4.375rem;">
        <div class="sidebar-brand-icon" style="margin-bottom: 0.3rem;">
            <i class="fas fa-landmark" style="font-size: 1.5rem;"></i>
        </div>
        <div class="sidebar-brand-text" style="font-size: 0.7rem; line-height: 1.2; text-align: center; padding: 0 0.5rem;">
            <div style="font-weight: 700; margin-bottom: 0.1rem;">DESA BADRAN SARI</div>
            <div style="font-size: 0.6rem; font-weight: 400; opacity: 0.9;">Kecamatan Punggur</div>
            <div style="font-size: 0.6rem; font-weight: 400; opacity: 0.9;">Kabupaten Lampung Tengah</div>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Desa
    </div>

    <!-- Nav Item - Profil Desa -->
    <li class="nav-item {{ Request::is('village-profile*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('village-profile.index') }}">
            <i class="fas fa-fw fa-building"></i>
            <span>Profil Desa</span></a>
    </li>

    <!-- Nav Item - Lembaga Desa -->
    <li class="nav-item {{ Request::is('village-institutions*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('village-institutions.index') }}">
            <i class="fas fa-fw fa-handshake"></i>
            <span>Lembaga Desa</span></a>
    </li>

    <!-- Nav Item - Berita -->
    <li class="nav-item {{ Request::is('news*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('news.index') }}">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Berita</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kependudukan
    </div>

    <!-- Nav Item - Data Penduduk Collapse Menu -->
    <li class="nav-item {{ Request::is('residents*') || Request::is('families*') || Request::is('hamlets*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('residents*') || Request::is('families*') || Request::is('hamlets*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseKependudukan"
            aria-expanded="{{ Request::is('residents*') || Request::is('families*') || Request::is('hamlets*') ? 'true' : 'false' }}" aria-controls="collapseKependudukan">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Penduduk</span>
        </a>
        <div id="collapseKependudukan" class="collapse {{ Request::is('residents*') || Request::is('families*') || Request::is('hamlets*') ? 'show' : '' }}" aria-labelledby="headingKependudukan" data-parent="#accordionSidebar">
            <div class="bg-white py-1 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('residents*') ? 'active' : '' }}" href="{{ route('residents.index') }}">Penduduk</a>
                <a class="collapse-item {{ Request::is('families*') ? 'active' : '' }}" href="{{ route('families.index') }}">Keluarga</a>
                <a class="collapse-item {{ Request::is('hamlets*') ? 'active' : '' }}" href="{{ route('hamlets.index') }}">Dusun</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Layanan
    </div>

    <!-- Nav Item - Layanan Collapse Menu -->
    <li class="nav-item {{ Request::is('letter-archive*') || Request::is('online-submission*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('letter-archive*') || Request::is('online-submission*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseLayanan"
            aria-expanded="{{ Request::is('letter-archive*') || Request::is('online-submission*') ? 'true' : 'false' }}" aria-controls="collapseLayanan">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Surat & Dokumen</span>
        </a>
        <div id="collapseLayanan" class="collapse {{ Request::is('letter-archive*') || Request::is('online-submission*') ? 'show' : '' }}" aria-labelledby="headingLayanan" data-parent="#accordionSidebar">
            <div class="bg-white py-1 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('letter-archive*') ? 'active' : '' }}" href="{{ route('letter-archive.index') }}">Arsip Surat</a>
                <a class="collapse-item {{ Request::is('online-submission*') ? 'active' : '' }}" href="{{ route('online-submission.index') }}">Pengajuan Online</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Verifikasi
    </div>

    <!-- Nav Item - Verifikasi User -->
    <li class="nav-item {{ Request::is('user-verification*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user-verification.index') }}">
            <i class="fas fa-fw fa-user-check"></i>
            <span>Verifikasi User</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
