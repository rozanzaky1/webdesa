<style>
    .custom-sidebar {
        width: 250px;
        background: #1f1c1d;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        overflow-y: auto;
    }

    .sidebar-header {
        padding: 20px 15px;
        text-align: center;
        border-bottom: 1px solid #333;
    }

    .sidebar-logo {
        width: 60px;
        height: 60px;
        margin: 0 auto 12px;
        background: #0f7b2a;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar-logo img {
        width: 45px;
        height: 45px;
        object-fit: contain;
    }

    .sidebar-title {
        font-size: 11px;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.5px;
        line-height: 1.4;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .sidebar-subtitle {
        font-size: 9px;
        font-weight: 600;
        color: #b0b0b0;
        letter-spacing: 0.3px;
        line-height: 1.3;
        text-transform: uppercase;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li {
        border-bottom: 1px solid #2b2728;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        color: #d6d6d6;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 0.3px;
        transition: background 0.2s;
    }

    .sidebar-menu a:hover {
        background: #2a2728;
        color: #fff;
    }

    .sidebar-menu a.active {
        background: #0f7b2a;
        color: #fff;
    }

    .sidebar-menu .dropdown-arrow {
        font-size: 10px;
        transition: transform 0.3s;
    }

    .sidebar-menu .dropdown-arrow.expanded {
        transform: rotate(180deg);
    }

    .sidebar-submenu {
        list-style: none;
        padding: 0;
        margin: 0;
        background: #191718;
        display: none;
    }

    .sidebar-submenu.show {
        display: block;
    }

    .sidebar-submenu a {
        padding: 12px 20px 12px 40px;
        font-size: 12px;
    }
</style>

<ul class="navbar-nav custom-sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-landmark" style="color: #fff; font-size: 28px;"></i>
        </div>
        <div class="sidebar-title">DESA BADRAN SARI</div>
        <div class="sidebar-subtitle">KECAMATAN PUNGGUR</div>
        <div class="sidebar-subtitle">KABUPATEN LAMPUNG TENGAH</div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}">
                BERANDA
            </a>
        </li>
        <li>
            <a href="{{ route('village-profile.index') }}" class="{{ Request::is('village-profile*') ? 'active' : '' }}">
                PROFIL DESA
            </a>
        </li>
        <li>
            <a href="{{ route('village-institutions.index') }}" class="{{ Request::is('village-institutions*') ? 'active' : '' }}">
                LEMBAGA DESA
            </a>
        </li>
        <li>
            <a href="{{ route('news.index') }}" class="{{ Request::is('news*') ? 'active' : '' }}">
                BERITA
            </a>
        </li>
        <li>
            <a href="#" onclick="toggleDropdown(event, 'layanan')">
                <span>LAYANAN</span>
                <i class="fas fa-chevron-down dropdown-arrow" id="arrow-layanan"></i>
            </a>
            <ul class="sidebar-submenu" id="submenu-layanan">
                <li><a href="{{ route('letter-archive.index') }}" class="{{ Request::is('letter-archive*') ? 'active' : '' }}">Surat Keterangan</a></li>
                <li><a href="{{ route('online-submission.index') }}" class="{{ Request::is('online-submission*') ? 'active' : '' }}">Pengajuan Online</a></li>
            </ul>
        </li>
        <li>
            <a href="#" onclick="toggleDropdown(event, 'kependudukan')">
                <span>KEPENDUDUKAN</span>
                <i class="fas fa-chevron-down dropdown-arrow" id="arrow-kependudukan"></i>
            </a>
            <ul class="sidebar-submenu" id="submenu-kependudukan">
                <li><a href="{{ route('residents.index') }}" class="{{ Request::is('residents*') ? 'active' : '' }}">Penduduk</a></li>
                <li><a href="{{ route('families.index') }}" class="{{ Request::is('families*') ? 'active' : '' }}">Keluarga</a></li>
                <li><a href="{{ route('hamlets.index') }}" class="{{ Request::is('hamlets*') ? 'active' : '' }}">Dusun</a></li>
            </ul>
        </li>
    </ul>
</ul>

<script>
    function toggleDropdown(event, id) {
        event.preventDefault();
        const submenu = document.getElementById('submenu-' + id);
        const arrow = document.getElementById('arrow-' + id);
        submenu.classList.toggle('show');
        arrow.classList.toggle('expanded');
    }
</script>