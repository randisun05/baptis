<template>
    <div class="container-fluid px-4 py-4">

        <Head title="Administrator | Edit Akun Pengguna" />

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fs-3 fw-bold text-navy mb-0">Edit Akun Pengguna</h2>
                <p class="text-muted small mb-0">Perbarui detail akun untuk user: <span class="fw-bold">{{ user.name }}</span>.</p>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <form @submit.prevent="submit">

                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold text-navy small">Nama</label>
                                <input type="text" class="form-control rounded-pill shadow-sm" id="name" v-model="form.name" placeholder="Masukkan Nama Lengkap">
                                <div v-if="errors.name" class="error-message mt-1">
                                    {{ errors.name }}
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold text-navy small">Email</label>
                                <input type="email" class="form-control rounded-pill shadow-sm" id="email" v-model="form.email" placeholder="Masukkan Email">
                                <div v-if="errors.email" class="error-message mt-1">
                                    {{ errors.email }}
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="mb-3">
                                <label for="role" class="form-label fw-bold text-navy small">Role</label>
                                <select class="form-select rounded-pill shadow-sm" id="role" v-model="form.role">
                                    <option value="" disabled>Pilih Role</option>
                                    <option value="administrator">Administrator</option>
                                    <option value="ketua_wakil_subseksi">Ketua & Wakil Sub-Seksi</option>
                                    <option value="peserta">Peserta</option>
                                </select>
                                <div v-if="errors.role" class="error-message mt-1">
                                    {{ errors.role }}
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            <p class="text-muted small mb-3">Kosongkan kolom password di bawah jika Anda tidak ingin mengubah password.</p>

                            <!-- Password Baru -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold text-navy small">Password Baru</label>
                                <div class="input-group shadow-sm rounded-pill overflow-hidden">
                                    <input :type="passwordFieldType.password" class="form-control border-0" id="password" v-model="form.password" placeholder="Minimal 8 karakter">
                                    <button type="button" class="btn btn-outline-secondary border-0" @click="togglePassword('password')">
                                        <i class="bi" :class="passwordFieldType.password === 'password' ? 'bi-eye' : 'bi-eye-slash'"></i>
                                    </button>
                                </div>
                                <div v-if="errors.password" class="error-message mt-1">
                                    {{ errors.password }}
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-bold text-navy small">Ketik Ulang Password</label>
                                <div class="input-group shadow-sm rounded-pill overflow-hidden">
                                    <input :type="passwordFieldType.password_confirmation" class="form-control border-0" id="password_confirmation" v-model="form.password_confirmation" placeholder="Ulangi Password Baru">
                                    <button type="button" class="btn btn-outline-secondary border-0" @click="togglePassword('password_confirmation')">
                                        <i class="bi" :class="passwordFieldType.password_confirmation === 'password' ? 'bi-eye' : 'bi-eye-slash'"></i>
                                    </button>
                                </div>
                                <div v-if="errors.password_confirmation" class="error-message mt-1">
                                    {{ errors.password_confirmation }}
                                </div>
                            </div>


                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-3 pt-3">
                                <Link :href="`/admin/setting`" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </Link>
                                <button type="submit" class="btn btn-navy rounded-pill px-4 shadow-sm">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Update Pengguna
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import layout
import LayoutAdmin from '../../../Layouts/Admin.vue';

//import Head and Link from Inertia
import { Head, Link } from '@inertiajs/inertia-vue3';

//import ref from vue
import { reactive } from 'vue';

//import inertia adapter
import { Inertia } from '@inertiajs/inertia';

//import sweet alert2
import Swal from 'sweetalert2';


export default {

    //layout
    layout: LayoutAdmin,

    //register component
    components: {
        Head,
        Link,
    },

    //props
    props: {
        user: Object, // Data pengguna yang akan diedit
        errors: Object,
    },

    //inisialisasi composition API
    setup(props) {
        // Initial form state from user props, excluding NIP and Position
        const form = reactive({
            name: props.user.name,
            email: props.user.email,
            role: props.user.role,
            password: '',
            password_confirmation: '',
        });

        // Object to hold the current type of password input fields
        const passwordFieldType = reactive({
            password: 'password',
            password_confirmation: 'password'
        });

        // Function to toggle the password input type between 'password' and 'text'
        const togglePassword = (fieldType) => {
            if (fieldType in passwordFieldType) {
                passwordFieldType[fieldType] = passwordFieldType[fieldType] === 'password' ? 'text' : 'password';
            }
        };

        //submit method
        const submit = () => {
            // Client-side password match check
            if (form.password && form.password_confirmation && form.password !== form.password_confirmation) {
                Swal.fire({
                    title: "Gagal!",
                    text: "Password Baru dan Konfirmasi Password harus sama.",
                    icon: "error",
                    confirmButtonColor: '#003366',
                });
                return;
            }

            Inertia.put(
                `/admin/setting/${props.user.id}`,
                {
                    // Only send data fields present in the form
                    name: form.name,
                    email: form.email,
                    role: form.role,
                    password: form.password, // Send empty string if no change
                    password_confirmation: form.password_confirmation, // Send empty string if no change
                },
                {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Akun Pengguna Berhasil Diupdate.",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2000,
                            confirmButtonColor: '#003366'
                        });
                    },
                }
            );
        };

        //return
        return {
            form,
            submit,
            passwordFieldType,
            togglePassword,
        }
    }
}
</script>

<style scoped>
/* --- Theme Variables --- */
:root {
    --navy-primary: #003366;
    --navy-hover: #002244;
}

.text-navy { color: #003366; }
.card { border-radius: 1rem; }

/* --- Form Control Consistency (Matching the Index Page Look) --- */
.form-control, .form-select {
    border-color: #e0e0e0;
    transition: all 0.2s ease;
}
.form-control:focus, .form-select:focus {
    border-color: #003366;
    box-shadow: 0 0 0 0.25rem rgba(0, 51, 102, 0.25);
}

/* For input-group to maintain rounded appearance */
.input-group.rounded-pill > .form-control {
    border-top-left-radius: 50rem !important;
    border-bottom-left-radius: 50rem !important;
}
.input-group.rounded-pill > .btn {
    border-top-right-radius: 50rem !important;
    border-bottom-right-radius: 50rem !important;
}

/* --- Button Styles --- */
.btn-navy {
    background-color: #003366;
    color: white;
    border: none;
    transition: all 0.2s ease;
}

.btn-navy:hover {
    background-color: #002244;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 51, 102, 0.3) !important;
}

/* --- Error Message Styles --- */
.error-message {
    color: #dc3545; /* Bootstrap Red */
    background-color: #f8d7da; /* Light Red background */
    border: 1px solid #f5c6cb;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
}
</style>