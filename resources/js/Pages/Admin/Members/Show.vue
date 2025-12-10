<template>
    <Head>
        <title>Profile Peserta</title>
    </Head>

    <section id="profile" class="container padding py-4">
        <div class="container-fluid px-3 px-md-5">

            <div class="row justify-content-center mb-3">
                <div class="col-12 col-md-10 col-lg-8">
                    <Link href="/admin/registration" class="btn btn-outline-navy d-inline-flex align-items-center">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Data Peserta
                    </Link>
                </div>
            </div>

            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">
                    
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-navy text-white py-3 d-flex align-items-center">
                            <i class="bi bi-person-fill fs-4 me-2"></i>
                            <h4 class="mb-0 fs-5 fw-bold">1. Informasi Data Diri Utama</h4>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <h5 class="fw-bold mb-3 text-navy border-bottom pb-2">{{ form.name }}</h5>
                            
                            <table class="table table-borderless table-detail responsive-table">
                                <tbody>
                                    <tr>
                                        <td class="label-col text-muted fw-bold">Nomor Registrasi</td>
                                        <td class="separator">:</td>
                                        <td class="value-col fw-bold text-dark">{{ form.number || '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col text-muted fw-bold">Nama Lengkap</td>
                                        <td class="separator">:</td>
                                        <td class="value-col">{{ form.name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col text-muted fw-bold">Jenis Kelamin</td>
                                        <td class="separator">:</td>
                                        <td class="value-col">{{ formatGender(form.gender) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col text-muted fw-bold">Email</td>
                                        <td class="separator">:</td>
                                        <td class="value-col text-break">{{ form.email || '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col text-muted fw-bold">No. Telepon</td>
                                        <td class="separator">:</td>
                                        <td class="value-col">{{ form.contact || '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="label-col text-muted fw-bold">Kelompok</td>
                                        <td class="separator">:</td>
                                        <td class="value-col">
                                            <span v-if="getGroupName(form.kelompok)" :class="getGroupBadgeClass(form.kelompok)">
                                                <i class="bi bi-people-fill me-1"></i> {{ getGroupName(form.kelompok) }}
                                            </span>
                                            <span v-else class="text-muted fst-italic">Tidak Ditentukan</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-col text-muted fw-bold">Status Akun</td>
                                        <td class="separator">:</td>
                                        <td class="value-col">
                                            <span :class="getStatusBadgeClass(form.status)">
                                                {{ formatStatus(form.status) }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card shadow-lg border-0 mt-4 mb-4" v-if="getGroupName(form.kelompok)">
                        <div class="card-header d-flex align-items-center" :class="getGroupHeaderClass(form.kelompok)">
                            <i class="bi bi-card-list fs-4 me-2"></i>
                            <h5 class="mb-0 fs-6 fw-bold">Detail: {{ getGroupName(form.kelompok) }}</h5>
                        </div>
                        
                        <div class="card-body p-3 p-md-4">
                            
                            <div v-if="getGroupName(form.kelompok) === 'Katekumen'">
                                
                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">2a. Data Tambahan Katekumen</h6>
                                <table class="table table-borderless table-detail responsive-table mb-4">
                                    <tr><td class="label-col text-muted fw-bold">Alamat Lengkap</td><td class="separator">:</td><td class="value-col">{{ form.address || '-' }}</td></tr>
                                    <tr><td class="label-col text-muted fw-bold">Pendidikan</td><td class="separator">:</td><td class="value-col">{{ form.education || '-' }}</td></tr>
                                    <tr><td class="label-col text-muted fw-bold">Nama Penjamin</td><td class="separator">:</td><td class="value-col">{{ form.namePenjamin || '-' }}</td></tr>
                                </table>

                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">2b. Riwayat Agama & Kegiatan</h6>
                                <div class="bg-light-subtle p-3 rounded border mb-4">
                                    <table class="table table-borderless table-sm table-detail responsive-table">
                                        <tr><td class="label-col text-muted fw-bold">Agama Awal Peserta</td><td class="separator">:</td><td class="value-col fw-bold">{{ form.religion || '-' }}</td></tr>
                                    </table>

                                    <template v-if="determineHistoryTypeLabel(form) === 'I. Pelajaran Katolik'">
                                        <h6 class="fw-bold text-primary small mt-3 mb-2 border-top pt-2">I. Riwayat Pelajaran Agama Katolik</h6>
                                        <table class="table table-borderless table-sm table-detail responsive-table">
                                            <tr><td class="label-col text-muted fw-bold">Tempat / Hari</td><td class="separator">:</td><td class="value-col">{{ form.location || '-' }} / {{ form.schedule || '-' }}</td></tr>
                                            <tr><td class="label-col text-muted fw-bold">Periode</td><td class="separator">:</td><td class="value-col">{{ formatDate(form.dateStart) || '...' }} s/d {{ formatDate(form.dateEnd) || '...' }}</td></tr>
                                            <tr><td class="label-col text-muted fw-bold">Guru Pengajar</td><td class="separator">:</td><td class="value-col">{{ form.nameGuru || '-' }}</td></tr>
                                            <tr><td class="label-col text-muted fw-bold">Pernah Ikut di</td><td class="separator">:</td><td class="value-col">{{ form.participateBefore || '-' }}</td></tr>
                                        </table>
                                    </template>

                                    <template v-else-if="determineHistoryTypeLabel(form) === 'II. Baptis Kristen'">
                                        <h6 class="fw-bold text-primary small mt-3 mb-2 border-top pt-2">II. Riwayat Baptis Kristen</h6>
                                        <table class="table table-borderless table-sm table-detail responsive-table">
                                            <tr><td class="label-col text-muted fw-bold">Gereja</td><td class="separator">:</td><td class="value-col">{{ form.nameGereja || '-' }}</td></tr>
                                            <tr><td class="label-col text-muted fw-bold">Alamat/Kota</td><td class="separator">:</td><td class="value-col">{{ form.addressGereja || '-' }}</td></tr>
                                            <tr><td class="label-col text-muted fw-bold">Dibaptis Oleh</td><td class="separator">:</td><td class="value-col">{{ form.namePriest || '-' }}</td></tr>
                                            <tr><td class="label-col text-muted fw-bold">Tanggal / No. Surat</td><td class="separator">:</td><td class="value-col">{{ formatDate(form.dateBaptis) || '-' }} / {{ form.numberBaptis || '-' }}</td></tr>
                                        </table>
                                    </template>
                                </div>

                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">2c. Status Pernikahan</h6>
                                <table class="table table-borderless table-detail responsive-table">
                                    <tr><td class="label-col text-muted fw-bold">Status Nikah</td><td class="separator">:</td><td class="value-col fw-bold">{{ form.statusMarried || '-' }}</td></tr>
                                </table>

                                <div v-if="form.statusMarried && form.statusMarried !== 'Belum Menikah'" class="p-3 border rounded bg-light-subtle mt-2">
                                    
                                    <div v-if="form.statusMarried === 'Pernah Menikah'">
                                        <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Detail Pernah Menikah (Janda/Duda)</h6>
                                        <table class="table table-borderless table-sm table-detail responsive-table">
                                            <tr><td class="label-col text-muted fw-bold">Mantan Pasangan</td><td class="separator">:</td><td class="value-col">{{ form.nameMantan || '-' }}</td></tr>
                                            <tr><td class="label-col text-muted fw-bold">Kota / Tahun</td><td class="separator">:</td><td class="value-col">{{ form.cityMantan || '-' }} / {{ form.yearMantan || '-' }}</td></tr>
                                            <tr><td class="label-col text-muted fw-bold">Status Akhir</td><td class="separator">:</td><td class="value-col">{{ form.statusMantan || '-' }}</td></tr>
                                        </table>
                                    </div>

                                    <div v-else>
                                        <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Data Pasangan</h6>
                                        <table class="table table-borderless table-sm table-detail responsive-table mb-3">
                                            <tr><td class="label-col text-muted fw-bold">Nama Pasangan</td><td class="separator">:</td><td class="value-col">{{ form.namePasangan || '-' }}</td></tr>
                                            <tr><td class="label-col text-muted fw-bold">Agama Pasangan</td><td class="separator">:</td><td class="value-col">{{ form.religionPasangan || '-' }}</td></tr>
                                        </table>

                                        <div v-if="form.statusMarried === 'Menikah Katolik'">
                                            <h6 class="fw-bold text-secondary small border-top pt-2 mb-2">Detail Pernikahan Katolik</h6>
                                            <table class="table table-borderless table-sm table-detail responsive-table">
                                                <tr><td class="label-col text-muted fw-bold">Gereja</td><td class="separator">:</td><td class="value-col">{{ form.placeMarried1 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Kota</td><td class="separator">:</td><td class="value-col">{{ form.cityMarried1 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Tanggal</td><td class="separator">:</td><td class="value-col">{{ formatDate(form.dateMarried1) || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Peneguh</td><td class="separator">:</td><td class="value-col">{{ form.namePeneguh1 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">No. Surat</td><td class="separator">:</td><td class="value-col">{{ form.numberMarried1 || '-' }}</td></tr>
                                            </table>
                                        </div>

                                        <div v-else-if="form.statusMarried === 'Menikah Kristen'">
                                            <h6 class="fw-bold text-secondary small border-top pt-2 mb-2">Detail Pernikahan Kristen</h6>
                                            <table class="table table-borderless table-sm table-detail responsive-table">
                                                <tr><td class="label-col text-muted fw-bold">Gereja/Tempat</td><td class="separator">:</td><td class="value-col">{{ form.placeMarried2 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Kota</td><td class="separator">:</td><td class="value-col">{{ form.cityMarried2 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Tanggal</td><td class="separator">:</td><td class="value-col">{{ formatDate(form.dateMarried2) || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Pendeta</td><td class="separator">:</td><td class="value-col">{{ form.namePeneguh2 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">No. Surat</td><td class="separator">:</td><td class="value-col">{{ form.numberMarried2 || '-' }}</td></tr>
                                            </table>
                                        </div>

                                        <div v-else-if="form.statusMarried === 'Menikah Sipil'">
                                            <h6 class="fw-bold text-secondary small border-top pt-2 mb-2">Detail Pernikahan Sipil</h6>
                                            <table class="table table-borderless table-sm table-detail responsive-table">
                                                <tr><td class="label-col text-muted fw-bold">Kota Pencatatan</td><td class="separator">:</td><td class="value-col">{{ form.cityMarried3 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Tanggal</td><td class="separator">:</td><td class="value-col">{{ formatDate(form.dateMarried3) || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">No. Akta/Surat</td><td class="separator">:</td><td class="value-col">{{ form.numberMarried3 || '-' }}</td></tr>
                                            </table>
                                        </div>

                                        <div v-else-if="form.statusMarried === 'Menikah Lain'">
                                            <h6 class="fw-bold text-secondary small border-top pt-2 mb-2">Detail Pernikahan Lain (Adat/Dll)</h6>
                                            <table class="table table-borderless table-sm table-detail responsive-table">
                                                <tr><td class="label-col text-muted fw-bold">Tempat</td><td class="separator">:</td><td class="value-col">{{ form.placeMarried4 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Kota</td><td class="separator">:</td><td class="value-col">{{ form.cityMarried4 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Tanggal</td><td class="separator">:</td><td class="value-col">{{ formatDate(form.dateMarried4) || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">Peneguh</td><td class="separator">:</td><td class="value-col">{{ form.namePeneguh4 || '-' }}</td></tr>
                                                <tr><td class="label-col text-muted fw-bold">No. Surat</td><td class="separator">:</td><td class="value-col">{{ form.numberMarried4 || '-' }}</td></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else-if="getGroupName(form.kelompok) === 'Sakramen Baptis Bayi'">
                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">2. Data Sakramen Baptis Bayi</h6>
                                <table class="table table-borderless table-detail responsive-table">
                                    <tr><td class="label-col text-muted fw-bold">Nama Wali Baptis</td><td class="separator">:</td><td class="value-col">{{ form.nameWali || '-' }}</td></tr>
                                    <tr><td class="label-col text-muted fw-bold">Status Wali Baptis</td><td class="separator">:</td><td class="value-col">{{ form.baptisStatus || '-' }}</td></tr>
                                    <tr><td class="label-col text-muted fw-bold">Nama Pastoor</td><td class="separator">:</td><td class="value-col">{{ form.namePastoor || '-' }}</td></tr>
                                </table>
                            </div>
                            
                            <div v-else class="text-muted fst-italic text-center">
                                <p class="mb-0">Tidak ada detail khusus untuk kelompok ini.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow-lg border-0 mt-4 mb-4">
                        <div class="card-header bg-secondary text-white py-3 d-flex align-items-center">
                            <i class="bi bi-people fs-4 me-2"></i>
                            <h5 class="mb-0 fs-5 fw-bold">3. Data Anggota Keluarga</h5>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div v-if="form.family_members.length === 0" class="text-muted text-center py-3">
                                <i class="bi bi-people text-secondary fs-1 d-block mb-2"></i>
                                <p>Tidak ada data anggota keluarga.</p>
                            </div>
                            <div v-else>
                                <div v-for="(member, index) in form.family_members" :key="index" class="p-3 border rounded mb-3 bg-light">
                                    <h6 class="fw-bold mb-2 text-dark border-bottom pb-1">
                                        <i class="bi bi-person me-1"></i> Anggota #{{ index + 1 }} - {{ member.relation || 'Keluarga' }}
                                    </h6>
                                    <table class="table table-sm table-borderless small responsive-table">
                                        <tr><td class="label-col text-muted fw-bold">Nama</td><td class="separator">:</td><td class="value-col fw-bold">{{ member.name || '-' }}</td></tr>
                                        <tr><td class="label-col text-muted fw-bold">Agama</td><td class="separator">:</td><td class="value-col">{{ member.religion || '-' }}</td></tr>
                                        <tr><td class="label-col text-muted fw-bold">Kontak</td><td class="separator">:</td><td class="value-col">{{ member.contact || '-' }}</td></tr>
                                        <tr><td class="label-col text-muted fw-bold">Alamat</td><td class="separator">:</td><td class="value-col">{{ member.address || '-' }}</td></tr>
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

export default {
    layout: LayoutAdmin,
    components: { Head, Link },
    props: { errors: Object, session: Object, data: Object },
    setup(props) {
        
        // Helper Format Tanggal
        const formatDate = (dateString) => {
            if (!dateString) return null;
            try {
                // Ambil 10 karakter pertama (YYYY-MM-DD) jika format panjang
                if (dateString) return dateString.substring(0, 10);
                return null;
            } catch (e) { return dateString; }
        };

        // Helper Logika Riwayat
        const determineHistoryTypeLabel = (formData) => {
            // Jika ada data baptis, prioritas tampilkan baptis
            if (formData.nameGereja || formData.namePriest || formData.dateBaptis || formData.numberBaptis) return 'II. Baptis Kristen';
            // Jika ada data pelajaran, tampilkan pelajaran
            if (formData.location || formData.schedule || formData.dateStart || formData.nameGuru || formData.participateBefore) return 'I. Pelajaran Katolik';
            return 'Lainnya';
        };

        // Mapping Data dari Props ke Reactive Form
        // Asumsi: Backend mengirim relasi dengan nama: data_katekumen, data_riwayat, data_menikah, data_baptis, data_keluarga
        const form = reactive({
            id: props.data.id || null, 
            name: props.data.name || '-',
            email: props.data.email || '-',
            contact: props.data.contact || '-',
            number: props.data.number || '-',
            status: props.data.status || 'pending', 
            kelompok: props.data.group, // 1 = Katekumen, 0 = Baptis Bayi
            gender: props.data.gender, // 1 = Laki, 0 = Perempuan
            
            // Relasi Array
            family_members: props.data.data_keluarga || [], 

            // Relasi Katekumen
            address: props.data.data_katekumen?.address || '',
            education: props.data.data_katekumen?.education || '',
            namePenjamin: props.data.data_katekumen?.namePenjamin || '', 
            
            // Relasi Riwayat
            religion: props.data.data_riwayat?.religion || '',
            location: props.data.data_riwayat?.location || '',
            schedule: props.data.data_riwayat?.schedule || '',
            dateStart: props.data.data_riwayat?.dateStart,
            dateEnd: props.data.data_riwayat?.dateEnd,
            participateBefore: props.data.data_riwayat?.participateBefore || '',
            nameGuru: props.data.data_riwayat?.nameGuru || '',
            nameGereja: props.data.data_riwayat?.nameGereja || '',
            addressGereja: props.data.data_riwayat?.addressGereja || '',
            namePriest: props.data.data_riwayat?.namePriest || '',
            dateBaptis: props.data.data_riwayat?.dateBaptis,
            numberBaptis: props.data.data_riwayat?.numberBaptis || '',
            
            // Relasi Menikah
            statusMarried: props.data.data_menikah?.statusMarried || '',
            namePasangan: props.data.data_menikah?.namePasangan || '', 
            religionPasangan: props.data.data_menikah?.religionPasangan || '',
            
            // Detail Katolik (1)
            placeMarried1: props.data.data_menikah?.placeMarried1, cityMarried1: props.data.data_menikah?.cityMarried1, 
            dateMarried1: props.data.data_menikah?.dateMarried1, namePeneguh1: props.data.data_menikah?.namePeneguh1, numberMarried1: props.data.data_menikah?.numberMarried1, 
            
            // Detail Kristen (2)
            placeMarried2: props.data.data_menikah?.placeMarried2, cityMarried2: props.data.data_menikah?.cityMarried2, 
            dateMarried2: props.data.data_menikah?.dateMarried2, namePeneguh2: props.data.data_menikah?.namePeneguh2, numberMarried2: props.data.data_menikah?.numberMarried2, 
            
            // Detail Sipil (3)
            cityMarried3: props.data.data_menikah?.cityMarried3, dateMarried3: props.data.data_menikah?.dateMarried3, numberMarried3: props.data.data_menikah?.numberMarried3, 
            
            // Detail Lain (4)
            placeMarried4: props.data.data_menikah?.placeMarried4, cityMarried4: props.data.data_menikah?.cityMarried4, 
            dateMarried4: props.data.data_menikah?.dateMarried4, namePeneguh4: props.data.data_menikah?.namePeneguh4, numberMarried4: props.data.data_menikah?.numberMarried4, 
            
            // Detail Mantan
            nameMantan: props.data.data_menikah?.nameMantan, cityMantan: props.data.data_menikah?.cityMantan, 
            statusMantan: props.data.data_menikah?.statusMantan, yearMantan: props.data.data_menikah?.yearMantan,
            
            // Relasi Baptis Bayi
            namePastoor: props.data.data_baptis?.namePastoor || '',
            baptisStatus: props.data.data_baptis?.status || '', 
            nameWali: props.data.data_baptis?.nameWali || '',
        });

        // Helper Functions UI
        const formatGender = (val) => (val === 1 || val === 'Laki-laki') ? 'Laki-laki' : (val === 0 || val === 'Perempuan') ? 'Perempuan' : '-';
        
        const getGroupName = (val) => {
             if (val === 1 || val === 'Katekumen') return 'Katekumen';
             if (val === 0 || val === 'Sakramen Baptis Bayi') return 'Sakramen Baptis Bayi';
             return null;
        };

        const getGroupBadgeClass = (val) => {
             if (val === 1 || val === 'Katekumen') return 'badge bg-info-subtle text-info-emphasis border border-info-subtle fw-normal px-3 py-2';
             if (val === 0 || val === 'Sakramen Baptis Bayi') return 'badge bg-primary-subtle text-primary-emphasis border border-primary-subtle fw-normal px-3 py-2';
             return 'badge bg-light text-muted';
        };

        const getGroupHeaderClass = (val) => {
             if (val === 1 || val === 'Katekumen') return 'bg-info text-white';
             if (val === 0 || val === 'Sakramen Baptis Bayi') return 'bg-primary text-white';
             return 'bg-secondary text-white';
        };

        const getStatusBadgeClass = (status) => {
            switch (status) {
                case 'verified': case 'lunas': return 'badge bg-success';
                case 'confirm': case 'perlu_verifikasi': return 'badge bg-warning text-dark';
                case 'pending': return 'badge bg-secondary';
                default: return 'badge bg-light text-muted';
            }
        };

        const formatStatus = (status) => {
            switch (status) {
                case 'verified': return 'Terverifikasi';
                case 'confirm': return 'Menunggu Konfirmasi';
                case 'pending': return 'Tertunda';
                default: return status;
            }
        };

        return { form, getStatusBadgeClass, formatStatus, getGroupName, getGroupBadgeClass, getGroupHeaderClass, formatDate, determineHistoryTypeLabel, formatGender };
    },
};
</script>

<style scoped>
/* --- BUTTONS --- */
.btn-outline-navy {
    color: #003366;
    border: 2px solid #003366;
    background-color: transparent;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-outline-navy:hover {
    color: white;
    background-color: #003366;
    transform: translateX(-3px);
}

/* --- COLORS --- */
.bg-info-subtle { background-color: #cff4fc; } 
.text-info-emphasis { color: #055160; } 
.bg-primary-subtle { background-color: #cfe2ff; }
.text-primary-emphasis { color: #0a58ca; }
.bg-light-subtle { background-color: #f8f9fa; }
.bg-navy { background-color: #003366 !important; }
.text-navy { color: #003366; }

/* --- CARD STYLE --- */
.shadow-lg { box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.10) !important; }

/* --- RESPONSIVE TABLE STYLES --- */
/* Desktop */
.table-detail .label-col { width: 30%; }
.table-detail .separator { width: 5%; }
.table-detail td {
    padding-top: 0.6rem;
    padding-bottom: 0.6rem;
    border-top: none; 
    vertical-align: top;
}

/* Mobile */
@media (max-width: 768px) {
    .responsive-table, 
    .responsive-table tbody, 
    .responsive-table tr, 
    .responsive-table td {
        display: block;
        width: 100%;
    }
    .responsive-table tr {
        margin-bottom: 1rem;
        border-bottom: 1px dashed #e0e0e0;
        padding-bottom: 0.5rem;
    }
    .responsive-table tr:last-child {
        border-bottom: none;
    }
    .responsive-table .label-col {
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .responsive-table .separator { display: none; }
    .responsive-table .value-col {
        font-weight: 500;
        color: #212529;
        padding-top: 0.2rem;
    }
}
</style>