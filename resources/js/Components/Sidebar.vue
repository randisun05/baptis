<template>
    <div id="sidebar-menu" 
         class="d-flex flex-column p-3 text-white sidebar-container flex-shrink-0" 
         style="width: 280px; min-height: 100vh;">

        <Link href="/admin/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex flex-column">
                    <span class="fs-5 fw-bold lh-1 text-uppercase">
                        {{ getRoleDisplay($page.props.auth.user.role) }}
                    </span>
                    <span class="small opacity-75" style="font-size: 0.75rem;">Paroki St. Melania</span>
                </div>
            </div>
        </Link>

        <hr class="border-white opacity-25">

        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                <Link href="/admin/dashboard" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/dashboard') }" @click="closeSidebar">
                    <i class="bi bi-speedometer2 fs-5"></i> <span>Dashboard</span>
                </Link>
            </li>
            
            <li v-if="$page.props.auth.user.role === 'administrator'" class="nav-item mb-1">
                <Link href="/admin/posts" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/posts') }" @click="closeSidebar">
                    <i class="bi bi-newspaper fs-5"></i> <span>Warta</span>
                </Link>
            </li>
            
            <li v-if="$page.props.auth.user.role === 'administrator' || $page.props.auth.user.role === 'peserta'" class="nav-item mb-1">
                <Link href="/admin/registration" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/registration') }" @click="closeSidebar">
                    <i class="bi bi-card-list fs-5"></i> <span>Registrasi</span>
                </Link>
            </li>
            
            <li v-if="$page.props.auth.user.role !== 'peserta'" class="nav-item mb-1">
                <Link href="/admin/members" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/members') }" @click="closeSidebar">
                    <i class="bi bi-people-fill fs-5"></i> <span>Data Peserta</span>
                </Link>
            </li>
            
            <li v-if="$page.props.auth.user.role === 'administrator' || $page.props.auth.user.role === 'ketua_wakil_subseksi'" class="nav-item mb-1">
                <Link href="/admin/events" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/events') }" @click="closeSidebar">
                    <i class="bi bi-calendar-event fs-5"></i> <span>Kegiatan</span>
                </Link>
            </li>
            
            <li v-if="$page.props.auth.user.role === 'administrator'" class="nav-item mb-1">
                <Link href="/admin/setting" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/setting') }" @click="closeSidebar">
                    <i class="bi bi-person-gear fs-5"></i> <span>Akun Pengguna</span>
                </Link>
            </li>
        </ul>

        <hr class="border-white opacity-25">

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle p-2 rounded hover-bg" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-white text-navy rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <strong>{{ $page.props.auth?.user?.name || 'User' }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow border-0" aria-labelledby="dropdownUser1" style="background-color: #002244;">
                <li><Link class="dropdown-item" href="/admin/profile" @click="closeSidebar">Profile</Link></li>
                <li><hr class="dropdown-divider border-white opacity-25"></li>
                <li><Link class="dropdown-item text-danger" href="/logout" method="post" as="button" :data="{role : 'admin'}" @click="closeSidebar">Sign out</Link></li>
            </ul>
        </div>
    </div>
    
    <div id="sidebar-menu-overlay" class="sidebar-overlay" @click="closeSidebar"></div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';

// --- Functions ---

const getRoleDisplay = (role) => {
    switch (role) {
        case 'administrator':
            return 'Admin Panel';
        case 'ketua_wakil_subseksi':
            return 'Ketua & Wakil Panel';
        case 'peserta':
            return 'Peserta Panel';
        default:
            return 'Panel Admin';
    }
}

// FUNGSI UNTUK MENUTUP SIDEBAR DAN OVERLAY
const closeSidebar = () => {
    const sidebar = document.getElementById('sidebar-menu');
    const overlay = document.getElementById('sidebar-menu-overlay');

    // Tutup Sidebar
    if (sidebar && sidebar.classList.contains('active-sidebar')) {
        sidebar.classList.remove('active-sidebar');
    }

    // Tutup Overlay
    if (overlay && overlay.classList.contains('active-overlay')) {
        overlay.classList.remove('active-overlay');
    }
}
</script>

<script>
export default {
    name: 'AdminSidebar'
}
</script>

<style scoped>
.text-navy { color: #003366 !important; }

/* -------------------------------------- */
/* CSS Sidebar Utama */
/* -------------------------------------- */
.sidebar-container {
    background-color: #003366;
    position: fixed; 
    top: 0;
    left: 0;
    z-index: 1040; 
    height: 100vh; 
    overflow-y: auto;
    transition: transform 0.3s ease-in-out;
}

/* -------------------------------------- */
/* CSS Overlay (Lapisan Gelap di HP) */
/* -------------------------------------- */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); 
    z-index: 1030; /* Di bawah sidebar (1040) */
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, visibility 0.3s;
}

/* -------------------------------------- */
/* Responsiveness (Mobile) */
/* -------------------------------------- */

@media (max-width: 991.98px) { 
    /* Sembunyikan sidebar secara default di HP */
    .sidebar-container {
        transform: translateX(-100%); 
    }
    
    /* Tampilkan sidebar saat kelas aktif ditambahkan (oleh Navbar Toggle) */
    .active-sidebar {
        transform: translateX(0) !important; 
    }
    
    /* Tampilkan overlay saat kelas aktif ditambahkan (oleh Navbar Toggle) */
    .active-overlay {
        opacity: 1;
        visibility: visible;
    }
}

/* Biarkan sidebar muncul secara default di layar besar (Desktop) */
@media (min-width: 992px) { 
    .sidebar-container {
        position: sticky; 
        height: auto;
        transform: none !important; 
    }
    /* Sembunyikan Overlay di desktop */
    .sidebar-overlay {
        display: none;
    }
}


/* -------------------------------------- */
/* Styling Menu Items */
/* -------------------------------------- */
.nav-link {
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
}
.nav-link:hover {
    color: #ffffff;
    background-color: rgba(255, 255, 255, 0.1);
}
.active-nav {
    background-color: #ffffff !important;
    color: #003366 !important;
    font-weight: 700;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transform: none; 
}
.hover-bg:hover {
    background-color: rgba(255, 255, 255, 0.1);
}
</style>