<template>
    <Head>
        <title>Profile Peserta</title>
    </Head>

    <section id="profile" class="container padding py-4">
        <div class="container-fluid px-5">

            <div class="row d-flex justify-content-center">
                
                <div class="col-md-10 col-lg-10">
                    
                    <!-- === Tombol Kembali & Edit === -->
                    <div class="row mb-4">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <Link href="/admin/registration" class="btn btn-sm btn-outline-navy shadow-sm">
                                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Registrasi
                            </Link>
                            <Link :href="`/admin/registration/${form.id}/edit`" class="btn btn-sm btn-navy shadow-sm">
                                <i class="bi bi-pencil-square me-2"></i> Edit Data Peserta
                            </Link>
                        </div>
                    </div>

                    <!-- CARD 1: Data Profil Utama -->
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="mb-0"><i class="fa fa-user me-2"></i> Detail Profil Peserta</h4>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-primary">{{ form.name }}</h5>
                            
                            <table class="table table-borderless table-detail">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-muted" width="30%">Nama Lengkap</td>
                                        <td width="5%">:</td>
                                        <td>{{ form.name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Nomor Registrasi</td>
                                        <td>:</td>
                                        <td>{{ form.number || '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Jenis Kelamin</td>
                                        <td>:</td>
                                        <td>{{ form.gender || '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Email</td>
                                        <td>:</td>
                                        <td>{{ form.email || '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">No. Telepon</td>
                                        <td>:</td>
                                        <td>{{ form.contact || '-' }}</td>
                                    </tr>
                                    
                                    <!-- Kelompok Katekese -->
                                    <tr>
                                        <td class="fw-bold text-muted">Kelompok Katekese</td>
                                        <td>:</td>
                                        <td>
                                            <span v-if="getGroupName(form.group)" 
                                                :class="getGroupBadgeClass(form.group)">
                                                <i class="bi bi-people-fill me-1"></i> {{ getGroupName(form.group) }}
                                            </span>
                                            <span v-else class="text-muted fst-italic">
                                                Tidak Ditentukan
                                            </span>
                                        </td>
                                    </tr>
                                    
                                    <!-- Status Akun -->
                                    <tr>
                                        <td class="fw-bold text-muted">Status Akun</td>
                                        <td>:</td>
                                        <td>
                                            <span :class="getStatusBadgeClass(form.status)">
                                                {{ formatStatus(form.status) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- CARD 2: DATA KONDISIONAL BERDASARKAN KELOMPOK -->
                    <div class="card shadow-lg border-0 mt-4 mb-4" v-if="getGroupName(form.group)">
                        <div class="card-header" :class="getGroupHeaderClass(form.group)">
                            <h5 class="mb-0"><i class="fa fa-book me-2"></i> Detail Kelompok: {{ getGroupName(form.group) }}</h5>
                        </div>
                        
                        <div class="card-body p-4">
                            
                            <!-- DATA KATEKUMEN (JIKA KATEKUMEN) -->
                            <div v-if="getGroupName(form.group) === 'Katekumen' && form.katekumen.id">
                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">2a. Data Tambahan Katekumen</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Alamat Lengkap</td><td width="5%">:</td><td>{{ form.katekumen.address || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Pendidikan Terakhir</td><td>:</td><td>{{ form.katekumen.education || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Nama Penjamin</td><td>:</td><td>{{ form.katekumen.namePenjamin || '-' }}</td></tr>
                                </table>

                                <!-- RIWAYAT AGAMA -->
                                <div v-if="form.riwayat.id">
                                    <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">2b. Riwayat Agama & Kegiatan</h6>
                                    
                                    <h6 class="fw-bold text-secondary mt-3 mb-2 small">Riwayat {{ determineHistoryTypeLabel(form.riwayat) }}</h6>
                                    
                                    <table class="table table-borderless table-sm table-detail">
                                        <!-- Field Umum Riwayat -->
                                        <tr><td class="fw-bold text-muted" width="30%">Agama Awal</td><td width="5%">:</td><td>{{ form.riwayat.religion || '-' }}</td></tr>
                                        <template v-if="determineHistoryTypeLabel(form.riwayat) === 'Pelajaran Katolik'">
                                            <tr><td class="fw-bold text-muted">Tempat / Hari</td><td>:</td><td>{{ form.riwayat.location || '-' }} / {{ form.riwayat.schedule || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Mulai / Selesai</td><td>:</td><td>{{ formatDate(form.riwayat.dateStart) || '-' }} / {{ formatDate(form.riwayat.dateEnd) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Guru Pengajar</td><td>:</td><td>{{ form.riwayat.nameGuru || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Pernah Ikut di</td><td>:</td><td>{{ form.riwayat.participateBefore || '-' }}</td></tr>
                                        </template>
                                        <template v-else-if="determineHistoryTypeLabel(form.riwayat) === 'Baptis Kristen'">
                                            <tr><td class="fw-bold text-muted">Gereja / Alamat</td><td>:</td><td>{{ form.riwayat.nameGereja || '-' }} / {{ form.riwayat.addressGereja || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Dibaptis Oleh / Tgl</td><td>:</td><td>{{ form.riwayat.namePriest || '-' }} / {{ formatDate(form.riwayat.dateBaptis) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">No. Surat Baptis</td><td>:</td><td>{{ form.riwayat.numberBaptis || '-' }}</td></tr>
                                        </template>
                                    </table>
                                </div>
                                <div v-else class="text-muted fst-italic small">Riwayat Agama belum diisi.</div>

                                <!-- STATUS PERNIKAHAN -->
                                <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">2c. Status Pernikahan</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Status Pernikahan</td><td width="5%">:</td><td>{{ form.menikah.statusMarried || '-' }}</td></tr>
                                </table>

                                <!-- DETAIL PERNIKAHAN (KONDISIONAL) -->
                                <div v-if="form.menikah.statusMarried && form.menikah.statusMarried !== 'Belum Menikah' && form.menikah.statusMarried !== 'Pernah Menikah'" class="p-3 border rounded bg-light-subtle mt-3">
                                    <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Data Pasangan</h6>
                                    <table class="table table-borderless table-sm table-detail">
                                        <tr><td class="fw-bold text-muted" width="30%">Nama Pasangan</td><td width="5%">:</td><td>{{ form.menikah.namePasangan || '-' }}</td></tr>
                                        <tr v-if="form.menikah.statusMarried !== 'Menikah Sipil'"><td class="fw-bold text-muted">Agama Pasangan</td><td>:</td><td>{{ form.menikah.religionPasangan || '-' }}</td></tr>
                                    </table>

                                    <!-- Detail Katolik (1) -->
                                    <div v-if="form.menikah.statusMarried === 'Menikah Katolik' && form.menikah.placeMarried1">
                                        <h6 class="fw-bold text-secondary mt-3 mb-2 small border-top pt-2">Detail Pernikahan Katolik</h6>
                                        <table class="table table-borderless table-sm table-detail">
                                            <tr><td class="fw-bold text-muted" width="30%">Gereja / Kota</td><td>:</td><td>{{ form.menikah.placeMarried1 || '-' }} / {{ form.menikah.cityMarried1 || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Tanggal Nikah</td><td>:</td><td>{{ formatDate(form.menikah.dateMarried1) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Peneguh / No. Surat</td><td>:</td><td>{{ form.menikah.namePeneguh1 || '-' }} / {{ form.menikah.numberMarried1 || '-' }}</td></tr>
                                        </table>
                                    </div>

                                    <!-- Detail Kristen (2) -->
                                    <div v-else-if="form.menikah.statusMarried === 'Menikah Kristen' && form.menikah.placeMarried2">
                                        <h6 class="fw-bold text-secondary mt-3 mb-2 small border-top pt-2">Detail Pernikahan Kristen</h6>
                                        <table class="table table-borderless table-sm table-detail">
                                            <tr><td class="fw-bold text-muted" width="30%">Tempat / Kota</td><td>:</td><td>{{ form.menikah.placeMarried2 || '-' }} / {{ form.menikah.cityMarried2 || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Tanggal Nikah</td><td>:</td><td>{{ formatDate(form.menikah.dateMarried2) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Pendeta / No. Surat</td><td>:</td><td>{{ form.menikah.namePeneguh2 || '-' }} / {{ form.menikah.numberMarried2 || '-' }}</td></tr>
                                        </table>
                                    </div>

                                    <!-- Detail Sipil (3) -->
                                    <div v-else-if="form.menikah.statusMarried === 'Menikah Sipil' && form.menikah.cityMarried3">
                                        <h6 class="fw-bold text-secondary mt-3 mb-2 small border-top pt-2">Detail Pernikahan Sipil</h6>
                                        <table class="table table-borderless table-sm table-detail">
                                            <tr><td class="fw-bold text-muted" width="30%">Kota</td><td>:</td><td>{{ form.menikah.cityMarried3 || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Tanggal Nikah</td><td>:</td><td>{{ formatDate(form.menikah.dateMarried3) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">No. Surat</td><td>:</td><td>{{ form.menikah.numberMarried3 || '-' }}</td></tr>
                                        </table>
                                    </div>

                                    <!-- Detail Lain (4) -->
                                    <div v-else-if="form.menikah.statusMarried === 'Menikah Lain' && form.menikah.placeMarried4">
                                        <h6 class="fw-bold text-secondary mt-3 mb-2 small border-top pt-2">Detail Pernikahan Lain</h6>
                                        <table class="table table-borderless table-sm table-detail">
                                            <tr><td class="fw-bold text-muted" width="30%">Tempat / Kota</td><td>:</td><td>{{ form.menikah.placeMarried4 || '-' }} / {{ form.menikah.cityMarried4 || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Tanggal Nikah</td><td>:</td><td>{{ formatDate(form.menikah.dateMarried4) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Peneguh / No. Surat</td><td>:</td><td>{{ form.menikah.namePeneguh4 || '-' }} / {{ form.menikah.numberMarried4 || '-' }}</td></tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- DETAIL PERNAH MENIKAH -->
                                <div v-else-if="form.menikah.statusMarried === 'Pernah Menikah' && form.menikah.nameMantan" class="p-3 border rounded bg-light-subtle mt-3">
                                    <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Detail Pernah Menikah (Janda/Duda)</h6>
                                    <table class="table table-borderless table-sm table-detail">
                                        <tr><td class="fw-bold text-muted" width="30%">Pernah Menikah Dengan</td><td width="5%">:</td><td>{{ form.menikah.nameMantan || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Kota Pernikahan</td><td>:</td><td>{{ form.menikah.cityMantan || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Status Berakhir</td><td>:</td><td>{{ form.menikah.statusMantan || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Tahun Berakhir</td><td>:</td><td>{{ form.menikah.yearMantan || '-' }}</td></tr>
                                    </table>
                                </div>
                                <div v-else-if="form.menikah.statusMarried !== 'Belum Menikah'" class="text-muted fst-italic small mt-3">Detail pernikahan belum diisi.</div>


                            </div>

                            <!-- DATA BAPTIS BAYI (JIKA SAKRAMEN BAPTIS BAYI) -->
                            <div v-else-if="getGroupName(form.group) === 'Sakramen Baptis Bayi' && form.baptis.id">
                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">2. Data Sakramen Baptis Bayi</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Nama Wali Baptis</td><td width="5%">:</td><td>{{ form.baptis.nameWali || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted" width="30%">Status Wali Baptis</td><td width="5%">:</td><td>{{ form.baptis.status || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Nama Pastoor</td><td>:</td><td>{{ form.baptis.namePastoor || '-' }}</td></tr>
                                </table>
                            </div>
                            
                            <div v-else class="text-muted fst-italic text-center">
                                <p class="mb-0">Tidak ada data detail kelompok untuk peserta ini.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CARD 3: Data Keluarga -->
                    <div class="card shadow-lg border-0 mt-4 mb-4">
                        <div class="card-header bg-secondary text-white py-3">
                            <h5 class="mb-0"><i class="fa fa-users me-2"></i> 3. Data Anggota Keluarga</h5>
                        </div>
                        <div class="card-body p-4">
                            <div v-if="form.keluarga.length === 0" class="text-muted text-center">
                                <p>Tidak ada data anggota keluarga terkait.</p>
                            </div>
                            <div v-else>
                                <div v-for="(member, index) in form.keluarga" :key="index" class="p-3 border rounded mb-3 bg-light">
                                    <h6 class="fw-bold mb-2 text-dark">Anggota Keluarga #{{ index + 1 }} ({{ member.relation || 'Hubungan Tidak Diketahui' }})</h6>
                                    <table class="table table-sm table-borderless small">
                                        <tr><td class="fw-bold text-muted" width="30%">Nama</td><td>:</td><td>{{ member.name || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Agama</td><td>:</td><td>{{ member.religion || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Kontak</td><td>:</td><td>{{ member.contact || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Alamat</td><td>:</td><td>{{ member.address || '-' }}</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
import { Head, Link } from "@inertiajs/inertia-vue3";
import { reactive } from "vue";
import Swal from "sweetalert2";

export default {
    layout: LayoutAdmin,

    components: {
        Head,
        Link,
    },

    props: {
        errors: Object,
        session: Object,
        data: Object, // Prop yang membawa data peserta dan relasinya
    },

    setup(props) {
        // Helper untuk format data tanggal (YYYY-MM-DD)
        const formatDate = (dateString) => {
            if (!dateString) return null;
            try {
                // Mencoba mem-format ulang string tanggal jika diperlukan (misalnya dari timestamp penuh)
                if (dateString.length > 10) {
                    return new Date(dateString).toISOString().slice(0, 10);
                }
                return dateString;
            } catch (e) {
                return dateString; // Kembalikan string asli jika gagal
            }
        };

        // Fungsi untuk menentukan tipe riwayat (sesuai logika Edit.vue)
        const determineHistoryTypeLabel = (dataRiwayat) => {
            if (!dataRiwayat || !dataRiwayat.id) return 'Tidak Ada Riwayat';
            
            // Asumsi: Jika field khusus pelajaran Katolik terisi
            if (dataRiwayat.location || dataRiwayat.schedule || dataRiwayat.dateStart || dataRiwayat.nameGuru) {
                return 'Pelajaran Katolik';
            }
            // Asumsi: Jika field khusus baptis Kristen terisi
            if (dataRiwayat.nameGereja || dataRiwayat.namePriest || dataRiwayat.dateBaptis || dataRiwayat.numberBaptis) {
                return 'Baptis Kristen';
            }
            return 'Riwayat Lain';
        };

        // Define form state using data from props.data
        const form = reactive({
            // Data Utama (Member/Registration)
            id: props.data.id || null, // Tambahkan ID untuk link edit
            name: props.data.name || '-',
            email: props.data.email || '-',
            contact: props.data.contact || '-',
            gender: props.data.gender || '-',
            number: props.data.number || '-',
            status: props.data.status || 'pending',
            group: props.data.group || null, // Kelompok Katekese (string)
            
            // Nested Data (Menggunakan optional chaining dan null/empty object default)
            katekumen: props.data.data_katekumen || {},
            riwayat: props.data.data_riwayat || {},
            menikah: props.data.data_menikah || {},
            baptis: props.data.data_baptis || {},
            keluarga: props.data.family_members || [], // Sesuaikan nama prop untuk konsistensi dengan Edit.vue
        });

        // =================================================================
        // === FUNGSI HELPER KELOMPOK KATEKESE (Disalin dari Edit/Create) ==
        // =================================================================
        const getGroupName = (groupValue) => {
             // Menangani nilai string sesuai yang dikirim dari form/DB (Katekumen/Sakramen Baptis Bayi)
             if (groupValue === 'Katekumen' || groupValue === 'KATEKUMEN') {
                 return 'Katekumen';
             } else if (groupValue === 'Sakramen Baptis Bayi' || groupValue === 'SAKRAMEN BAPTIS BAYI') {
                 return 'Sakramen Baptis Bayi';
             }
             return null;
        };

        const getGroupBadgeClass = (groupValue) => {
             if (groupValue === 'Katekumen' || groupValue === 'KATEKUMEN') {
                 return 'badge bg-info-subtle text-info-emphasis border border-info-subtle fw-normal px-3 py-2';
             } else if (groupValue === 'Sakramen Baptis Bayi' || groupValue === 'SAKRAMEN BAPTIS BAYI') {
                 return 'badge bg-primary-subtle text-primary-emphasis border border-primary-subtle fw-normal px-3 py-2';
             }
             return 'badge bg-light text-muted border border-secondary-subtle fw-normal px-3 py-2';
        };

        const getGroupHeaderClass = (groupValue) => {
             if (groupValue === 'Katekumen' || groupValue === 'KATEKUMEN') {
                 return 'bg-info text-white';
             } else if (groupValue === 'Sakramen Baptis Bayi' || groupValue === 'SAKRAMEN BAPTIS BAYI') {
                 return 'bg-primary text-white';
             }
             return 'bg-secondary text-white';
        };
        // =================================================================
        
        // Fungsi helper untuk badge status
        const getStatusBadgeClass = (status) => {
            switch (status) {
                case 'verified':
                case 'lunas': // Tambahkan status lunas jika ada di DB
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

        // Fungsi helper untuk format status
        const formatStatus = (status) => {
            switch (status) {
                case 'verified':
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

        // return form state and methods
        return {
            form,
            getStatusBadgeClass,
            formatStatus,
            getGroupName,
            getGroupBadgeClass,
            getGroupHeaderClass,
            formatDate,
            determineHistoryTypeLabel,
        };
    },
};
</script>

<style scoped>
/* Tambahkan definisi kelas warna yang digunakan di badge jika belum ada di file CSS global Anda */
.bg-info-subtle { background-color: #cff4fc; } 
.text-info-emphasis { color: #055160; } 
.bg-primary-subtle { background-color: #cfe2ff; }
.text-primary-emphasis { color: #0a58ca; }
.bg-light-subtle { background-color: #f8f9fa; }

.bg-info { background-color: #0dcaf0 !important; }
.bg-primary { background-color: #0d6efd !important; }
.bg-secondary { background-color: #6c757d !important; }
.bg-dark { background-color: #212529 !important; }
.bg-success { background-color: #198754 !important; }
.bg-warning { background-color: #ffc107 !important; }

/* Custom Navy Style dari Edit.vue */
.btn-navy {
    background-color: #003366;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    transition: all 0.2s ease;
}
.btn-navy:hover {
    background-color: #002244;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 51, 102, 0.25);
}
.btn-outline-navy {
    color: #003366;
    border-color: #003366;
    background-color: transparent;
    border-radius: 6px;
}
.btn-outline-navy:hover {
    color: white;
    background-color: #003366;
}
.text-navy { color: #003366; }


.shadow-lg {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.table-detail td {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    border-top: none; 
}
.table-detail tbody tr:first-child td {
    padding-top: 0;
}
/* Menambahkan gaya default untuk konsistensi */
.fa { font-family: 'Font Awesome 5 Free'; font-weight: 900; }
.bi-arrow-left::before { content: "\f060"; font-family: "bootstrap-icons"; font-weight: 900;} 
.fa-user::before { content: "\f007"; }
.fa-users::before { content: "\f0c0"; }
.fa-history::before { content: "\f1da"; }
.fa-book::before { content: "\f02d"; }
.bi-people-fill::before { content: "\f475"; font-family: "bootstrap-icons"; }
.bi-pencil-square::before { content: "\f484"; font-family: "bootstrap-icons"; }
</style>