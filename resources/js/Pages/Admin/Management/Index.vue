<template>
    <Head>
        <title>Profil Akun (Admin Management)</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </Head>

    <div class="container-fluid px-4 py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fs-3 fw-bold text-navy mb-0"> Profil Akun</h2>
                <p class="text-muted small mb-0">Informasi akun dan pengaturan keamanan.</p>
            </div>
        </div>

        <div v-if="$page.props.session?.success"
             class="alert alert-dismissible fade show shadow-sm border-0 mb-4 alert-success bg-success-subtle text-success-emphasis"
             role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ $page.props.session?.success }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-navy-light text-white d-flex align-items-center py-3">
                <i class="fas fa-user-tie fa-lg me-3"></i>
                <h5 class="mb-0 fw-bold">Detail Pengguna</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4 col-12 fw-bold text-muted mb-2"><i class="bi bi-person-fill me-2"></i> Nama Lengkap</div>
                    <div class="col-md-8 col-12 mb-2 fw-bold text-navy">{{ user.name }}</div>
                    <hr class="my-3 text-light">
                    
                    <div class="col-md-4 col-12 fw-bold text-muted mb-2"><i class="bi bi-envelope-fill me-2"></i> Alamat Email</div>
                    <div class="col-md-8 col-12 mb-2 fw-bold text-primary">{{ user.email }}</div>
                    <hr class="my-3 text-light">
                    
                    <div class="col-md-4 col-12 fw-bold text-muted mb-2"><i class="bi bi-person-badge-fill me-2"></i> Role/Jabatan</div>
                    <div class="col-md-8 col-12 mb-2">
                        <span :class="getRoleBadgeClass(user.role)">
                            {{ formatRole(user.role) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-danger-subtle text-danger-emphasis d-flex align-items-center py-3">
                <i class="fas fa-lock fa-lg me-3"></i>
                <h5 class="mb-0 fw-bold">Ganti Password</h5>
            </div>
            <div class="card-body p-4">
                <form @submit.prevent="updatePassword">
                    <p class="text-danger small mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Perhatian: Anda tidak perlu memasukkan password lama untuk pembaruan ini.
                    </p>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input :type="passwordVisibility.new ? 'text' : 'password'" 
                                   class="form-control" 
                                   :class="{'is-invalid': errors.password}"
                                   id="password" 
                                   v-model="form.password" 
                                   autocomplete="new-password" required>
                            <span class="input-group-text bg-white" 
                                  @click="togglePasswordVisibility('new')" 
                                  style="cursor: pointer;">
                                <i :class="passwordVisibility.new ? 'bi bi-eye-fill' : 'bi bi-eye-slash-fill'"></i>
                            </span>
                        </div>
                        <div v-if="errors.password" class="invalid-feedback d-block">
                            {{ errors.password }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input :type="passwordVisibility.confirm ? 'text' : 'password'" 
                                   class="form-control" 
                                   :class="{'is-invalid': errors.password_confirmation}"
                                   id="password_confirmation" 
                                   v-model="form.password_confirmation" 
                                   autocomplete="new-password" required>
                            <span class="input-group-text bg-white" 
                                  @click="togglePasswordVisibility('confirm')" 
                                  style="cursor: pointer;">
                                <i :class="passwordVisibility.confirm ? 'bi bi-eye-fill' : 'bi bi-eye-slash-fill'"></i>
                            </span>
                        </div>
                        <div v-if="errors.password_confirmation" class="invalid-feedback d-block">
                            {{ errors.password_confirmation }}
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="btn btn-navy" 
                            :disabled="form.processing">
                        <span v-if="form.processing">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Mengubah...
                        </span>
                        <span v-else><i class="bi bi-key-fill me-2"></i> Simpan Password Baru</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
import LayoutAdmin from '@/Layouts/Admin.vue'; 
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'; 

export default {
    // Definisi layout
    layout: LayoutAdmin, 
    components: {
        Head, Link, 
    },
    props: {
        user: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            default: () => ({}),
        },
    },

    setup(props) {
        // Form state untuk pembaruan password
        const form = useForm({
            password: '',
            password_confirmation: '',
        });

        // State untuk melacak visibilitas password
        const passwordVisibility = reactive({
            new: false,
            confirm: false,
        });

        // Fungsi untuk meng-toggle visibilitas
        const togglePasswordVisibility = (field) => {
            passwordVisibility[field] = !passwordVisibility[field];
        };

        // Fungsi untuk submit formulir update password
        const updatePassword = () => {
            const updateUrl = '/admin/profile/password'; 
            form.put(updateUrl, { 
                preserveScroll: true, // Mempertahankan posisi scroll setelah redirect
                onSuccess: () => {
                    // Reset field form setelah sukses
                    form.reset('password', 'password_confirmation'); 
                },
                onError: (errors) => {
                    console.error('Validation Errors:', errors);
                    // Inertia secara otomatis mengisi props.errors
                }
            });
        };

        // Fungsi untuk memformat role agar lebih mudah dibaca
        const formatRole = (roleValue) => {
            switch (roleValue) {
                case 'admin': return 'Administrator Sistem';
                case 'ketua_subseksi': return 'Ketua Subseksi';
                case 'peserta': return 'Peserta';
                default: return roleValue.charAt(0).toUpperCase() + roleValue.slice(1).replace(/_/g, ' ');
            }
        };

        // Fungsi untuk menentukan kelas badge role
        const getRoleBadgeClass = (roleValue) => {
            return 'badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle fw-bold px-3 py-2';
        };

        return {
            user: props.user,
            errors: props.errors, 
            form, 
            updatePassword, 
            formatRole,
            getRoleBadgeClass,
            passwordVisibility,
            togglePasswordVisibility,
        };
    }
}
</script>

<style scoped>
/* --- Gaya CSS Kustom (Dipertahankan dari aslinya) --- */

/* Definisi Warna Kustom */
.text-navy { color: #003366 !important; }
.bg-navy-light { background-color: #004488 !important; } 
.btn-navy { background-color: #003366; color: white; border: none; padding: 0.5rem 1rem; border-radius: 6px; transition: all 0.2s ease; }
.btn-navy:hover { background-color: #002244; color: #ffffff; }

/* Gaya Kartu dan Badge */
.card { border-radius: 12px; }

/* Gaya Subtlety (Bootstrap 5.3+ like) */
.bg-success-subtle { background-color: #d1e7dd !important; }
.text-success-emphasis { color: #0f5132 !important; }
.bg-danger-subtle { background-color: #f8d7da !important; }
.text-danger-emphasis { color: #842029 !important; }
.bg-secondary-subtle { background-color: #e2e3e5 !important; }
.text-secondary-emphasis { color: #41464b !important; }
.text-primary { color: #007bff !important; }

/* Menjamin invalid-feedback tetap muncul di Input Group */
.invalid-feedback.d-block {
    display: block !important;
    width: 100%;
    margin-top: 0.25rem;
}
</style>