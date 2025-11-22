<!-- <template>
    <div class="d-flex flex-column p-3 text-white sidebar-container flex-shrink-0" style="width: 280px; min-height: 100vh;">
        
        <Link href="/user/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex flex-column">
                    <span class="fs-5 fw-bold lh-1">Panel Pengguna</span>
                    <span class="small opacity-75" style="font-size: 0.75rem;">Paroki St. Melania</span>
                </div>
            </div>
        </Link>
        
        <hr class="border-white opacity-25">
        
        <ul class="nav nav-pills flex-column mb-auto">
            
            <li class="nav-item mb-1">
                <Link href="/user/dashboard" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/user/dashboard') }">
                    <i class="bi bi-speedometer2 fs-5"></i> <span>Dashboard</span>
                </Link>
            </li>



            <li class="nav-item mb-1">
                <Link href="/user/warta" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/user/warta') }">
                    <i class="bi bi-newspaper fs-5"></i> <span>Warta Paroki</span>
                </Link>
            </li>

           
            
            <li class="nav-item mb-1">
                <Link href="/user/profile" class="nav-link d-flex align-items-center gap-3" :class="{ 'active-nav': $page.url.startsWith('/user/profile') }">
                    <i class="bi bi-person-circle fs-5"></i> <span>Profile</span>
                </Link>
            </li>

        </ul>
        
        <hr class="border-white opacity-25">
        
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle p-2 rounded hover-bg" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-white text-navy rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <strong>{{ $page.props.auth?.user?.name || 'Peserta' }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow border-0" aria-labelledby="dropdownUser2" style="background-color: #002244;">
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
/* Styling konsisten dengan sidebar admin */
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
</style> -->