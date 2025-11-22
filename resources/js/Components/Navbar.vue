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

            <li class="nav-item dropdown">
      <a href="#" class="nav-link icon-link p-2" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Pengguna">
          <i class="bi bi-person-circle fs-5"></i> 
      </a>
      
      <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end text-small shadow border-0" aria-labelledby="dropdownUser1" style="background-color: #002244;">
          <li class="dropdown-header">
              <span class="fw-bold">{{ $page.props.auth?.user?.name || 'Administrator' }}</span>
              <div class="small text-white opacity-75">{{ $page.props.auth?.user?.email || '' }}</div>
          </li>
          <li><hr class="dropdown-divider border-white opacity-25"></li>
          
          <li><Link class="dropdown-item" href="/user/profile">Profile</Link></li>
          <li><hr class="dropdown-divider border-white opacity-25"></li>
          <li><Link class="dropdown-item text-danger" href="/logout" method="post" as="button">Sign out</Link></li>
      </ul>
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