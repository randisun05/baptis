<template>
    <Head>
        <title>Reset Password - Paroki Santa Melania</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    </Head>

    <div class="landing-wrapper">
        
        <section class="hero d-flex align-items-center" style="min-height: 350px;">
            <div class="overlay"></div>
            <div class="container position-relative text-center text-white z-1">
                <h1 class="display-5 fw-bold mb-3">Atur Ulang Password</h1>
                <p class="lead text-white-50 mx-auto" style="max-width: 700px;">
                    Masukkan password baru Anda untuk melanjutkan.
                </p>
            </div>
        </section>
        
        <section class="py-5 bg-light d-flex justify-content-center" style="margin-top: -100px; z-index: 10; position: relative;">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <div class="card shadow-lg p-4 p-md-5 border-0 rounded-4">
                            <h3 class="fw-bold text-navy text-center mb-4">Password Baru</h3>

                            <div v-if="$page.props.session?.error" class="alert alert-danger bg-danger-subtle text-danger-emphasis alert-dismissible fade show border-0 rounded-3 small">
                                <i class="fas fa-exclamation-triangle me-2"></i> {{ $page.props.session.error }}
                            </div>
                            <div v-if="$page.props.session?.success" class="alert alert-success bg-success-subtle text-success-emphasis alert-dismissible fade show border-0 rounded-3 small">
                                <i class="fas fa-check-circle me-2"></i> {{ $page.props.session.success }}
                            </div>

                            <form @submit.prevent="submit" class="mt-4">
                                <div class="mb-3 p-3 bg-white border rounded-3 small text-muted">
                                    <i class="fas fa-user-circle me-2"></i>
                                    Reset untuk: <span class="fw-bold">{{ member.email }}</span>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label small fw-bold text-navy">Password Baru</label>
                                    <div class="input-group input-group-lg login-input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fa fa-lock text-muted"></i>
                                        </span>
                                        <input 
                                            :type="showPassword ? 'text' : 'password'"
                                            class="form-control border-start-0 input-tegas" 
                                            v-model="form.password" 
                                            id="password"
                                            placeholder="Masukkan password baru"
                                            :class="{ 'is-invalid': form.errors.password }"
                                        >
                                    </div>
                                    <div v-if="form.errors.password" class="text-danger small mt-1">{{ form.errors.password }}</div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label small fw-bold text-navy">Konfirmasi Password Baru</label>
                                    <div class="input-group input-group-lg login-input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fa fa-key text-muted"></i>
                                        </span>
                                        <input 
                                            :type="showPassword ? 'text' : 'password'"
                                            class="form-control border-start-0 input-tegas" 
                                            v-model="form.password_confirmation" 
                                            id="password_confirmation"
                                            placeholder="Ulangi password baru"
                                            :class="{ 'is-invalid': form.errors.password_confirmation }"
                                        >
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-secondary border-start-0" 
                                            @click="togglePasswordVisibility"
                                        >
                                            <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                        </button>
                                    </div>
                                    <div v-if="form.errors.password_confirmation" class="text-danger small mt-1">{{ form.errors.password_confirmation }}</div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" :disabled="form.processing">
                                        <span v-if="form.processing">
                                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                            Mengatur Ulang...
                                        </span>
                                        <span v-else>
                                            <i class="fas fa-check-circle me-2"></i> Simpan Password Baru
                                        </span>
                                    </button>
                                    
                                    <p class="text-center mt-3 mb-0 small text-muted">
                                        <Link href="/user/login" class="btn btn-outline-secondary btn-sm w-100 fw-bold rounded-pill">
                                            <i class="fas fa-sign-in-alt me-2"></i> Kembali ke Login
                                        </Link>
                                    </p>
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

    //import ref, onMounted, onUnmounted
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

        //props dari controller
        props: {
            member: Object, // Berisi data member (email dan code_password)
            errors: Object, 
        },

        //define composition API
        setup(props) {

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

            // State untuk visibilitas password
            const showPassword = ref(false);

            const togglePasswordVisibility = () => {
                showPassword.value = !showPassword.value;
            };

            // Inisialisasi form state menggunakan useForm
            const form = useForm({
                password: '',
                password_confirmation: '',
            });

           // Function Submit Reset Password
            const submit = () => {
                // Endpoint POST ke URL hardcoded: /user/reset-password/{code_password}
                const resetUrl = `/user/reset-password/${props.member.code_password}/reset`; // Menggunakan template literal/string concatenation

                form.put(resetUrl, { // PERUBAHAN DI SINI: Menggunakan resetUrl
                    preserveScroll: true,
                });
            }
           
            return {
                form,
                submit,
                isScrolled,
                showPassword,
                togglePasswordVisibility,
                member: props.member, // Kembalikan member agar dapat diakses di template
            };
        }
    }
</script>


<style scoped>
/* --- Custom Colors & Variables (Diambil dari file Forget.vue) --- */
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

/* Styling Tombol Outline Sekunder (Kembali ke Login) */
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