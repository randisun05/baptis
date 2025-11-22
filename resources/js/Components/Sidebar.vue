<template>
    <div class="d-flex flex-column p-3 text-white sidebar-container flex-shrink-0" style="width: 280px; min-height: 100vh;">
        
        <Link href="/admin/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex flex-column">
                    <span class="fs-5 fw-bold lh-1">Admin Panel</span>
                    <span class="small opacity-75" style="font-size: 0.75rem;">Paroki St. Melania</span>
                </div>
            </div>
        </Link>
        
        <hr class="border-white opacity-25">
        
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                <Link href="/admin/dashboard" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/dashboard') }">
                    <i class="bi bi-speedometer2 fs-5"></i> <span>Dashboard</span>
                </Link>
            </li>
            <li class="nav-item mb-1">
                <Link href="/admin/posts" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/posts') }">
                    <i class="bi bi-newspaper fs-5"></i> <span>Warta / Post</span>
                </Link>
            </li>
            <li class="nav-item mb-1">
                <Link href="/admin/registration" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/registration') }">
                    <i class="bi bi-people-fill fs-5"></i> <span>Registrasi</span>
                </Link>
            </li>
            <li class="nav-item mb-1">
                <Link href="/admin/members" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/members') }">
                    <i class="bi bi-people-fill fs-5"></i> <span>Data Peserta</span>
                </Link>
            </li>
            <li class="nav-item mb-1">
                <Link href="/admin/events" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/events') }">
                    <i class="bi bi-calendar-event fs-5"></i> <span>Kegiatan</span>
                </Link>
            </li>
            <li class="nav-item mb-1">
                <Link href="/admin/setting" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/admin/setting') }">
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
                <strong>{{ $page.props.auth?.user?.name || 'Administrator' }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow border-0" aria-labelledby="dropdownUser1" style="background-color: #002244;">
                <li><Link class="dropdown-item" href="/profile">Profile</Link></li>
                <li><hr class="dropdown-divider border-white opacity-25"></li>
                <li><Link class="dropdown-item text-danger" href="/logout" method="post" as="button">Sign out</Link></li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<style scoped>
.text-navy { color: #003366 !important; }
.sidebar-container {
    background-color: #003366;
    position: sticky; 
    top: 0;
    height: auto;
    overflow-y: auto; 
}
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
    transform: translateX(5px);
}
.active-nav {
    background-color: #ffffff !important;
    color: #003366 !important;
    font-weight: 700;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
.hover-bg:hover {
    background-color: rgba(255, 255, 255, 0.1);
}
</style>