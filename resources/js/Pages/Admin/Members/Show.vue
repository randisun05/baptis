<template>
    <Head>
        <title>Profile Peserta</title>
    </Head>

    <section id="profile" class="container padding py-4">
        <div class="container-fluid px-5">

            <div class="row d-flex justify-content-center">
                
                <div class="col-md-10 col-lg-10">
                    
                    <!-- === Tombol Kembali === -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <Link href="/admin/members" class="btn btn-sm btn-primary border-0 shadow-sm">
                                <i class="fa fa-arrow-left me-2"></i> Kembali ke Daftar Peserta
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
                                        <td class="fw-bold text-muted">Email</td>
                                        <td>:</td>
                                        <td>{{ form.email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">No. Telepon</td>
                                        <td>:</td>
                                        <td>{{ form.contact || '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Nomor Registrasi</td>
                                        <td>:</td>
                                        <td>{{ form.number || '-' }}</td>
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
                            <div v-if="getGroupName(form.group) === 'Katekumen'">
                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">Data Tambahan Katekumen</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Alamat</td><td width="5%">:</td><td>{{ form.katekumen.address || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Pendidikan Terakhir</td><td>:</td><td>{{ form.katekumen.education || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Nama Penjamin</td><td>:</td><td>{{ form.katekumen.namePenjamin || '-' }}</td></tr>
                                </table>

                                <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">Riwayat Agama</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Agama Awal</td><td width="5%">:</td><td>{{ form.riwayat.religion || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Lokasi</td><td>:</td><td>{{ form.riwayat.location || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Tanggal Mulai</td><td>:</td><td>{{ form.riwayat.dateStart || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Dibaptis (Jika Ya)</td><td>:</td><td>{{ form.riwayat.dateBaptis || '-' }} / No. {{ form.riwayat.numberBaptis || '-' }}</td></tr>
                                </table>

                                <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">Status Menikah</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Status Pernikahan</td><td width="5%">:</td><td>{{ form.menikah.statusMarried || '-' }}</td></tr>
                                    <template v-if="form.menikah.statusMarried && form.menikah.statusMarried !== 'Belum Menikah'">
                                        <tr><td class="fw-bold text-muted">Nama Pasangan</td><td>:</td><td>{{ form.menikah.namePasangan || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Agama Pasangan</td><td>:</td><td>{{ form.menikah.religionPasangan || '-' }}</td></tr>
                                    </template>
                                    <template v-if="form.menikah.statusMarried === 'Menikah Katolik'">
                                        <tr><td class="fw-bold text-muted">Gereja / Kota</td><td>:</td><td>{{ form.menikah.placeMarried1 || '-' }} / {{ form.menikah.cityMarried1 || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Tanggal Nikah Katolik</td><td>:</td><td>{{ form.menikah.dateMarried1 || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Peneguh / No. Surat</td><td>:</td><td>{{ form.menikah.namePeneguh1 || '-' }} / {{ form.menikah.numberMarried1 || '-' }}</td></tr>
                                    </template>
                                </table>
                            </div>

                            <!-- DATA BAPTIS BAYI (JIKA SAKRAMEN BAPTIS BAYI) -->
                            <div v-else-if="getGroupName(form.group) === 'Sakramen Baptis Bayi'">
                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">Data Baptis</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Nama Wali Baptis</td><td width="5%">:</td><td>{{ form.baptis.nameWali || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted" width="30%">Nama Pastoor</td><td width="5%">:</td><td>{{ form.baptis.namePastoor || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Status Data Baptis</td><td>:</td><td>{{ form.baptis.status || '-' }}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CARD 3: Data Keluarga -->
                    <div class="card shadow-lg border-0 mt-4 mb-4">
                        <div class="card-header bg-secondary text-white py-3">
                            <h5 class="mb-0"><i class="fa fa-users me-2"></i> Data Anggota Keluarga</h5>
                        </div>
                        <div class="card-body p-4">
                            <div v-if="form.keluarga.length === 0" class="text-muted text-center">
                                <p>Tidak ada data anggota keluarga terkait.</p>
                            </div>
                            <div v-else>
                                <div v-for="(member, index) in form.keluarga" :key="index" class="p-3 border rounded mb-3">
                                    <h6 class="fw-bold mb-2">Anggota Keluarga #{{ index + 1 }} ({{ member.relation || '-' }})</h6>
                                    <table class="table table-sm table-borderless small">
                                        <tr><td class="fw-bold text-muted" width="30%">Nama</td><td>:</td><td>{{ member.name }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Agama / Kontak</td><td>:</td><td>{{ member.religion }} / {{ member.contact }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Alamat</td><td>:</td><td>{{ member.address }}</td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CARD 4: Data Riwayat Kegiatan Lainnya (KONDISIONAL) -->
          <div v-if="getGroupName(form.group) === 'Katekumen'">
    <div class="card shadow-lg border-0 mt-4">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0"><i class="fa fa-history me-2"></i> Data Riwayat Kegiatan Lainnya</h5>
        </div>
        
        <div class="card-body p-4" v-if="form.riwayat">
            
            <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">Data Umum Riwayat</h6>
            <table class="table table-borderless table-detail">
                <tr><td class="fw-bold text-muted" width="30%">No. Peserta</td><td width="5%">:</td><td>{{ form.riwayat.number || '-' }}</td></tr>
                <tr><td class="fw-bold text-muted">Agama Awal</td><td>:</td><td>{{ form.riwayat.religion || '-' }}</td></tr>
                <tr><td class="fw-bold text-muted">Lokasi Kegiatan</td><td>:</td><td>{{ form.riwayat.location || '-' }}</td></tr>
                <tr><td class="fw-bold text-muted">Jadwal</td><td>:</td><td>{{ form.riwayat.schedule || '-' }}</td></tr>
                <tr><td class="fw-bold text-muted">Tanggal Mulai / Selesai</td><td>:</td><td>{{ form.riwayat.dateStart || '-' }} / {{ form.riwayat.dateEnd || '-' }}</td></tr>
                <tr><td class="fw-bold text-muted">Pernah Ikut Sebelumnya</td><td>:</td><td>{{ form.riwayat.participateBefore ? 'Ya' : 'Tidak' }}</td></tr>
            </table>

            <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">Data Baptis / Gereja</h6>
            <table class="table table-borderless table-detail">
                <tr><td class="fw-bold text-muted" width="30%">Nama Guru Agama</td><td width="5%">:</td><td>{{ form.riwayat.nameGuru || '-' }}</td></tr>
                <tr><td class="fw-bold text-muted">Nama Pastor/Imam</td><td>:</td><td>{{ form.riwayat.namePriest || '-' }}</td></tr>
                
                <tr><td class="fw-bold text-muted">Nama Gereja</td><td>:</td><td>{{ form.riwayat.nameGereja || '-' }}</td></tr>
                <tr><td class="fw-bold text-muted">Alamat Gereja</td><td>:</td><td>{{ form.riwayat.addressGereja || '-' }}</td></tr>
                
                <tr><td class="fw-bold text-muted">Tanggal Baptis</td><td>:</td><td>{{ form.riwayat.dateBaptis || '-' }}</td></tr>
                <tr><td class="fw-bold text-muted">No. Surat Baptis</td><td>:</td><td>{{ form.riwayat.numberBaptis || '-' }}</td></tr>
            </table>

        </div>
        <div class="card-body p-4 text-muted text-center" v-else>
            <p class="mb-0">Riwayat kegiatan Peserta ini belum tersedia.</p>
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
import { Inertia } from "@inertiajs/inertia";

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
        // Define form state using data from props.data
        const form = reactive({
            // Data Utama (Member/Registration)
            name: props.data.name,
            email: props.data.email,
            contact: props.data.contact,
            number: props.data.number,
            status: props.data.status,
            group: props.data.group, // Kelompok Katekese (boolean / string)
            
            // Nested Data (Assumed to be loaded by the Controller)
            // Menggunakan nama relasi lowercase sesuai konvensi Eloquent
            katekumen: props.data.data_katekumen || {},
            riwayat: props.data.data_riwayat || {},
            menikah: props.data.data_menikah || {},
            baptis: props.data.data_baptis || {},
            keluarga: props.data.data_keluarga || [],
        });

        // =================================================================
        // === FUNGSI HELPER KELOMPOK KATEKESE (Disalin dari Daftar) =======
        // =================================================================
        const getGroupName = (groupValue) => {
             // Menangani nilai boolean (true/false) atau string/int (1/0)
             if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) {
                return 'Katekumen';
             } else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) {
                return 'Sakramen Baptis Bayi';
             }
             return null;
        };

        const getGroupBadgeClass = (groupValue) => {
             if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) {
                return 'badge bg-info-subtle text-info-emphasis border border-info-subtle fw-normal px-3 py-2';
             } else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) {
                return 'badge bg-primary-subtle text-primary-emphasis border border-primary-subtle fw-normal px-3 py-2';
             }
             return 'badge bg-light text-muted border border-secondary-subtle fw-normal px-3 py-2';
        };

        const getGroupHeaderClass = (groupValue) => {
             if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) {
                return 'bg-info text-white';
             } else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) {
                return 'bg-primary text-white';
             }
             return 'bg-secondary text-white';
        };
        // =================================================================
        
        // Fungsi helper untuk badge status
        const getStatusBadgeClass = (status) => {
            switch (status) {
                case 'verified':
                    return 'badge bg-success';
                case 'confirm':
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
            getGroupHeaderClass
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
.bg-info { background-color: #0dcaf0 !important; }
.bg-primary { background-color: #0d6efd !important; }
.bg-secondary { background-color: #6c757d !important; }
.bg-dark { background-color: #212529 !important; }

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
.fa-arrow-left::before { content: "\f060"; } 
.fa-user::before { content: "\f007"; }
.fa-users::before { content: "\f0c0"; }
.fa-history::before { content: "\f1da"; }
.fa-book::before { content: "\f02d"; }
.bi-people-fill::before { content: "\f475"; font-family: "bootstrap-icons"; }
</style>