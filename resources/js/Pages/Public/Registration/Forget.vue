<template>
    <Head>
        <title>Lupa Password - Paroki Santa Melania</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    </Head>

    <div class="landing-wrapper">
        
        <section class="hero d-flex align-items-center" style="min-height: 350px;">
            <div class="overlay"></div>
            <div class="container position-relative text-center text-white z-1">
                <h1 class="display-5 fw-bold mb-3">Lupa Password</h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 700px;">
                    Masukkan alamat email Anda untuk menerima tautan reset password.
                </p>
            </div>
        </section>
        
        <section class="py-5 bg-light d-flex justify-content-center" style="margin-top: -100px; z-index: 10; position: relative;">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <div class="card shadow-lg p-4 p-md-5 border-0 rounded-4">
                            <h3 class="fw-bold text-navy text-center mb-4">Reset Password Akun</h3>

                            <div v-if="form.errors.message" class="alert alert-danger bg-danger-subtle text-danger-emphasis alert-dismissible fade show border-0 rounded-3 small">
                                <i class="fas fa-exclamation-triangle me-2"></i> {{ form.errors.message }}
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
                                                :class="{ 'is-invalid': form.errors.email }"
                                            >
                                        </div>
                                        <div v-if="form.errors.email" class="text-danger small mt-1">{{ form.errors.email }}</div>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" :disabled="form.processing">
                                            <span v-if="form.processing">
                                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                Memproses...
                                            </span>
                                            <span v-else>
                                                <i class="fas fa-redo me-2"></i> Reset Password
                                            </span>
                                        </button>
                                        
                                        <p class="text-center mt-3 mb-0 small text-muted">
                                            <Link href="/user/login" class="btn btn-outline-secondary btn-sm w-100 fw-bold rounded-pill">
                                                <i class="fas fa-sign-in-alt me-2"></i> Kembali ke Login
                                            </Link>
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

    //import Head, Link, dan useForm dari Inertia
    import {
        Head,
        Link,
        useForm
    } from '@inertiajs/inertia-vue3';

    //import reactive, ref, onMounted, onUnmounted
    import {
        ref,
        onMounted, 
        onUnmounted
    } from 'vue';

    export default {

        //layout
        layout: LayoutWebsite,

        //register component
        components: {
            Head,
            Link
        },

        //props (Inertia otomatis menyediakan errors)
        props: {
            errors: Object, 
            session: Object
        },

        //define composition API
        setup() {

            // --- Logika Navbar (Dipertahankan) ---
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

            // Inisialisasi form state menggunakan useForm
            const form = useForm({
                email: '',
            });

            // Function Submit Reset Password
            const submit = () => {
                // Menggunakan URL biasa (hardcoded)
                form.post('/forget-password/email', { // PERUBAHAN DI SINI
                  preserveScroll: true,
                });
            }

            //return form state and submit method
            return {
                form,
                submit,
                isScrolled
            };

        }
    }
</script>


<style scoped>
/* --- Custom Colors & Variables --- */
:root {
    --navy-primary: #003366;
    --orange-accent: #ff9900;
}
.text-navy { color: var(--navy-primary); }
.bg-navy { background-color: var(--navy-primary); }
.text-warning { color: var(--orange-accent) !important; }

.btn-primary {
    background-color: #002244;
    border-color: #002244;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #001a33;
    border-color: #001a33;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.btn-primary:active {
    background-color: #001326;
    border-color: #001326;
    transform: translateY(0);
    box-shadow: none;
}

.text-primary-hover:hover {
    color: var(--navy-primary);
}


/* --- Typography --- */
.landing-wrapper {
    font-family: 'Poppins', sans-serif;
}

/* --- Hero Section --- */
.hero {
    height: auto; 
    min-height: 350px;
    
    position: relative;
    margin-top: 0;
    padding-top: 120px;
    padding-bottom: 80px;
}
.hero .overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to bottom, rgba(0,51,102,0.8), rgba(0,0,0,0.6));
}

/* --- Form Styling --- */
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


.btn-outline-secondary {
    border-color: #adb5bd;
    color: #6c757d;
    transition: all 0.3s ease;
}
.btn-outline-secondary:hover {
    background-color: #f8f9fa;
    color: var(--navy-primary);
    border-color: var(--navy-primary);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
}
</style>