<template>
    <Head title="Detail Profil Pengguna" />

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center fade-in">
            <div class="col-lg-10">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fs-3 fw-bold text-navy mb-0">Detail Data Profil: {{ user.name }}</h2>
                        <p class="text-muted small mb-0">
                            Grup Katekese: 
                            <span class="badge bg-info text-dark ms-1 fw-bold">{{ user.group == 1 ? 'Katekumen' : (user.group == 0 ? 'Sakramen Baptis Bayi' : 'Lainnya') }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small text-end">
                            Status Akun: 
                            <span :class="{'text-success': user.status === 'confirmed', 'text-warning': user.status !== 'confirmed'}" class="fw-bold">
                                {{ user.status === 'confirmed' ? 'Terverifikasi' : 'Menunggu Konfirmasi' }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- 1. INFORMASI DATA DIRI UTAMA -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-user me-2"></i> 1. Informasi Data Diri Utama</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-navy">Nama Lengkapp</label>
                                <p class="form-control-static detail-value">{{ user.name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-navy">Email</label>
                                <p class="form-control-static detail-value">{{ user.email }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-navy">No. Telepon</label>
                                <p class="form-control-static detail-value">{{ user.contact || '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN TAMBAHAN: GANTI PASSWORD -->
                <div class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-lock me-2"></i> Ganti Password Akun</h5>
                        
                        <form @submit.prevent="submitPasswordChange">
                            <p class="text-muted small mb-3">
                                <strong>Gunakan kolom di bawah ini untuk mengatur password baru Anda. Kosongkan jika Anda tidak ingin mengubah password.</strong>
                            </p>

                            <div class="row">
                                <!-- Password Baru -->
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold text-navy">Password Baru</label>
                                    <div class="input-group shadow-sm rounded-pill overflow-hidden">
                                        <input :type="passwordFieldType.password" class="form-control border-0" id="password" v-model="form.password" placeholder="Minimal 8 karakter">
                                        <button type="button" class="btn btn-outline-secondary border-0" @click="togglePassword('password')">
                                            <!-- Ikon diperbaiki ke Font Awesome (fa) -->
                                            <i class="fa" :class="passwordFieldType.password === 'password' ? 'bi-eye' : 'bi-eye-slash'"></i>
                                        </button>
                                    </div>
                                    <div v-if="errors.password" class="error-message mt-1">
                                        {{ errors.password }}
                                    </div>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="col-md-6 mb-4">
                                    <label for="password_confirmation" class="form-label fw-bold text-navy">Ketik Ulang Password</label>
                                    <div class="input-group shadow-sm rounded-pill overflow-hidden">
                                        <input :type="passwordFieldType.password_confirmation" class="form-control border-0" id="password_confirmation" v-model="form.password_confirmation" placeholder="Ulangi Password Baru">
                                        <button type="button" class="btn btn-outline-secondary border-0" @click="togglePassword('password_confirmation')">
                                            <!-- Ikon diperbaiki ke Font Awesome (fa) -->
                                            <i class="fa" :class="passwordFieldType.password_confirmation === 'password' ? 'bi-eye' : 'bi-eye-slash'"></i>
                                        </button>
                                    </div>
                                    <div v-if="errors.password_confirmation" class="error-message mt-1">
                                        {{ errors.password_confirmation }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end pt-2">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" :disabled="isSubmitting">
                                    <i class="fa fa-save me-1"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 2. DATA KHUSUS KATEKUMEN/BAPTIS BAYI -->
                <div v-if="user.group == 1">
                    <div class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-book me-2"></i> 2. Data Khusus Katekumen</h5>
                            
                            <h6 class="fw-bold text-secondary mb-3 pt-3 border-top">Detail Umum Katekumen</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Pendidikan Terakhir</label>
                                    <p class="form-control-static detail-value">{{ user.data_katekumen?.education || '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Penjamin</label>
                                    <p class="form-control-static detail-value">{{ user.data_katekumen?.namePenjamin || '-' }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold text-navy">Alamat</label>
                                    <p class="form-control-static detail-value">{{ user.data_katekumen?.address || 'Belum diisi' }}</p>
                                </div>
                            </div>
                            
                            <h6 class="fw-bold text-secondary mb-3 pt-3 border-top">Detail Riwayat</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Guru</label>
                                    <p class="form-control-static detail-value">{{ user.data_riwayat?.nameGuru || 'Belum diisi' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Tanggal Mulai</label>
                                    <p class="form-control-static detail-value">{{ user.data_riwayat?.dateStart ? formatDate(user.data_riwayat.dateStart) : '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Tanggal Selesai</label>
                                    <p class="form-control-static detail-value">{{ user.data_riwayat?.dateEnd ? formatDate(user.data_riwayat.dateEnd) : '-' }}</p>
                                </div>
                            </div>
                            
                            <h6 class="fw-bold text-secondary mb-3 pt-3 border-top">Detail Menikah</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Status Menikah</label>
                                    <p class="form-control-static detail-value">{{ user.data_menikah?.statusMarried || '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Pasangan</label>
                                    <p class="form-control-static detail-value">{{ user.data_menikah?.namePasangan || '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else-if="user.group == 0">
                    <div class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-hands-holding-child me-2"></i> 2. Data Khusus Baptis Bayi</h5>
                            
                            <h6 class="fw-bold text-secondary mb-3 pt-3">Detail Baptis</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Calon Baptis</label>
                                    <p class="form-control-static detail-value">{{ user.data_baptis?.name || 'Belum diisi' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Pastoor</label>
                                    <p class="form-control-static detail-value">{{ user.data_baptis?.namePastoor || '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Status</label>
                                    <p class="form-control-static detail-value">{{ user.data_baptis?.status || '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 3. DATA ANGGOTA KELUARGA -->
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-users me-2"></i> 3. Data Anggota Keluarga</h5>

                        <div v-if="user.data_keluarga && user.data_keluarga.length > 0" class="row">
                            <div v-for="(family, fIndex) in user.data_keluarga" :key="fIndex" class="col-md-6 mb-3">
                                <div class="card card-body bg-light h-100 p-3 shadow-sm border-0">
                                    <span class="fw-bold text-dark">{{ family.name }}</span>
                                    <small class="text-secondary mb-2">Hubungan: {{ family.relation }} | Agama: {{ family.religion || '-' }}</small>
                                    <small class="text-muted">Kontak: {{ family.contact || '-' }}</small>
                                    <small class="text-muted">Alamat: {{ family.address || 'Alamat tidak tersedia' }}</small>
                                </div>
                            </div>
                        </div>
                        <div v-else class="alert alert-warning small">Data keluarga belum diisi atau tidak tersedia.</div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="/user/dashboard" class="btn btn-outline-secondary ">
                        <i class="fa fa-arrow-left me-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import LayoutWebsite from '../../../Layouts/User.vue';
// Tambahkan impor yang diperlukan untuk fungsionalitas ganti password
import { reactive, ref } from 'vue'; // ref untuk isSubmitting
import { Inertia } from '@inertiajs/inertia'; // Digunakan untuk mengirim data form
import Swal from 'sweetalert2'; // Digunakan untuk notifikasi

// PROPS yang diterima dari ProfileDetailController
const props = defineProps({
    registrationData: {
        type: Object,
        default: () => ({})
    },
    user: {
        type: Object,
        required: true
    },
    // Tambahkan props errors untuk menampilkan validasi (diperlukan dari controller)
    errors: {
        type: Object,
        default: () => ({})
    }
});

// Helper: Format Tanggal (diambil dari DashboardController)
const formatDate = (dateString) => {
    if (!dateString) return '-';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    try {
        const date = new Date(dateString);
        if (dateString.length === 10) {
            return new Date(dateString + 'T00:00:00Z').toLocaleDateString('id-ID', options);
        }
        return date.toLocaleDateString('id-ID', options);
    } catch (e) {
        return dateString;
    }
};



// Form state untuk password
const form = reactive({
    password: '',
    password_confirmation: '',
});

// Objek untuk tipe input password
const passwordFieldType = reactive({
    password: 'password',
    password_confirmation: 'password'
});

// Status pengiriman form
const isSubmitting = ref(false);

// Fungsi untuk toggle tipe input password
const togglePassword = (fieldType) => {
    if (fieldType in passwordFieldType) {
        passwordFieldType[fieldType] = passwordFieldType[fieldType] === 'password' ? 'text' : 'password';
    }
};

// Metode submit untuk ganti password (Diselaraskan dengan route: /user/data-profile/{id}/update-password)
const submitPasswordChange = () => {
    if (isSubmitting.value) return;

    // Klien-side check untuk memastikan password match (sesuai referensi)
    if ((form.password || form.password_confirmation) && form.password !== form.password_confirmation) {
        Swal.fire({
            title: "Gagal!",
            text: "Password Baru dan Konfirmasi Password harus sama.",
            icon: "error",
            confirmButtonColor: '#003366',
        });
        return;
    }
    
    if (!form.password && !form.password_confirmation) {
        Swal.fire({
            title: "Peringatan",
            text: "Kolom Password Baru harus diisi jika Anda ingin mengubah password.",
            icon: "warning",
            confirmButtonColor: '#003366',
        });
        return;
    }

    isSubmitting.value = true;

    // *** PERBAIKAN ROUTE URL DI SINI ***
    Inertia.put(
        `/user/data-profile/${props.user.id}/update-password`, // Menggunakan path yang sesuai dengan Canvas route
        {
            password: form.password,
            password_confirmation: form.password_confirmation,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                isSubmitting.value = false;
                // Bersihkan kolom password
                form.password = '';
                form.password_confirmation = '';
                
                Swal.fire({
                    title: "Berhasil!",
                    text: "Password berhasil diperbarui.",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2000,
                    confirmButtonColor: '#003366'
                });
            },
            onError: (errors) => {
                isSubmitting.value = false;
                // SweetAlert untuk error umum (jika validasi server gagal)
                if (Object.keys(errors).length > 0) {
                     Swal.fire({
                        title: "Gagal Update",
                        text: "Terdapat kesalahan validasi. Silakan periksa kolom.",
                        icon: "error",
                        confirmButtonColor: '#003366',
                    });
                }
            },
            onFinish: () => {
                isSubmitting.value = false;
            }
        }
    );
};
</script>

<script>
export default { 
    // Menggunakan Layout yang sama seperti Dashboard
    layout: LayoutWebsite,
    // Menambahkan nama route ke sini agar bisa diakses di template
    methods: {
        route(name) {
            return window.route(name);
        }
    }
}
</script>

<style scoped>
/* CSS dari komponen awal */
.fade-in { animation: fadeIn 0.8s ease-in-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* CSS Kustom yang dipindahkan dari mounted() dan disesuaikan */
:root {
    --navy-primary: #003366;
}
.text-navy { 
    color: var(--navy-primary); 
}
.card { 
    border-radius: 16px; 
}
.card-header { /* Kelas ini tidak digunakan lagi, tapi dipertahankan untuk referensi */
    border-bottom: none; 
    border-radius: 15px 15px 0 0 !important; 
}

/* Gaya baru untuk meniru tampilan form yang non-aktif */
.form-control-static {
    display: block;
    padding: 0.7rem 1rem;
    font-size: 0.95rem;
    line-height: 1.5;
    color: #495057; /* Warna teks yang jelas */
    background-color: #f8f9fa; /* Warna latar belakang ringan */
    border: 1px solid #e9ecef; /* Border lembut */
    border-radius: 8px;
    margin-top: 0.2rem;
    word-wrap: break-word; 
}
.form-label {
    margin-bottom: 0.1rem;
    font-size: 0.9rem; /* Lebih kecil untuk label */
}
.detail-value {
    min-height: calc(1.5em + 1.4rem + 2px); /* Menjaga konsistensi tinggi */
}

/* Tambahan CSS untuk form password (dari referensi) */
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
.btn-primary { /* Mengubah .btn-navy menjadi .btn-primary */
    background-color: #003366;
    color: white;
    border: none;
    transition: all 0.2s ease;
}

.btn-primary:hover:not(:disabled) {
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