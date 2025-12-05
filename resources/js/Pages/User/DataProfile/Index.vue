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
                            <span class="badge bg-info text-dark ms-1 fw-bold">{{ getGroupName(user.group) }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small text-end">
                            Status Akun: 
                            <span :class="getStatusBadgeClass(user.status)" class="fw-bold">
                                {{ formatStatus(user.status) }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-user me-2"></i> 1. Informasi Data Diri Utama</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-navy">Nama Lengkap</label>
                                <p class="form-control-static detail-value">{{ user.name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-navy">Nomor Registrasi</label>
                                <p class="form-control-static detail-value">{{ user.number || '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-navy">Email</label>
                                <p class="form-control-static detail-value">{{ user.email || '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-navy">No. Telepon</label>
                                <p class="form-control-static detail-value">{{ user.contact || '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-lock me-2"></i> Ganti Password Akun</h5>
                        
                        <form @submit.prevent="submitPasswordChange">
                            <p class="text-muted small mb-3">
                                <strong>Gunakan kolom di bawah ini untuk mengatur password baru Anda. Kosongkan jika Anda tidak ingin mengubah password.</strong>
                            </p>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold text-navy">Password Baru</label>
                                    <div class="input-group shadow-sm rounded-pill overflow-hidden">
                                        <input :type="passwordFieldType.password" class="form-control border-0" id="password" v-model="form.password" placeholder="Minimal 8 karakter">
                                        <button type="button" class="btn btn-outline-secondary border-0" @click="togglePassword('password')">
                                            <i class="fa" :class="passwordFieldType.password === 'password' ? 'bi-eye' : 'bi-eye-slash'"></i>
                                        </button>
                                    </div>
                                    <div v-if="errors.password" class="error-message mt-1">
                                        {{ errors.password }}
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="password_confirmation" class="form-label fw-bold text-navy">Ketik Ulang Password</label>
                                    <div class="input-group shadow-sm rounded-pill overflow-hidden">
                                        <input :type="passwordFieldType.password_confirmation" class="form-control border-0" id="password_confirmation" v-model="form.password_confirmation" placeholder="Ulangi Password Baru">
                                        <button type="button" class="btn btn-outline-secondary border-0" @click="togglePassword('password_confirmation')">
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

                <div v-if="user.group == 1 && user.data_katekumen">
                    <div class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-book me-2"></i> 2. Data Khusus Katekumen</h5>
                            
                            <h6 class="fw-bold text-secondary mb-3 pt-3 border-top">Detail Umum Katekumen</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Pendidikan Terakhir</label>
                                    <p class="form-control-static detail-value">{{ user.data_katekumen.education || '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Penjamin</label>
                                    <p class="form-control-static detail-value">{{ user.data_katekumen.namePenjamin || '-' }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold text-navy">Alamat</label>
                                    <p class="form-control-static detail-value">{{ user.data_katekumen.address || 'Belum diisi' }}</p>
                                </div>
                            </div>
                            
                            <h6 class="fw-bold text-secondary mb-3 pt-3 border-top">Detail Riwayat ({{ determineHistoryTypeLabel(user.data_riwayat) }})</h6>
                            <div v-if="user.data_riwayat" class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Agama</label>
                                    <p class="form-control-static detail-value">{{ user.data_riwayat.religion || '-' }}</p>
                                </div>
                                <template v-if="determineHistoryTypeLabel(user.data_riwayat) === 'I. Pelajaran Katolik'">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Lokasi / Hari</label>
                                        <p class="form-control-static detail-value">{{ user.data_riwayat.location || '-' }} / {{ user.data_riwayat.schedule || '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Guru Pengajar</label>
                                        <p class="form-control-static detail-value">{{ user.data_riwayat.nameGuru || '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Mulai / Selesai</label>
                                        <p class="form-control-static detail-value">{{ formatDate(user.data_riwayat.dateStart) || '-' }} / {{ formatDate(user.data_riwayat.dateEnd) || '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Pernah Ikut di</label>
                                        <p class="form-control-static detail-value">{{ user.data_riwayat.participateBefore || '-' }}</p>
                                    </div>
                                </template>
                                <template v-else-if="determineHistoryTypeLabel(user.data_riwayat) === 'II. Baptis Kristen'">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Gereja / Alamat</label>
                                        <p class="form-control-static detail-value">{{ user.data_riwayat.nameGereja || '-' }} / {{ user.data_riwayat.addressGereja || '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Dibaptis Oleh / Tgl</label>
                                        <p class="form-control-static detail-value">{{ user.data_riwayat.namePriest || '-' }} / {{ formatDate(user.data_riwayat.dateBaptis) || '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">No. Surat Baptis</label>
                                        <p class="form-control-static detail-value">{{ user.data_riwayat.numberBaptis || '-' }}</p>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="col-12">
                                        <p class="text-muted fst-italic detail-value">Tidak ada detail riwayat yang terisi.</p>
                                    </div>
                                </template>
                            </div>
                            <div v-else class="col-12">
                                <p class="text-muted fst-italic detail-value">Data Riwayat Agama belum diisi.</p>
                            </div>


                            <h6 class="fw-bold text-secondary mb-3 pt-3 border-top">Detail Status Pernikahan</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Status Pernikahan</label>
                                    <p class="form-control-static detail-value">{{ user.data_menikah?.statusMarried || 'Belum diisi' }}</p>
                                </div>
                                <div v-if="user.data_menikah && user.data_menikah.statusMarried && user.data_menikah.statusMarried !== 'Belum Menikah' && user.data_menikah.statusMarried !== 'Pernah Menikah'" class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Pasangan</label>
                                    <p class="form-control-static detail-value">{{ user.data_menikah.namePasangan || '-' }}</p>
                                </div>
                            </div>
                            <div v-if="user.data_menikah && user.data_menikah.statusMarried && user.data_menikah.statusMarried !== 'Belum Menikah'" class="p-3 border rounded bg-light-subtle mt-3">
                                <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Detail {{ user.data_menikah.statusMarried }}</h6>
                                
                                <div v-if="user.data_menikah.statusMarried === 'Menikah Katolik'">
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">Gereja/Kota:</strong> {{ user.data_menikah.placeMarried1 || '-' }} / {{ user.data_menikah.cityMarried1 || '-' }}</p>
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">Tanggal Nikah:</strong> {{ formatDate(user.data_menikah.dateMarried1) || '-' }}</p>
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">No. Surat:</strong> {{ user.data_menikah.numberMarried1 || '-' }}</p>
                                </div>
                                <div v-else-if="user.data_menikah.statusMarried === 'Menikah Kristen'">
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">Tempat/Kota:</strong> {{ user.data_menikah.placeMarried2 || '-' }} / {{ user.data_menikah.cityMarried2 || '-' }}</p>
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">Tanggal Nikah:</strong> {{ formatDate(user.data_menikah.dateMarried2) || '-' }}</p>
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">No. Surat:</strong> {{ user.data_menikah.numberMarried2 || '-' }}</p>
                                </div>
                                <div v-else-if="user.data_menikah.statusMarried === 'Menikah Sipil'">
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">Kota:</strong> {{ user.data_menikah.cityMarried3 || '-' }}</p>
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">Tanggal Nikah:</strong> {{ formatDate(user.data_menikah.dateMarried3) || '-' }}</p>
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">No. Surat:</strong> {{ user.data_menikah.numberMarried3 || '-' }}</p>
                                </div>
                                <div v-else-if="user.data_menikah.statusMarried === 'Pernah Menikah'">
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">Mantan Pasangan:</strong> {{ user.data_menikah.nameMantan || '-' }}</p>
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">Status Berakhir:</strong> {{ user.data_menikah.statusMantan || '-' }}</p>
                                    <p class="mb-1 small"><strong class="text-muted me-2" style="width: 150px; display: inline-block;">Tahun Berakhir:</strong> {{ user.data_menikah.yearMantan || '-' }}</p>
                                </div>
                                <div v-else class="text-muted fst-italic small mt-3">Detail pernikahan lanjutan tidak tersedia.</div>
                            </div>

                        </div>
                    </div>
                </div>

                <div v-else-if="user.group == 0 && user.data_baptis">
                    <div class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-hands-holding-child me-2"></i> 2. Data Khusus Baptis Bayi</h5>
                            
                            <h6 class="fw-bold text-secondary mb-3 pt-3">Detail Baptis</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Calon Baptis</label>
                                    <p class="form-control-static detail-value">{{ user.data_baptis.name || user.name || 'Belum diisi' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Wali Baptis</label>
                                    <p class="form-control-static detail-value">{{ user.data_baptis.nameWali || '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Status Wali Baptis</label>
                                    <p class="form-control-static detail-value">{{ user.data_baptis.baptisStatus || '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-navy">Nama Pastoor</label>
                                    <p class="form-control-static detail-value">{{ user.data_baptis.namePastoor || '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else-if="user.group != 0 && user.group != 1" class="text-center mt-4">
                    <p class="text-muted fst-italic">Tidak ada data khusus kelompok untuk peserta ini.</p>
                </div>
                
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-navy mb-4 border-bottom pb-2"><i class="fa fa-users me-2"></i> 3. Data Anggota Keluarga</h5>

                        <div v-if="user.data_keluarga && user.data_keluarga.length > 0" class="row">
                            <div v-for="(family, fIndex) in user.data_keluarga" :key="fIndex" class="col-md-6 mb-3">
                                <div class="card card-body bg-light h-100 p-3 shadow-sm border-0">
                                    <span class="fw-bold text-dark">{{ family.name }}</span>
                                    <small class="text-secondary mb-2">Hubungan: {{ family.relation || '-' }} | Agama: {{ family.religion || '-' }}</small>
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
import { reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2'; 

// PROPS yang diterima
const props = defineProps({
    registrationData: {
        type: Object,
        default: () => ({})
    },
    user: { // Prop 'user' diasumsikan membawa data utama dan relasi yang sama dengan 'data' di kode pertama
        type: Object,
        required: true
    },
    errors: {
        type: Object,
        default: () => ({})
    }
});

// =================================================================
// === FUNGSI HELPER YANG DIADAPTASI DARI KODE PERTAMA =============
// =================================================================

// Helper: Format Tanggal (diambil dari kode awal)
const formatDate = (dateString) => {
    if (!dateString) return null;
    try {
        if (dateString && dateString.length > 10 && !/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
            return new Date(dateString).toISOString().slice(0, 10);
        }
        if (dateString) {
            return dateString.substring(0, 10); // Pastikan hanya ambil bagian tanggal
        }
        return null;
    } catch (e) {
        return dateString; // Kembalikan string asli jika gagal
    }
};


// Fungsi untuk menentukan tipe riwayat
const determineHistoryTypeLabel = (dataRiwayat) => {
    if (!dataRiwayat) return 'Tidak Ada Riwayat';
    // Cek Riwayat Pelajaran Katolik (I) - Menggunakan field yang relevan
    if (dataRiwayat.location || dataRiwayat.schedule || dataRiwayat.dateStart || dataRiwayat.nameGuru || dataRiwayat.participateBefore) {
        return 'I. Pelajaran Katolik';
    }
    // Cek Riwayat Baptis Kristen (II) - Menggunakan field yang relevan
    if (dataRiwayat.nameGereja || dataRiwayat.namePriest || dataRiwayat.dateBaptis || dataRiwayat.numberBaptis) {
        return 'II. Baptis Kristen';
    }
    
    return 'Riwayat Lain';
};

// Fungsi helper Kelompok (dari kode pertama)
const getGroupName = (groupValue) => {
    if (groupValue === 1) {
        return 'Katekumen';
    } else if (groupValue === 0) {
        return 'Sakramen Baptis Bayi';
    }
    return 'Tidak Ditentukan';
};

// Fungsi helper untuk badge status
const getStatusBadgeClass = (status) => {
    switch (status) {
        case 'verified':
        case 'lunas':
            return 'text-success'; 
        case 'confirm':
        case 'perlu_verifikasi':
            return 'text-warning';
        case 'pending':
            return 'text-secondary';
        default:
            return 'text-muted';
    }
};

// Fungsi helper untuk format status
const formatStatus = (status) => {
    switch (status) {
        case 'confirmed':
            return 'Terverifikasi';
        case 'confirm':
            return 'Menunggu Konfirmasi';
        case 'pending':
            return 'Tertunda';
        default:
            return status;
    }
};

// =================================================================
// === LOGIKA GANTI PASSWORD (TIDAK BERUBAH) =======================
// =================================================================

const form = reactive({
    password: '',
    password_confirmation: '',
});

const passwordFieldType = reactive({
    password: 'password',
    password_confirmation: 'password'
});

const isSubmitting = ref(false);

const togglePassword = (fieldType) => {
    if (fieldType in passwordFieldType) {
        passwordFieldType[fieldType] = passwordFieldType[fieldType] === 'password' ? 'text' : 'password';
    }
};

const submitPasswordChange = () => {
    if (isSubmitting.value) return;

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

    Inertia.put(
        `/user/data-profile/${props.user.id}/update-password`,
        {
            password: form.password,
            password_confirmation: form.password_confirmation,
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                isSubmitting.value = false;
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
    layout: LayoutWebsite,
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