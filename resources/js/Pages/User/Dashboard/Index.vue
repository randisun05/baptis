<template>
    <Head title="Dashboard Peserta" />

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="welcome-card p-4 rounded shadow-sm bg-white d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold text-primary mb-1">Halo, {{ user.name }}!</h4>
                        <p class="text-muted mb-0">Selamat datang di panel kegiatan.</p>
                        <p class="mb-0 small">
                            Grup Pendaftaran: 
                            <span class="fw-bold text-dark">
                                {{ user.group == 1 ? 'Katekumen' : (user.group == 0 ? 'Sakramen Baptis Bayi' : 'Lainnya') }}
                            </span>
                        </p>
                    </div>
                    <div class="status-badge">
                        <span :class="getStatusBadgeClass(user.status)">
                            {{ formatStatus(user.status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="user.status !== 'confirmed'" class="row justify-content-center fade-in">
            <div class="col-md-10">
                <div class="card border-0 shadow card-verification">
                    <div class="card-header bg-danger text-white fw-bold">
                        Konfirmasi Data Diri
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info mb-4">
                            Mohon periksa data di bawah ini. Pastikan semua data lengkap sesuai dengan grup pendaftaran Anda.
                        </div>

                        <h6 class="fw-bold text-primary mb-3">Data Akun Utama</h6>
                        <table class="table table-borderless table-sm mb-4">
                            <tbody>
                                <tr>
                                    <td class="text-muted fw-bold" width="30%">Nama Lengkap</td>
                                    <td>: {{ user.name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-bold">Email</td>
                                    <td>: {{ user.email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-bold">No. Telepon</td>
                                    <td>: {{ user.contact || '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div v-if="user.group == 1">
                            <h6 class="fw-bold text-primary mt-4 mb-3">Data Katekumen, Riwayat & Menikah</h6>
                            
                            <h6 class="text-secondary small fw-bold mt-3">Detail Katekumen</h6>
                            <table class="table table-borderless table-sm mb-3">
                                <tbody>
                                    <tr><td class="text-muted fw-bold" width="30%">Alamat</td><td>: {{ user.data_katekumen?.address || 'Belum diisi' }}</td></tr>
                                    <tr><td class="text-muted fw-bold">Pendidikan</td><td>: {{ user.data_katekumen?.education || '-' }}</td></tr>
                                    <tr><td class="text-muted fw-bold">Nama Penjamin</td><td>: {{ user.data_katekumen?.namePenjamin || '-' }}</td></tr>
                                </tbody>
                            </table>

                            <h6 class="text-secondary small fw-bold mt-3">Detail Riwayat</h6>
                            <table class="table table-borderless table-sm mb-3">
                                <tbody>
                                    <tr><td class="text-muted fw-bold" width="30%">Agama Awal</td><td>: {{ user.data_riwayat?.religion || '-' }}</td></tr>
                                    <template v-if="determineHistoryTypeLabel(user.data_riwayat) === 'I. Pelajaran Katolik'">
                                        <tr><td class="text-muted fw-bold">Tempat / Hari</td><td>: {{ user.data_riwayat?.location || '-' }} / {{ user.data_riwayat?.schedule || '-' }}</td></tr>
                                        <tr><td class="text-muted fw-bold">Mulai / Selesai</td><td>: {{ formatDateOnly(user.data_riwayat?.dateStart) }} / {{ formatDateOnly(user.data_riwayat?.dateEnd) }}</td></tr>
                                        <tr><td class="text-muted fw-bold">Guru Pengajar</td><td>: {{ user.data_riwayat?.nameGuru || '-' }}</td></tr>
                                        <tr><td class="text-muted fw-bold">Pernah Ikut di</td><td>: {{ user.data_riwayat?.participateBefore || '-' }}</td></tr>
                                    </template>
                                    <template v-else-if="determineHistoryTypeLabel(user.data_riwayat) === 'II. Baptis Kristen'">
                                        <tr><td class="text-muted fw-bold">Gereja / Alamat</td><td>: {{ user.data_riwayat?.nameGereja || '-' }} / {{ user.data_riwayat?.addressGereja || '-' }}</td></tr>
                                        <tr><td class="text-muted fw-bold">Dibaptis Oleh / Tgl</td><td>: {{ user.data_riwayat?.namePriest || '-' }} / {{ formatDateOnly(user.data_riwayat?.dateBaptis) }}</td></tr>
                                        <tr><td class="text-muted fw-bold">No. Surat Baptis</td><td>: {{ user.data_riwayat?.numberBaptis || '-' }}</td></tr>
                                    </template>
                                    <tr v-else><td colspan="2" class="text-muted fst-italic">Riwayat lainnya belum diisi.</td></tr>
                                </tbody>
                            </table>

                            <h6 class="text-secondary small fw-bold mt-3">Detail Menikah</h6>
                            <table class="table table-borderless table-sm mb-3">
                                <tbody>
                                    <tr><td class="text-muted fw-bold" width="30%">Status Menikah</td><td>: {{ user.data_menikah?.statusMarried || 'Belum diisi' }}</td></tr>
                                    <tr v-if="user.data_menikah?.statusMarried && user.data_menikah.statusMarried !== 'Belum Menikah' && user.data_menikah.statusMarried !== 'Pernah Menikah'">
                                        <td class="text-muted fw-bold">Nama Pasangan</td><td>: {{ user.data_menikah?.namePasangan || '-' }}</td>
                                    </tr>
                                    <tr v-if="user.data_menikah?.statusMarried && user.data_menikah.statusMarried !== 'Menikah Sipil' && user.data_menikah.statusMarried !== 'Belum Menikah' && user.data_menikah.statusMarried !== 'Pernah Menikah'">
                                        <td class="text-muted fw-bold">Agama Pasangan</td><td>: {{ user.data_menikah?.religionPasangan || '-' }}</td>
                                    </tr>
                                    
                                    <tr v-if="user.data_menikah?.statusMarried === 'Menikah Katolik'">
                                        <td class="text-muted fw-bold">Gereja / Tanggal</td><td>: {{ user.data_menikah?.placeMarried1 || '-' }} ({{ formatDateOnly(user.data_menikah?.dateMarried1) }})</td>
                                    </tr>
                                    <tr v-if="user.data_menikah?.statusMarried === 'Menikah Kristen'">
                                        <td class="text-muted fw-bold">Tempat / Tanggal</td><td>: {{ user.data_menikah?.placeMarried2 || '-' }} ({{ formatDateOnly(user.data_menikah?.dateMarried2) }})</td>
                                    </tr>
                                    <tr v-if="user.data_menikah?.statusMarried === 'Menikah Sipil'">
                                        <td class="text-muted fw-bold">Kota / Tanggal</td><td>: {{ user.data_menikah?.cityMarried3 || '-' }} ({{ formatDateOnly(user.data_menikah?.dateMarried3) }})</td>
                                    </tr>
                                     <tr v-if="user.data_menikah?.statusMarried === 'Menikah Lain'">
                                        <td class="text-muted fw-bold">Tempat / Tanggal</td><td>: {{ user.data_menikah?.placeMarried4 || '-' }} ({{ formatDateOnly(user.data_menikah?.dateMarried4) }})</td>
                                    </tr>
                                    <tr v-if="user.data_menikah?.statusMarried === 'Pernah Menikah'">
                                        <td class="text-muted fw-bold">Mantan Pasangan</td><td>: {{ user.data_menikah?.nameMantan || '-' }}</td>
                                    </tr>
                                    <tr v-if="user.data_menikah?.statusMarried === 'Pernikahan Sipil' || user.data_menikah?.statusMarried === 'Pernah Menikah'">
                                        <td class="text-muted fw-bold">Status Berakhir</td><td>: {{ user.data_menikah?.statusMantan || '-' }} (Tahun: {{ user.data_menikah?.yearMantan || '-' }})</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-else-if="user.group == 0">
                            <h6 class="fw-bold text-primary mt-4 mb-3">Data Sakramen Baptis Bayi</h6>
                            
                            <h6 class="text-secondary small fw-bold mt-3">Detail Baptis</h6>
                            <table class="table table-borderless table-sm mb-3">
                                <tbody>
                                    <tr><td class="text-muted fw-bold" width="30%">Nama Wali Baptis</td><td>: {{ user.data_baptis?.nameWali || 'Belum diisi' }}</td></tr>
                                    <tr><td class="text-muted fw-bold">Nama Pastoor</td><td>: {{ user.data_baptis?.namePastoor || '-' }}</td></tr>
                                    <tr><td class="text-muted fw-bold">Status Wali Baptis</td><td>: {{ user.data_baptis?.status || '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="fw-bold text-primary mt-4 mb-3">Data Anggota Keluarga</h6>
                        <div v-if="user.data_keluarga && user.data_keluarga.length > 0">
                            <div v-for="(family, fIndex) in user.data_keluarga" :key="fIndex" class="card card-body bg-light mb-2 p-3">
                                <span class="fw-bold text-dark">{{ family.name }} ({{ family.relation }})</span>
                                <small class="text-muted">{{ family.address || 'Alamat tidak diisi' }} | Kontak: {{ family.contact || '-' }} | Agama: {{ family.religion || '-' }}</small>
                            </div>
                        </div>
                        <div v-else class="alert alert-warning small">Data keluarga belum diisi.</div>


                        <div class="d-grid gap-2 mt-4">
                            <button @click="verifyData" class="btn btn-primary btn-lg shadow fw-bold" :disabled="processing">
                                <span v-if="processing">
                                    Memproses...
                                </span>
                                <span v-else>
                                    Data Sudah Benar, Lanjutkan
                                </span>
                            </button>

                            <div 
                                class="btn btn-danger btn-lg shadow fw-bold mb-3 btn-danger-static" 
                                :class="{ 'opacity-50': processing }"
                            >
                                <span v-if="processing">
                                    Memproses...
                                </span>
                                <span v-else>
                                    Jika Ada Perbaikan Data Hubungi Gereja
                                </span>
                            </div>
                            
                            <Link :href="'/logout'" method="post" as="button" class="btn btn-outline-secondary btn-lg shadow fw-bold">
                                Logout
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="row fade-in">
            <div class="col-md-12">
                <h5 class="fw-bold mb-4 ps-2 border-start border-4 border-primary">Jadwal Kegiatan Anda</h5>
                <div v-if="events.length > 0" class="timeline-container">
                    <div v-for="(detail, index) in events" :key="detail.id" class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-primary rounded-pill">{{ formatDate(detail.event.date) }}</span>
                                    <small class="text-muted">Status: {{ detail.status }}</small>
                                </div>
                                <h5 class="fw-bold text-dark">{{ detail.event.title }}</h5>
                                <p class="text-muted small mb-2">{{ detail.event.place }}</p>

                                <div v-if="detail.event.body" class="mb-3 p-3 border-start border-3 bg-light">
                                    <p class="small text-dark fw-bold mb-1">Deskripsi Kegiatan:</p>
                                    <p class="small mb-0 text-secondary" v-html="truncateText(detail.event.body, 150)"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-5 text-muted">
                    <p>Anda belum terdaftar di kegiatan manapun.</p>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';

const props = defineProps({
    registrationData: Object,
    events: Array,
    user: Object
});

const processing = ref(false);

// --- START: Helper Functions dari Kode Admin View ---

// Fungsi untuk menentukan tipe riwayat (sesuai logika Edit.vue di kode Admin)
const determineHistoryTypeLabel = (dataRiwayat) => {
    if (!dataRiwayat) return 'Riwayat Lain';
    // Cek Riwayat Pelajaran Katolik (I)
    if (dataRiwayat.location || dataRiwayat.schedule || dataRiwayat.dateStart || dataRiwayat.nameGuru || dataRiwayat.participateBefore) {
        return 'I. Pelajaran Katolik';
    }
    // Cek Riwayat Baptis Kristen (II)
    if (dataRiwayat.nameGereja || dataRiwayat.namePriest || dataRiwayat.dateBaptis || dataRiwayat.numberBaptis) {
        return 'II. Baptis Kristen';
    }
    return 'Riwayat Lain';
};

// Fungsi helper untuk badge status (Disalin dari kode Admin)
const getStatusBadgeClass = (status) => {
    switch (status) {
        case 'verified':
        case 'lunas': 
        case 'confirmed': 
            return 'badge bg-success';
        case 'confirm':
        case 'perlu_verifikasi':
            return 'badge bg-warning text-dark';
        case 'pending':
            return 'badge bg-secondary';
        default:
            return 'badge bg-light text-muted';
    }
};

// Fungsi helper untuk format status (Disalin dari kode Admin)
const formatStatus = (status) => {
    switch (status) {
        case 'verified':
        case 'confirmed': 
            return 'Terverifikasi';
        case 'confirm':
            return 'Menunggu Konfirmasi';
        case 'pending':
            return 'Tertunda';
        case 'lunas':
            return 'Lunas';
        default:
            return status;
    }
};

// Helper: Format Tanggal Pendek (untuk Data Riwayat/Menikah) - Disesuaikan agar outputnya DD-MM-YYYY
const formatDateOnly = (dateString) => {
    if (!dateString) return '-';
    try {
        // Ambil hanya bagian tanggal YYYY-MM-DD
        const datePart = dateString.substring(0, 10);
        // Ubah menjadi format DD-MM-YYYY
        const [year, month, day] = datePart.split('-');
        return `${day}-${month}-${year}`;
    } catch (e) {
        return '-';
    }
};
// --- END: Helper Functions dari Kode Admin View ---

// Helper: Format Tanggal Lengkap (untuk Jadwal Kegiatan)
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Helper: Memotong teks dan menghapus tag HTML
const truncateText = (text, maxLength) => {
    if (!text) return '';
    // 1. Hapus tag HTML
    let cleanText = text.replace(/<[^>]*>?/gm, '');
    
    // 2. Potong teks jika melebihi maxLength
    if (cleanText.length > maxLength) {
        return cleanText.substring(0, maxLength) + '...';
    }
    return cleanText;
};

// Fungsi Verifikasi Data
const verifyData = () => {
    Swal.fire({
        title: 'Konfirmasi Data?',
        text: "Pastikan data Anda sudah benar sebelum melanjutkan.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Benar!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.post('/user/dashboard/verify', {}, {
                onStart: () => processing.value = true,
                onFinish: () => processing.value = false,
                onSuccess: () => {
                    Swal.fire('Berhasil', 'Data terverifikasi. Menampilkan jadwal...', 'success');
                }
            });
        }
    });
};
</script>

<script>
import LayoutWebsite from '../../../Layouts/User.vue';
import { h } from 'vue'; 

export default { 
    layout: (h, page) => {
        // Pastikan pengecekan status di sini menggunakan user.status
        const isConfirmed = page.props.user.status === 'confirmed';
        
        return h(LayoutWebsite, { 
            showNavbar: isConfirmed 
        }, [page]);
    }
}
</script>

<style scoped>
/* (CSS ASLI DIPERTAHANKAN) */
.fade-in { animation: fadeIn 0.8s ease-in-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.card-verification { border-radius: 15px; overflow: hidden; }

.timeline-container { position: relative; padding-left: 30px; margin-top: 20px; }
.timeline-container::before { content: ''; position: absolute; left: 7px; top: 0; bottom: 0; width: 2px; background: #e9ecef; }
.timeline-item { position: relative; margin-bottom: 30px; }
.timeline-marker {
    position: absolute; left: -28px; top: 15px; width: 16px; height: 16px; border-radius: 50%;
    background: #fff; border: 4px solid #0d6efd; z-index: 1; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.2);
}
.timeline-content { border-radius: 10px; transition: none; }

@media (max-width: 768px) {
    .timeline-container { padding-left: 20px; }
    .timeline-container::before { left: 2px; }
    .timeline-marker { left: -23px; }
}

/* Tambahkan gaya badge yang digunakan di kode Admin jika belum ada */
.bg-success { background-color: #198754 !important; }
.bg-warning { background-color: #ffc107 !important; }
.text-dark { color: #212529 !important; }
.bg-secondary { background-color: #6c757d !important; }
.bg-light { background-color: #f8f9fa !important; }

/* Tambahan untuk menonaktifkan hover pada tombol info/perbaikan */
.btn-danger-static {
    /* Mencegah kursor klik */
    cursor: default !important; 
    /* Menghilangkan efek hover/active dari Bootstrap */
    background-color: #dc3545 !important; /* Warna dasar danger */
    border-color: #dc3545 !important;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important; /* Mempertahankan shadow */
}

/* Mengunci warna background dan shadow untuk state hover, focus, dan active */
.btn-danger-static:hover,
.btn-danger-static:focus,
.btn-danger-static:active {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
    /* Tambahkan !important untuk memastikan override gaya Bootstrap */
}

/* Menambahkan kembali kelas Bootstrap opacity-50 untuk kondisi processing (disabled look) */
.opacity-50 { opacity: 0.65; }
</style>