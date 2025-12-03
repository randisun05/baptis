<template>
  <nav class="navbar navbar-light bg-white border-bottom shadow-sm px-4 py-3 sticky-top">
    <div class="container-fluid p-0">

      <div id="navbarSupportedContent" class="w-100 d-flex justify-content-end"> 
        
        <ul class="navbar-nav ms-auto align-items-center gap-3 flex-row">
          
          <li class="nav-item">
             <Link class="nav-link icon-link" href="/user/dashboard" title="Dashboard">
               <i class="bi bi-house-door-fill fs-5"></i>
             </Link>
          </li>
          
          <li class="nav-item">
             <Link class="nav-link icon-link" href="/user/posts/list" title="Posts">
               <i class="bi bi-newspaper fs-5"></i>
             </Link>
          </li>
        
          <li class="nav-item dropdown position-static"> 
            <a href="#" class="nav-link icon-link p-2" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Pengguna">
              <i class="bi bi-person-circle fs-5"></i> 
            </a>
            
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end text-small shadow border-0 mt-2 position-absolute" aria-labelledby="dropdownUser1" style="background-color: #002244;">
              <li class="dropdown-header">
                <span class="fw-bold">{{ $page.props.auth?.member?.name || 'Peserta' }}</span>
                <div class="small text-white opacity-75">{{ $page.props.auth?.member?.email || '' }}</div>
              </li>
              <li><hr class="dropdown-divider border-white opacity-25"></li>
              
              <li><Link class="dropdown-item" href="/user/profile">Profile</Link></li>
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
</script>

<style scoped>
/* (Style CSS tidak diubah) */
.text-navy {
    color: #003366 !important;
}

.navbar {
    height: 70px; 
    z-index: 999;
}

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

.icon-link:hover {
    color: #003366; 
    background-color: #e6f0ff; 
    transform: translateY(-2px);
}
</style>