<template>
    <Head title="Dashboard Peserta" />

    <div class="container py-4 px-3 fade-in">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="welcome-card p-3 rounded shadow-sm bg-white d-flex align-items-center justify-content-between flex-wrap fade-in">
                    <div class="flex-grow-1 me-2 mb-2 mb-md-0">
                        <h4 class="fw-bold text-primary mb-1 welcome-title-mobile">Halo, {{ user.name }}!</h4>
                        <p class="text-muted mb-0 small welcome-text-mobile">Selamat datang di panel kegiatan.</p>
                        <p class="mb-0 small welcome-group-mobile">
                            Grup Pendaftaran: 
                            <span class="fw-bold text-dark">
                                {{ user.group == 1 ? 'Katekumen' : (user.group == 0 ? 'Sakramen Baptis Bayi' : 'Lainnya') }}
                            </span>
                        </p>
                    </div>
                    <div class="status-badge flex-shrink-0 mt-2 mt-md-0">
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
                    <div class="card-header bg-danger text-white fw-bold p-3">
                        Konfirmasi Data Diri
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="alert alert-info small mb-4">
                            Mohon periksa data di bawah ini. Pastikan semua data lengkap sesuai dengan grup pendaftaran Anda.
                        </div>

                        <h6 class="fw-bold text-primary mb-3">Data Akun Utama</h6>
                        <table class="table table-borderless table-sm mb-4 table-data-mobile">
                            <tbody>
                                <tr class="data-row-mobile">
                                    <td class="text-muted fw-bold data-header-mobile" width="35%">Nama Lengkap</td>
                                    <td class="data-content-mobile">: {{ user.name }}</td>
                                </tr>
                                <tr class="data-row-mobile">
                                    <td class="text-muted fw-bold data-header-mobile">Email</td>
                                    <td class="data-content-mobile">: {{ user.email }}</td>
                                </tr>
                                <tr class="data-row-mobile">
                                    <td class="text-muted fw-bold data-header-mobile">No. Telepon</td>
                                    <td class="data-content-mobile">: {{ user.contact || '-' }}</td>
                                </tr>
                                <tr class="data-row-mobile">
                                    <td class="text-muted fw-bold data-header-mobile">Jenis Kelamin</td>
                                    <td class="data-content-mobile">: {{ formatGender(user.gender) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <div v-if="user.group == 1">
                            <h6 class="fw-bold text-primary mt-4 mb-3">Data Katekumen, Riwayat & Menikah</h6>
                            
                            <h6 class="text-secondary small fw-bold mt-3 border-bottom pb-1">Detail Katekumen</h6>
                            <table class="table table-borderless table-sm mb-3 table-data-mobile">
                                <tbody>
                                    <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile" width="35%">Alamat</td><td class="data-content-mobile">: {{ user.data_katekumen?.address || 'Belum diisi' }}</td></tr>
                                    <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Pendidikan</td><td class="data-content-mobile">: {{ user.data_katekumen?.education || '-' }}</td></tr>
                                    <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Nama Penjamin</td><td class="data-content-mobile">: {{ user.data_katekumen?.namePenjamin || '-' }}</td></tr>
                                </tbody>
                            </table>

                            <h6 class="text-secondary small fw-bold mt-3 border-bottom pb-1">Detail Riwayat Agama</h6>
                            <table class="table table-borderless table-sm mb-3 table-data-mobile">
                                <tbody>
                                    <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile" width="35%">Agama Awal</td><td class="data-content-mobile">: {{ user.data_riwayat?.religion || '-' }}</td></tr>
                                    
                                    <template v-if="determineHistoryTypeLabel(user.data_riwayat) === 'I. Pelajaran Katolik'">
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Tempat / Hari</td><td class="data-content-mobile">: {{ user.data_riwayat?.location || '-' }} / {{ user.data_riwayat?.schedule || '-' }}</td></tr>
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Periode</td><td class="data-content-mobile">: {{ formatDateOnly(user.data_riwayat?.dateStart) }} s/d {{ formatDateOnly(user.data_riwayat?.dateEnd) }}</td></tr>
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Guru Pengajar</td><td class="data-content-mobile">: {{ user.data_riwayat?.nameGuru || '-' }}</td></tr>
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Pernah Ikut di</td><td class="data-content-mobile">: {{ user.data_riwayat?.participateBefore || '-' }}</td></tr>
                                    </template>

                                    <template v-else-if="determineHistoryTypeLabel(user.data_riwayat) === 'II. Baptis Kristen'">
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Gereja / Kota</td><td class="data-content-mobile">: {{ user.data_riwayat?.nameGereja || '-' }} / {{ user.data_riwayat?.addressGereja || '-' }}</td></tr>
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Dibaptis Oleh</td><td class="data-content-mobile">: {{ user.data_riwayat?.namePriest || '-' }}</td></tr>
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Tgl Baptis / No. Surat</td><td class="data-content-mobile">: {{ formatDateOnly(user.data_riwayat?.dateBaptis) }} / {{ user.data_riwayat?.numberBaptis || '-' }}</td></tr>
                                    </template>
                                </tbody>
                            </table>

                            <h6 class="text-secondary small fw-bold mt-3 border-bottom pb-1">Detail Pernikahan</h6>
                            <table class="table table-borderless table-sm mb-3 table-data-mobile">
                                <tbody>
                                    <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile" width="35%">Status Menikah</td><td class="data-content-mobile">: {{ user.data_menikah?.statusMarried || 'Belum diisi' }}</td></tr>
                                    
                                    <template v-if="user.data_menikah?.statusMarried === 'Pernah Menikah'">
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Mantan Pasangan</td><td class="data-content-mobile">: {{ user.data_menikah?.nameMantan || '-' }}</td></tr>
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Kota / Tahun</td><td class="data-content-mobile">: {{ user.data_menikah?.cityMantan || '-' }} / {{ user.data_menikah?.yearMantan || '-' }}</td></tr>
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Status Akhir</td><td class="data-content-mobile">: {{ user.data_menikah?.statusMantan || '-' }}</td></tr>
                                    </template>

                                    <template v-else-if="user.data_menikah?.statusMarried && user.data_menikah.statusMarried !== 'Belum Menikah'">
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Nama Pasangan</td><td class="data-content-mobile">: {{ user.data_menikah?.namePasangan || '-' }}</td></tr>
                                        
                                        <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Agama Pasangan</td><td class="data-content-mobile">: {{ user.data_menikah?.religionPasangan || '-' }}</td></tr>

                                        <template v-if="user.data_menikah?.statusMarried === 'Menikah Katolik'">
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Gereja / Kota</td><td class="data-content-mobile">: {{ user.data_menikah?.placeMarried1 || '-' }} / {{ user.data_menikah?.cityMarried1 || '-' }}</td></tr>
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Tanggal / Peneguh</td><td class="data-content-mobile">: {{ formatDateOnly(user.data_menikah?.dateMarried1) }} / {{ user.data_menikah?.namePeneguh1 || '-' }}</td></tr>
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">No. Surat</td><td class="data-content-mobile">: {{ user.data_menikah?.numberMarried1 || '-' }}</td></tr>
                                        </template>

                                        <template v-else-if="user.data_menikah?.statusMarried === 'Menikah Kristen'">
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Tempat / Kota</td><td class="data-content-mobile">: {{ user.data_menikah?.placeMarried2 || '-' }} / {{ user.data_menikah?.cityMarried2 || '-' }}</td></tr>
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Tanggal / Pendeta</td><td class="data-content-mobile">: {{ formatDateOnly(user.data_menikah?.dateMarried2) }} / {{ user.data_menikah?.namePeneguh2 || '-' }}</td></tr>
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">No. Surat</td><td class="data-content-mobile">: {{ user.data_menikah?.numberMarried2 || '-' }}</td></tr>
                                        </template>

                                        <template v-else-if="user.data_menikah?.statusMarried === 'Menikah Sipil'">
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Kota / Tanggal</td><td class="data-content-mobile">: {{ user.data_menikah?.cityMarried3 || '-' }} / {{ formatDateOnly(user.data_menikah?.dateMarried3) }}</td></tr>
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">No. Akta</td><td class="data-content-mobile">: {{ user.data_menikah?.numberMarried3 || '-' }}</td></tr>
                                        </template>

                                        <template v-else-if="user.data_menikah?.statusMarried === 'Menikah Lain'">
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Tempat / Kota</td><td class="data-content-mobile">: {{ user.data_menikah?.placeMarried4 || '-' }} / {{ user.data_menikah?.cityMarried4 || '-' }}</td></tr>
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Tanggal / Peneguh</td><td class="data-content-mobile">: {{ formatDateOnly(user.data_menikah?.dateMarried4) }} / {{ user.data_menikah?.namePeneguh4 || '-' }}</td></tr>
                                            <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">No. Surat</td><td class="data-content-mobile">: {{ user.data_menikah?.numberMarried4 || '-' }}</td></tr>
                                        </template>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <div v-else-if="user.group == 0">
                            <h6 class="fw-bold text-primary mt-4 mb-3">Data Sakramen Baptis Bayi</h6>
                            
                            <h6 class="text-secondary small fw-bold mt-3 border-bottom pb-1">Detail Baptis</h6>
                            <table class="table table-borderless table-sm mb-3 table-data-mobile">
                                <tbody>
                                    <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile" width="35%">Nama Wali Baptis</td><td class="data-content-mobile">: {{ user.data_baptis?.nameWali || 'Belum diisi' }}</td></tr>
                                    <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Nama Pastoor</td><td class="data-content-mobile">: {{ user.data_baptis?.namePastoor || '-' }}</td></tr>
                                    <tr class="data-row-mobile"><td class="text-muted fw-bold data-header-mobile">Status Wali Baptis</td><td class="data-content-mobile">: {{ user.data_baptis?.status || '-' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <h6 class="fw-bold text-primary mt-4 mb-3">Data Anggota Keluarga</h6>
                        <div v-if="user.data_keluarga && user.data_keluarga.length > 0">
                            <div v-for="(family, fIndex) in user.data_keluarga" :key="fIndex" class="card card-body bg-light mb-2 p-3 family-card-mobile border-0">
                                <span class="fw-bold text-dark family-name-mobile mb-1 d-block">{{ family.name }} ({{ family.relation }})</span>
                                <table class="table table-sm table-borderless small mb-0 p-0 w-100">
                                    <tr><td class="text-muted p-0" width="60px">Agama</td><td class="p-0">: {{ family.religion || '-' }}</td></tr>
                                    <tr><td class="text-muted p-0">Kontak</td><td class="p-0">: {{ family.contact || '-' }}</td></tr>
                                    <tr><td class="text-muted p-0">Alamat</td><td class="p-0">: {{ family.address || '-' }}</td></tr>
                                </table>
                            </div>
                        </div>
                        <div v-else class="alert alert-warning small">Data keluarga belum diisi.</div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button @click="verifyData" class="btn btn-primary btn-lg shadow fw-bold" :disabled="processing">
                                <span v-if="processing">Memproses...</span>
                                <span v-else>Data Sudah Benar, Lanjutkan</span>
                            </button>

                            <div class="btn btn-danger btn-lg shadow fw-bold mb-3 btn-danger-static" :class="{ 'opacity-50': processing }">
                                <span v-if="processing">Memproses...</span>
                                <span v-else>Jika Ada Perbaikan Data Hubungi Gereja</span>
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
                <h5 class="fw-bold mb-4 ps-2 border-start border-4 border-primary mobile-schedule-title">Jadwal Kegiatan Anda</h5>
                <div v-if="events.length > 0" class="timeline-container timeline-container-mobile">
                    <div v-for="(detail, index) in events" :key="detail.id" class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content card border-0 shadow-sm">
                            <div class="card-body p-3"> 
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-primary rounded-pill badge-mobile-small">{{ formatDate(detail.event.date) }}</span>
                                    <small class="text-muted status-mobile-small">Status: {{ detail.status }}</small>
                                </div>
                                <h5 class="fw-bold text-dark event-title-mobile">{{ detail.event.title }}</h5>
                                <p class="text-muted small mb-2 event-place-mobile">{{ detail.event.place }}</p>

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

// --- START: Helper Functions ---

const formatGender = (genderValue) => {
    if (genderValue === 1 || genderValue === 'Laki-laki') return 'Laki-laki';
    if (genderValue === 0 || genderValue === 'Perempuan') return 'Perempuan';
    return '-';
};

const determineHistoryTypeLabel = (dataRiwayat) => {
    if (!dataRiwayat) return 'Riwayat Lain';
    if (dataRiwayat.nameGereja || dataRiwayat.namePriest || dataRiwayat.dateBaptis || dataRiwayat.numberBaptis) return 'II. Baptis Kristen';
    if (dataRiwayat.location || dataRiwayat.schedule || dataRiwayat.dateStart || dataRiwayat.nameGuru || dataRiwayat.participateBefore) return 'I. Pelajaran Katolik';
    return 'Riwayat Lain';
};

const getStatusBadgeClass = (status) => {
    switch (status) {
        case 'verified': case 'lunas': case 'confirmed': return 'badge bg-success';
        case 'confirm': case 'perlu_verifikasi': return 'badge bg-warning text-dark';
        case 'pending': return 'badge bg-secondary';
        default: return 'badge bg-light text-muted';
    }
};

const formatStatus = (status) => {
    switch (status) {
        case 'verified': case 'confirmed': return 'Terverifikasi';
        case 'confirm': return 'Menunggu Konfirmasi';
        case 'pending': return 'Tertunda';
        case 'lunas': return 'Lunas';
        default: return status;
    }
};

const formatDateOnly = (dateString) => {
    if (!dateString) return '-';
    try {
        const datePart = dateString.substring(0, 10);
        const [year, month, day] = datePart.split('-');
        return `${day}-${month}-${year}`;
    } catch (e) { return '-'; }
};

const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};

const truncateText = (text, maxLength) => {
    if (!text) return '';
    let cleanText = text.replace(/<[^>]*>?/gm, '');
    if (cleanText.length > maxLength) return cleanText.substring(0, maxLength) + '...';
    return cleanText;
};

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
                onSuccess: () => Swal.fire('Berhasil', 'Data terverifikasi. Menampilkan jadwal...', 'success')
            });
        }
    });
};
// --- END: Helper Functions ---
</script>

<script>
import LayoutWebsite from '../../../Layouts/User.vue';
import { h } from 'vue'; 

export default { 
    layout: (h, page) => {
        const isConfirmed = page.props.user.status === 'confirmed';
        return h(LayoutWebsite, { showNavbar: isConfirmed }, [page]);
    }
}
</script>

<style scoped>
/* --- ANIMATION --- */
.fade-in { animation: fadeIn 0.8s ease-in-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* --- Base Styling --- */
.bg-primary { background-color: #0d6efd !important; }
.text-primary { color: #0d6efd !important; }
.bg-success { background-color: #198754 !important; }
.bg-warning { background-color: #ffc107 !important; }
.text-dark { color: #212529 !important; }
.bg-secondary { background-color: #6c757d !important; }
.bg-light { background-color: #f8f9fa !important; }

.card-verification { border-radius: 15px; overflow: hidden; }

/* Timeline Styling */
.timeline-container { position: relative; padding-left: 30px; margin-top: 20px; }
.timeline-container::before { content: ''; position: absolute; left: 7px; top: 0; bottom: 0; width: 2px; background: #e9ecef; }
.timeline-item { position: relative; margin-bottom: 30px; }
.timeline-marker {
    position: absolute; left: -28px; top: 15px; width: 16px; height: 16px; border-radius: 50%;
    background: #fff; border: 4px solid #0d6efd; z-index: 1; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.2);
}
.timeline-content { border-radius: 10px; transition: none; }

/* Static Danger Button */
.btn-danger-static {
    cursor: default !important; 
    background-color: #dc3545 !important; 
    border-color: #dc3545 !important;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important;
}
.opacity-50 { opacity: 0.65; }

/* --- Responsive Styling --- */
@media (max-width: 767.98px) {
    .container { padding-left: 10px !important; padding-right: 10px !important; }

    /* Welcome Card */
    .welcome-card { 
        flex-direction: column; 
        align-items: flex-start !important; 
        padding: 1rem !important;
    }
    .welcome-title-mobile { font-size: 1.25rem !important; }
    .welcome-text-mobile, .welcome-group-mobile { font-size: 0.8rem !important; }
    .status-badge { align-self: flex-end; }

    /* Card Data */
    .card-header, .card-body { padding: 1rem !important; }
    
    /* Table Data Mobile */
    .table-data-mobile tbody { display: block; width: 100%; }
    .table-data-mobile tr { 
        display: block; 
        border-bottom: 1px solid #eee; 
        padding-bottom: 5px; 
        margin-bottom: 5px; 
    }
    .table-data-mobile tr:last-child { border-bottom: none; }
    .table-data-mobile td { 
        display: block; 
        width: 100% !important; 
        padding: 2px 0 !important; 
    }
    .data-header-mobile { 
        font-size: 0.8rem !important; 
        margin-bottom: 0; 
        padding-bottom: 0 !important; 
    }
    .data-content-mobile { 
        font-size: 0.9rem !important; 
        font-weight: 500; 
        padding-top: 0 !important; 
        padding-left: 0.75rem !important;
    }

    /* Family Card */
    .family-card-mobile { padding: 0.75rem !important; }
    .family-name-mobile { font-size: 0.9rem; }
    
    /* Buttons */
    .d-grid button, .d-grid a, .d-grid .btn { width: 100% !important; font-size: 1rem !important; }

    /* Timeline */
    .mobile-schedule-title { font-size: 1.25rem !important; }
    .timeline-container-mobile { padding-left: 20px; }
    .timeline-container-mobile::before { left: 2px; }
    .timeline-marker { left: -23px; top: 18px; }
    .badge-mobile-small, .status-mobile-small { font-size: 0.75rem; }
    .event-title-mobile { font-size: 1rem; }
    .event-place-mobile { font-size: 0.75rem !important; }
}
</style>