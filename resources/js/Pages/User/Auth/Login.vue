<template>
    <Head>
        <title>Login Peserta - Paroki Santa Melania</title>
        <!-- Mempertahankan link CSS global dari Landing Page -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    </Head>

    <div class="landing-wrapper">
       

        <!-- START: HERO SECTION/HEADER (Mengadopsi gaya Hero) -->
        <section class="hero d-flex align-items-center" style="min-height: 350px;">
            <div class="overlay"></div>
            <div class="container position-relative text-center text-white z-1">
                <h1 class="display-5 fw-bold mb-3">Login Peserta</h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
                    Masuk untuk mengakses kegiatan katekese Anda.
                </p>
            </div>
        </section>
        <!-- END: HERO SECTION/HEADER -->

        <!-- START: LOGIN FORM -->
        <section class="py-5 bg-light d-flex justify-content-center" style="margin-top: -100px; z-index: 10; position: relative;">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <div class="card shadow-lg p-4 p-md-5 border-0 rounded-4">
                            <h3 class="fw-bold text-navy text-center mb-4">Masuk ke Akun Anda</h3>

                            <!-- ALERT MESSAGES -->
                            <div v-if="errors.message" class="alert alert-danger bg-danger-subtle text-danger-emphasis alert-dismissible fade show border-0 rounded-3 small">
                                <i class="fas fa-exclamation-triangle me-2"></i> {{ errors.message }}
                            </div>
                            <div v-if="$page.props.session?.error" class="alert alert-danger bg-danger-subtle text-danger-emphasis alert-dismissible fade show border-0 rounded-3 small">
                                <i class="fas fa-exclamation-triangle me-2"></i> {{ $page.props.session.error }}
                            </div>
                            <div v-if="$page.props.session?.success" class="alert alert-success bg-success-subtle text-success-emphasis alert-dismissible fade show border-0 rounded-3 small">
                                <i class="fas fa-check-circle me-2"></i> {{ $page.props.session.success }}
                            </div>

                            <form @submit.prevent="submit" class="mt-4">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <label for="email" class="form-label small fw-bold text-navy">Alamat Email</label>
                                        <div class="input-group input-group-lg login-input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="fa fa-envelope text-muted"></i>
                                            </span>
                                            <input 
                                                type="email" 
                                                class="form-control border-start-0 input-tegas" 
                                                v-model="form.email" 
                                                id="email"
                                                placeholder="contoh@email.com"
                                                :class="{ 'is-invalid': errors.email }"
                                            >
                                        </div>
                                        <div v-if="errors.email" class="text-danger small mt-1">{{ errors.email }}</div>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label for="password" class="form-label small fw-bold text-navy">Password</label>
                                        <div class="input-group input-group-lg login-input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="fa fa-lock text-muted"></i>
                                            </span>
                                            <input 
                                                type="password" 
                                                placeholder="Masukkan Password" 
                                                class="form-control border-start-0 input-tegas" 
                                                v-model="form.password"
                                                id="password"
                                                :class="{ 'is-invalid': errors.password }"
                                            >
                                        </div>
                                        <div v-if="errors.password" class="text-danger small mt-1">{{ errors.password }}</div>
                                    </div>

                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" :disabled="submitting">
                                            <span v-if="submitting">
                                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                Memproses...
                                            </span>
                                            <span v-else>
                                                <i class="fas fa-sign-in-alt me-2"></i> Login Sekarang
                                            </span>
                                        </button>
                                        
                                        <p class="text-center mt-4 small text-muted">
                                          
                                        </p>
                                        <p class="text-center small text-muted">
                                            <Link href="/forget-password" class="text-decoration-none fw-bold text-primary-hover">Lupa Password</Link>
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    //import layout
    import LayoutWebsite from '../../../Layouts/Website.vue';

    //import Head and Link from Inertia
    import {
        Head,
        Link
    } from '@inertiajs/inertia-vue3';

    //import reactive
    import {
        reactive,
        ref,
        onMounted, 
        onUnmounted
    } from 'vue';

    //import inertia adapter
    import {
        Inertia
    } from '@inertiajs/inertia';

    export default {

        //layout
        layout: LayoutWebsite,

        //register component
        components: {
            Head,
            Link
        },

        //props
        props: {
            errors: Object,
            session: Object
        },

        //define composition API
        setup() {

            // --- Logika Navbar (Diambil dari LandingNavbar.vue) ---
            const isScrolled = ref(false);

            const handleScroll = () => {
                isScrolled.value = window.scrollY > 50;
            };

            onMounted(() => {
                window.addEventListener('scroll', handleScroll);
            });

            onUnmounted(() => {
                window.removeEventListener('scroll', handleScroll);
            });
            // ----------------------------------------------------

            //define form state
            const form = reactive({
                email: '',
                password: '',
            });

            const submitting = ref(false);

            // Function Submit Login
            const submit = () => {
                Inertia.post('/user/login', form, {
                    onStart: () => (submitting.value = true),
                    onFinish: () => (submitting.value = false),
                });
            }

            //return form state and submit method
            return {
                form,
                submitting,
                submit,
                isScrolled // Return isScrolled untuk navbar
            };

        }

    }
</script>

<style scoped>
/* --- Custom Colors & Variables (Diambil dari Landing.vue) --- */
:root {
    --navy-primary: #003366;
    --orange-accent: #ff9900;
}
.text-navy { color: var(--navy-primary); }
.bg-navy { background-color: var(--navy-primary); }
.text-warning { color: var(--orange-accent) !important; }

/* Menyesuaikan warna tombol Login */
.btn-primary {
    background-color: var(--navy-primary);
    border-color: var(--navy-primary);
    border-radius: 8px; /* Lebih rounded */
    transition: all 0.3s ease;
}
.btn-primary:hover {
    background-color: #002244;
    border-color: #002244;
    transform: translateY(-1px);
}
.text-primary-hover:hover {
    color: var(--navy-primary);
}


/* --- Typography --- */
.landing-wrapper {
    font-family: 'Poppins', sans-serif;
}

/* --- Navbar (Diambil dari LandingNavbar.vue) --- */
.navbar {
    transition: all 0.3s ease-in-out;
    padding: 1rem 0;
    background: transparent;
}
.navbar.scrolled {
    background: var(--navy-primary); 
    padding: 0.5rem 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.btn-outline-light {
    border-color: white;
    color: white;
}
.btn-outline-light:hover {
    background-color: white;
    color: var(--navy-primary);
}


/* --- Hero Section (Diambil dari Landing.vue) --- */
.hero {
    height: auto; /* Disesuaikan untuk Login */
    min-height: 350px;
    
    position: relative;
    margin-top: 0; /* Tidak perlu margin negatif jika tidak menggunakan layout */
    padding-top: 120px;
    padding-bottom: 80px;
}
.hero .overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to bottom, rgba(0,51,102,0.8), rgba(0,0,0,0.6));
}

/* --- Form Styling (Adopsi gaya tegas/rapi) --- */
.card {
    border-radius: 16px;
}

.login-input-group .input-group-text {
    border-radius: 8px 0 0 8px;
    border-right: none;
    border-color: #dee2e6;
}

.input-tegas {
    border-radius: 0 8px 8px 0 !important;
    border-left: none;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.input-tegas:focus {
    border-color: var(--navy-primary); 	 	
    box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1); 
    outline: none;
}
.input-tegas:focus + .input-group-text {
    border-color: var(--navy-primary);
}

.bg-danger-subtle { background-color: #f8d7da; }
.text-danger-emphasis { color: #842029; }
.bg-success-subtle { background-color: #d1e7dd; }
.text-success-emphasis { color: #0a3622; }
</style>