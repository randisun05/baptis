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
                        <span v-if="user.status !== 'confirmed'" class="badge bg-warning text-dark">
                            <i class="fa fa-exclamation-circle me-1"></i> Menunggu Konfirmasi Data
                        </span>
                        <span v-else class="badge bg-success">
                            <i class="fa fa-check-circle me-1"></i> Akun Terverifikasi
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="user.status !== 'confirmed'" class="row justify-content-center fade-in">
            <div class="col-md-10">
                <div class="card border-0 shadow card-verification">
                    <div class="card-header bg-danger text-white fw-bold">
                        <i class="fa fa-user-check me-2"></i> Konfirmasi Data Diri
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info mb-4">
                            <i class="fa fa-info-circle me-2"></i>
                            Mohon periksa data di bawah ini. Pastikan semua data lengkap sesuai dengan grup pendaftaran Anda.
                        </div>

                        <h6 class="fw-bold text-primary mb-3"><i class="fa fa-user me-2"></i> Data Akun Utama</h6>
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
                            <h6 class="fw-bold text-primary mt-4 mb-3"><i class="fa fa-book me-2"></i> Data Katekumen, Riwayat & Menikah</h6>
                            
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
                                    <tr><td class="text-muted fw-bold" width="30%">Nama Guru</td><td>: {{ user.data_riwayat?.nameGuru || 'Belum diisi' }}</td></tr>
                                    <tr><td class="text-muted fw-bold">Tanggal Mulai</td><td>: {{ user.data_riwayat?.dateStart ? formatDate(user.data_riwayat.dateStart) : '-' }}</td></tr>
                                    <tr><td class="text-muted fw-bold">Tanggal Selesai</td><td>: {{ user.data_riwayat?.dateEnd ? formatDate(user.data_riwayat.dateEnd) : '-' }}</td></tr>
                                
                                </tbody>
                            </table>

                            <h6 class="text-secondary small fw-bold mt-3">Detail Menikah</h6>
                            <table class="table table-borderless table-sm mb-3">
                                <tbody>
                                    <tr><td class="text-muted fw-bold" width="30%">Status Menikah</td><td>: {{ user.data_menikah?.statusMarried || '-' }}</td></tr>
                                    <tr><td class="text-muted fw-bold">Nama Pasangan</td><td>: {{ user.data_menikah?.namePasangan || '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-else-if="user.group == 0">
                            <h6 class="fw-bold text-primary mt-4 mb-3"><i class="fa fa-hands-holding-child me-2"></i> Data Sakramen Baptis Bayi</h6>
                            
                            <h6 class="text-secondary small fw-bold mt-3">Detail Baptis</h6>
                            <table class="table table-borderless table-sm mb-3">
                                <tbody>
                                    <tr><td class="text-muted fw-bold" width="30%">Nama Wali Baptis</td><td>: {{ user.data_baptis?.nameWali || 'Belum diisi' }}</td></tr>
                                    <tr><td class="text-muted fw-bold">Nama Pastoor</td><td>: {{ user.data_baptis?.namePastoor || '-' }}</td></tr>
                                    <tr><td class="text-muted fw-bold">Status</td><td>: {{ user.data_baptis?.status || '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="fw-bold text-primary mt-4 mb-3"><i class="fa fa-users me-2"></i> Data Anggota Keluarga</h6>
                        <div v-if="user.data_keluarga && user.data_keluarga.length > 0">
                            <div v-for="(family, fIndex) in user.data_keluarga" :key="fIndex" class="card card-body bg-light mb-2 p-3">
                                <span class="fw-bold text-dark">{{ family.name }} ({{ family.relation }})</span>
                                <small class="text-muted">{{ family.address }} | Kontak: {{ family.contact }}</small>
                            </div>
                        </div>
                        <div v-else class="alert alert-warning small">Data keluarga belum diisi.</div>


                        <div class="d-grid gap-2 mt-4">
                            <button @click="verifyData" class="btn btn-primary btn-lg shadow fw-bold" :disabled="processing">
                                <span v-if="processing">
                                    <i class="fa fa-spinner fa-spin me-2"></i> Memproses...
                                </span>
                                <span v-else>
                                    <i class="fa fa-check-double me-2"></i> Data Sudah Benar, Lanjutkan
                                </span>
                            </button>

                             <button class="btn btn-danger btn-lg shadow fw-bold" :disabled="processing" disabled>
                                <span v-if="processing">
                                    <i class="fa fa-spinner fa-spin me-2"></i> Memproses...
                                </span>
                                <span v-else>
                                    <i class="fa fa-check-double me-2"></i> Jika Ada Perbaikan Data Hubungi Gereja
                                </span>
                            </button>
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
                                <p class="text-muted small mb-2"><i class="fa fa-map-marker-alt me-1"></i> {{ detail.event.place }}</p>

                                <div v-if="detail.event.body" class="mb-3 p-3 border-start border-3 bg-light">
                                    <p class="small text-dark fw-bold mb-1">Deskripsi Kegiatan:</p>
                                    <p class="small mb-0 text-secondary" v-html="truncateText(detail.event.body, 150)"></p>
                                </div>
                                
                               
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-5 text-muted">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty" width="100" class="mb-3 opacity-50">
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
import LayoutWebsite from '../../../Layouts/User.vue';
import Swal from 'sweetalert2';

// PROPS YANG DIREVISI
const props = defineProps({
    registrationData: Object, // Data Registrasi (nama baru dari 'data')
    events: Array,
    user: Object // Data User/Member utama dengan relasi (dataKatekumen, dataKeluarga, dll.)
});

const processing = ref(false);

// Helper: Format Tanggal
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Helper BARU: Memotong teks dan menghapus tag HTML
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

// Fungsi Verifikasi Data (Tidak ada perubahan)
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
export default { layout: LayoutWebsite }
</script>

<style scoped>
/* CSS dipertahankan */
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
.timeline-content { border-radius: 10px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
.timeline-content:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; }
@media (max-width: 768px) {
    .timeline-container { padding-left: 20px; }
    .timeline-container::before { left: 2px; }
    .timeline-marker { left: -23px; }
}
</style>