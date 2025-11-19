<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm px-4 py-3 sticky-top">
    <div class="container-fluid p-0">
      
      <!-- Tombol Toggle Sidebar (Mobile Only) -->
      <button class="btn btn-light text-navy border-0 d-lg-none me-3" id="sidebarToggle">
        <i class="bi bi-list fs-4"></i>
      </button>

      

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mt-2 mt-lg-0 align-items-center gap-3">
          
          <!-- Home Icon -->
          <li class="nav-item">
             <Link class="nav-link icon-link" href="/admin/dashboard" title="Dashboard">
                <i class="bi bi-house-door-fill fs-5"></i>
             </Link>
          </li>

          <!-- Notification Icon -->
          <li class="nav-item position-relative">
             <a class="nav-link icon-link" href="#" title="Notifikasi">
                <i class="bi bi-bell-fill fs-5"></i>
                <!-- Badge Notification -->
                <span class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger border border-light shadow-sm" style="font-size: 0.6rem; padding: 0.35em 0.5em;">
                  4
                  <span class="visually-hidden">unread messages</span>
                </span>
             </a>
          </li>

          <!-- Profile Dropdown Kecil (Opsional jika di sidebar sudah ada) -->
          <!-- <li class="nav-item"> ... </li> -->
          
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
// Menggunakan script setup agar lebih modern
import { Link } from '@inertiajs/inertia-vue3';
</script>

<style scoped>
/* --- Theme Variables --- */
.text-navy {
    color: #003366 !important;
}

/* --- Navbar Styles --- */
.navbar {
    height: 70px; /* Tinggi tetap agar layout stabil */
    z-index: 999;
}

/* --- Icon Links --- */
.icon-link {
    color: #6c757d; /* Warna abu-abu default */
    transition: all 0.3s ease;
    padding: 0.5rem;
    border-radius: 50%; /* Efek bulat saat hover */
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-link:hover {
    color: #003366; /* Berubah jadi Navy saat hover */
    background-color: #e6f0ff; /* Latar belakang biru sangat muda */
    transform: translateY(-2px);
}

/* --- Mobile Toggle Button --- */
#sidebarToggle:active {
    background-color: #e2e6ea;
}
</style>