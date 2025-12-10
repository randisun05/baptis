<template>
  <nav class="navbar navbar-expand navbar-light bg-white border-bottom shadow-sm px-3 px-lg-4 py-3 sticky-top">
    <div class="container-fluid p-0">
      
      <button class="btn btn-light text-navy border-0 d-lg-none me-3" @click="toggleSidebar" title="Tampilkan Menu">
        <i class="bi bi-list fs-4"></i>
      </button>
      
      <div class="ms-auto">
        <ul class="navbar-nav flex-row align-items-center gap-3">
          
          <li class="nav-item">
            <Link class="nav-link icon-link" href="/admin/dashboard" title="Dashboard">
              <i class="bi bi-house-door-fill fs-5"></i>
            </Link>
          </li>

          <li class="nav-item dropdown position-relative">
            <a href="#" class="nav-link icon-link p-2" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Pengguna">
                <i class="bi bi-person-circle fs-5"></i> 
            </a>
            
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end text-small shadow border-0" aria-labelledby="dropdownUser1" style="background-color: #002244; position: absolute;">
              <li class="dropdown-header">
                  <span class="fw-bold">{{ $page.props.auth?.user?.name || 'Administrator' }}</span>
                  <div class="small text-white opacity-75">{{ $page.props.auth?.user?.email || '' }}</div>
              </li>
              <li><hr class="dropdown-divider border-white opacity-25"></li>
              
              <li><Link class="dropdown-item" href="/admin/profile">Profile</Link></li>
              <li><hr class="dropdown-divider border-white opacity-25"></li>
              <li><Link class="dropdown-item text-danger" href="/logout" method="post" as="button">Sign out</Link></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';

// Fungsi untuk membuka sidebar dengan memanipulasi class DOM
const toggleSidebar = () => {
    // Pastikan ID ini sesuai dengan ID di komponen Sidebar Anda
    const sidebar = document.getElementById('sidebar-menu');
    const overlay = document.getElementById('sidebar-menu-overlay');

    if (sidebar) {
        sidebar.classList.toggle('active-sidebar');
    }
    if (overlay) {
        overlay.classList.toggle('active-overlay');
    }
}
</script>

<style scoped>
/* --- Theme Variables --- */
.text-navy {
    color: #003366 !important;
}

/* --- Navbar Styles --- */
.navbar {
    height: 70px;
    /* PENTING: Z-index Navbar harus LEBIH KECIL dari Sidebar (misal Sidebar 1050) */
    z-index: 990; 
    top: 0;
}

/* --- Icon Links --- */
.icon-link {
    color: #6c757d; 
    transition: all 0.3s ease;
    padding: 0.5rem;
    border-radius: 50%; 
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-link:hover, .icon-link:focus, .show > .icon-link {
    color: #003366; 
    background-color: #e6f0ff; 
    transform: translateY(-2px);
}

/* --- Mobile Toggle Button --- */
.btn-light.text-navy:hover {
  background-color: #f8f9fa; 
}
.btn-light.text-navy:active {
  background-color: #e2e6ea;
}

/* --- Dropdown Fix --- */
.dropdown-menu {
    margin-top: 10px !important;
}
</style>