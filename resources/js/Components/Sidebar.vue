<template>
     <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" id="sidebar-wrapper">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <i class="bi bi-bootstrap-fill fs-4 me-2"></i>
                <span class="fs-4 fw-bold">Admin Panel</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
               <li class="nav-item text-white">
                    <a href="/admin/dashboard"
                    class="nav-link"
                    :class="{ 'active': $page.url.startsWith('/admin/dashboard') }"
                    aria-current="page">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/admin/posts" class="nav-link text-white"
                    :class="{ 'active': $page.url.startsWith('/admin/posts') }"
                    aria-current="page">
                        <i class="bi bi-table me-2"></i>
                        Warta
                    </a>
                </li>
                <li>
                    <a href="/admin/registration" class="nav-link text-white"
                    :class="{ 'active': $page.url.startsWith('/admin/registration') }"
                    aria-current="page">
                        <i class="bi bi-grid me-2"></i>
                        Pendaftaran
                    </a>
                </li>
                <li>
                    <a href="/admin/refevents" class="nav-link text-white"
                    :class="{ 'active': $page.url.startsWith('/admin/refevents') }"
                    aria-current="page">
                        <i class="bi bi-people-circle me-2"></i>
                        Ref Kegiatan
                    </a>
                </li>
                 <li>
                    <a href="/admin/events" class="nav-link text-white"
                    :class="{ 'active': $page.url.startsWith('/admin/events') }"
                    aria-current="page">
                        <i class="bi bi-people-circle me-2"></i>
                        Kegiatan
                    </a>
                </li>
                <li>
                    <a href="/admin/users" class="nav-link text-white"
                    :class="{ 'active': $page.url.startsWith('/admin/users') }"
                    >
                        <i class="bi bi-people-circle me-2"></i>
                        Akun
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://via.placeholder.com/32" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>Administrator</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>


</template>

<script>

//import Link
import { Link } from '@inertiajs/inertia-vue3';

export default {

    //register components
    components: {
        Link
    },

}

</script>

<style>
</style>
