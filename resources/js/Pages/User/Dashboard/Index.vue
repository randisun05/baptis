<template>
    <Head title="Dashboard Peserta" />

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="welcome-card p-4 rounded shadow-sm bg-white d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold text-primary mb-1">Halo, {{ user.name }}!</h4>
                        <p class="text-muted mb-0">Selamat datang di panel kegiatan.</p>
                    </div>
                    <div class="status-badge">
                        <span v-if="user.status === 'confirm'" class="badge bg-warning text-dark">
                            <i class="fa fa-exclamation-circle me-1"></i> Menunggu Konfirmasi
                        </span>
                        <span v-else class="badge bg-success">
                            <i class="fa fa-check-circle me-1"></i> Akun Terverifikasi
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="user.status === 'confirm'" class="row justify-content-center fade-in">
            <div class="col-md-8">
                <div class="card border-0 shadow card-verification">
                    <div class="card-header bg-danger text-white fw-bold">
                        <i class="fa fa-user-check me-2"></i> Konfirmasi Data Diri
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info mb-4">
                            <i class="fa fa-info-circle me-2"></i>
                            Mohon periksa data di bawah ini. Jika sudah benar, silakan klik tombol konfirmasi untuk melihat jadwal kegiatan.
                        </div>

                        <table class="table table-borderless table-hover">
                            <tbody>
                                <tr>
                                    <td class="text-muted fw-bold" width="35%">Nama Lengkap</td>
                                    <td>: {{ user.name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-bold">Email</td>
                                    <td>: {{ user.email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-bold">Instansi</td>
                                    <td>: {{ user.agency || '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-bold">Jabatan</td>
                                    <td>: {{ data?.jabatan || '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted fw-bold">No. Telepon</td>
                                    <td>: {{ user.phone || '-' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-grid gap-2 mt-4">
                            <button @click="verifyData" class="btn btn-primary btn-lg shadow fw-bold" :disabled="processing">
                                <span v-if="processing">
                                    <i class="fa fa-spinner fa-spin me-2"></i> Memproses...
                                </span>
                                <span v-else>
                                    <i class="fa fa-check-double me-2"></i> Data Sudah Benar, Lanjutkan
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

                                <Link :href="`/user/events/${detail.event.id}`" class="btn btn-sm btn-outline-primary mt-2">
                                    Detail Kegiatan <i class="fa fa-arrow-right ms-1"></i>
                                </Link>
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
import LayoutWebsite from '../../../Layouts/Website.vue';
import Swal from 'sweetalert2';

// Props dari controller
const props = defineProps({
    data: Object, // Data Registrasi (misalnya untuk detail jabatan)
    events: Array,
    user: Object // Data User/Member utama (sudah berisi status)
});

const processing = ref(false);

// Format Tanggal
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Truncate Text
const truncate = (text, length) => {
    if(!text) return '';
    return text.length > length ? text.substring(0, length) + '...' : text;
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
            // Perlu diperhatikan: Backend harus mengupdate status di tabel members
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
/* Custom CSS dari respons sebelumnya */
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
