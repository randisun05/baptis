<template>
    <Head>
        <title>Profile Peserta</title>
    </Head>

    <section id="profile" class="container padding py-4">
        <div class="container-fluid px-5">

            <div class="row d-flex justify-content-center">
                
                <div class="col-md-10 col-lg-10">
                    <div class="card shadow-lg border-0 mb-4">
                        <div class="card-header bg-navy text-white py-3">
                            <h4 class="mb-0"><i class="bi bi-person-fill fs-5"></i> Detail Profil Peserta</h4>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-navy">{{ form.name }}</h5>
                            
                            <table class="table table-borderless table-detail">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold text-muted" width="30%">Nama Lengkap</td>
                                        <td width="5%">:</td>
                                        <td>{{ form.name }}</td>
                                    </tr>

                                     <tr>
                                        <td class="fw-bold text-muted">Jenis Kelamin</td>
                                        <td>:</td>
                                        <td>{{ formatGender(form.gender) }}</td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold text-muted">Nomor Registrasi</td>
                                        <td>:</td>
                                        <td>{{ form.number || '-' }}</td>
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
                                    
                                    <tr>
                                        <td class="fw-bold text-muted">Kelompok Katekese</td>
                                        <td>:</td>
                                        <td>
                                            <span v-if="getGroupName(form.kelompok)" 
                                                :class="getGroupBadgeClass(form.kelompok)">
                                                <i class="bi bi-people-fill me-1"></i> {{ getGroupName(form.kelompok) }}
                                            </span>
                                            <span v-else class="text-muted fst-italic">
                                                Tidak Ditentukan
                                            </span>
                                        </td>
                                    </tr>
                                    
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

                    <div class="card shadow-lg border-0 mt-4 mb-4" v-if="getGroupName(form.kelompok)">
                        <div class="card-header" :class="getGroupHeaderClass(form.kelompok)">
                            <h5 class="mb-0"><i class="bi bi-card-list fs-5"></i> Detail Kelompok: {{ getGroupName(form.kelompok) }}</h5>
                        </div>
                        
                        <div class="card-body p-4">
                            
                            <div v-if="getGroupName(form.kelompok) === 'Katekumen' && form.data_katekumen_id">
                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">2a. Data Tambahan Katekumen</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Alamat Lengkap</td><td width="5%">:</td><td>{{ form.address || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Pendidikan Terakhir</td><td>:</td><td>{{ form.education || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Nama Penjamin</td><td>:</td><td>{{ form.namePenjamin || '-' }}</td></tr>
                                </table>

                                <div v-if="form.data_riwayat_id">
                                    <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">2b. Riwayat Agama & Kegiatan</h6>
                                    
                                    <h6 class="fw-bold text-secondary mt-3 mb-2 small">Riwayat {{ determineHistoryTypeLabel(form) }}</h6>
                                    
                                    <table class="table table-borderless table-sm table-detail">
                                        <tr><td class="fw-bold text-muted" width="30%">Agama Awal</td><td width="5%">:</td><td>{{ form.religion || '-' }}</td></tr>
                                        <template v-if="determineHistoryTypeLabel(form) === 'I. Pelajaran Katolik'">
                                            <tr><td class="fw-bold text-muted">Tempat / Hari</td><td>:</td><td>{{ form.location || '-' }} / {{ form.schedule || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Mulai / Selesai</td><td>:</td><td>{{ formatDate(form.dateStart) || '-' }} / {{ formatDate(form.dateEnd) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Guru Pengajar</td><td>:</td><td>{{ form.nameGuru || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Pernah Ikut di</td><td>:</td><td>{{ form.participateBefore || '-' }}</td></tr>
                                        </template>
                                        <template v-else-if="determineHistoryTypeLabel(form) === 'II. Baptis Kristen'">
                                            <tr><td class="fw-bold text-muted">Gereja / Alamat</td><td>:</td><td>{{ form.nameGereja || '-' }} / {{ form.addressGereja || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Dibaptis Oleh / Tgl</td><td>:</td><td>{{ form.namePriest || '-' }} / {{ formatDate(form.dateBaptis) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">No. Surat Baptis</td><td>:</td><td>{{ form.numberBaptis || '-' }}</td></tr>
                                        </template>
                                    </table>
                                </div>
                                <div v-else class="text-muted fst-italic small">Riwayat Agama belum diisi.</div>

                                <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">2c. Status Pernikahan</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Status Pernikahan</td><td width="5%">:</td><td>{{ form.statusMarried || '-' }}</td></tr>
                                </table>

                                <div v-if="form.statusMarried && form.statusMarried !== 'Belum Menikah' && form.statusMarried !== 'Pernah Menikah'" class="p-3 border rounded bg-light-subtle mt-3">
                                    <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Data Pasangan</h6>
                                    <table class="table table-borderless table-sm table-detail">
                                        <tr><td class="fw-bold text-muted" width="30%">Nama Pasangan</td><td width="5%">:</td><td>{{ form.namePasangan || '-' }}</td></tr>
                                        <tr v-if="form.statusMarried !== 'Menikah Sipil'"><td class="fw-bold text-muted">Agama Pasangan</td><td>:</td><td>{{ form.religionPasangan || '-' }}</td></tr>
                                    </table>

                                    <div v-if="form.statusMarried === 'Menikah Katolik' && (form.placeMarried1 || form.numberMarried1)">
                                        <h6 class="fw-bold text-secondary mt-3 mb-2 small border-top pt-2">Detail Pernikahan Katolik</h6>
                                        <table class="table table-borderless table-sm table-detail">
                                            <tr><td class="fw-bold text-muted" width="30%">Gereja / Kota</td><td>:</td><td>{{ form.placeMarried1 || '-' }} / {{ form.cityMarried1 || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Tanggal Nikah</td><td>:</td><td>{{ formatDate(form.dateMarried1) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Peneguh / No. Surat</td><td>:</td><td>{{ form.namePeneguh1 || '-' }} / {{ form.numberMarried1 || '-' }}</td></tr>
                                        </table>
                                    </div>

                                    <div v-else-if="form.statusMarried === 'Menikah Kristen' && (form.placeMarried2 || form.numberMarried2)">
                                        <h6 class="fw-bold text-secondary mt-3 mb-2 small border-top pt-2">Detail Pernikahan Kristen</h6>
                                        <table class="table table-borderless table-sm table-detail">
                                            <tr><td class="fw-bold text-muted" width="30%">Tempat / Kota</td><td>:</td><td>{{ form.placeMarried2 || '-' }} / {{ form.cityMarried2 || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Tanggal Nikah</td><td>:</td><td>{{ formatDate(form.dateMarried2) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Pendeta / No. Surat</td><td>:</td><td>{{ form.namePeneguh2 || '-' }} / {{ form.numberMarried2 || '-' }}</td></tr>
                                        </table>
                                    </div>

                                    <div v-else-if="form.statusMarried === 'Menikah Sipil' && (form.cityMarried3 || form.numberMarried3)">
                                        <h6 class="fw-bold text-secondary mt-3 mb-2 small border-top pt-2">Detail Pernikahan Sipil</h6>
                                        <table class="table table-borderless table-sm table-detail">
                                            <tr><td class="fw-bold text-muted" width="30%">Kota</td><td>:</td><td>{{ form.cityMarried3 || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Tanggal Nikah</td><td>:</td><td>{{ formatDate(form.dateMarried3) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">No. Surat</td><td>:</td><td>{{ form.numberMarried3 || '-' }}</td></tr>
                                        </table>
                                    </div>

                                    <div v-else-if="form.statusMarried === 'Menikah Lain' && (form.placeMarried4 || form.numberMarried4)">
                                        <h6 class="fw-bold text-secondary mt-3 mb-2 small border-top pt-2">Detail Pernikahan Lain</h6>
                                        <table class="table table-borderless table-sm table-detail">
                                            <tr><td class="fw-bold text-muted" width="30%">Tempat / Kota</td><td>:</td><td>{{ form.placeMarried4 || '-' }} / {{ form.cityMarried4 || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Tanggal Nikah</td><td>:</td><td>{{ formatDate(form.dateMarried4) || '-' }}</td></tr>
                                            <tr><td class="fw-bold text-muted">Peneguh / No. Surat</td><td>:</td><td>{{ form.namePeneguh4 || '-' }} / {{ form.numberMarried4 || '-' }}</td></tr>
                                        </table>
                                    </div>
                                    <div v-else class="text-muted fst-italic small mt-3">Detail pernikahan belum diisi.</div>
                                </div>
                                
                                <div v-else-if="form.statusMarried === 'Pernah Menikah' && (form.nameMantan || form.yearMantan)" class="p-3 border rounded bg-light-subtle mt-3">
                                    <h6 class="fw-bold mb-3 text-secondary border-bottom pb-2">Detail Pernah Menikah (Janda/Duda)</h6>
                                    <table class="table table-borderless table-sm table-detail">
                                        <tr><td class="fw-bold text-muted" width="30%">Pernah Menikah Dengan</td><td width="5%">:</td><td>{{ form.nameMantan || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Kota Pernikahan</td><td>:</td><td>{{ form.cityMantan || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Status Berakhir</td><td>:</td><td>{{ form.statusMantan || '-' }}</td></tr>
                                        <tr><td class="fw-bold text-muted">Tahun Berakhir</td><td>:</td><td>{{ form.yearMantan || '-' }}</td></tr>
                                    </table>
                                </div>
                                <div v-else-if="form.statusMarried !== 'Belum Menikah'" class="text-muted fst-italic small mt-3">Detail pernikahan belum diisi.</div>


                            </div>

                            <div v-else-if="getGroupName(form.kelompok) === 'Sakramen Baptis Bayi' && form.data_baptis_id">
                                <h6 class="fw-bold text-navy mb-3 border-bottom pb-1">2. Data Sakramen Baptis Bayi</h6>
                                <table class="table table-borderless table-detail">
                                    <tr><td class="fw-bold text-muted" width="30%">Nama Wali Baptis</td><td width="5%">:</td><td>{{ form.nameWali || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted" width="30%">Status Wali Baptis</td><td width="5%">:</td><td>{{ form.baptisStatus || '-' }}</td></tr>
                                    <tr><td class="fw-bold text-muted">Nama Pastoor</td><td>:</td><td>{{ form.namePastoor || '-' }}</td></tr>
                                </table>
                            </div>
                            
                            <div v-else class="text-muted fst-italic text-center">
                                <p class="mb-0">Tidak ada data detail kelompok untuk peserta ini.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow-lg border-0 mt-4 mb-4">
                        <div class="card-header bg-secondary text-white py-3">
                            <h5 class="mb-0"><i class="bi bi-people fs-5"></i> 3. Data Anggota Keluarga</h5>
                        </div>
                        <div class="card-body p-4">
                            <div v-if="form.family_members.length === 0" class="text-muted text-center">
                                <p>Tidak ada data anggota keluarga terkait.</p>
                            </div>
                            <div v-else>
                                <div v-for="(member, index) in form.family_members" :key="index" class="p-3 border rounded mb-3 bg-light">
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

        // Fungsi untuk menentukan tipe riwayat (sesuai logika Edit.vue)
        const determineHistoryTypeLabel = (formData) => {
            // Kita cek berdasarkan data yang paling mungkin diisi di form edit
            
            // Cek Riwayat Pelajaran Katolik (I)
            if (formData.location || formData.schedule || formData.dateStart || formData.nameGuru || formData.participateBefore) {
                return 'I. Pelajaran Katolik';
            }
            // Cek Riwayat Baptis Kristen (II)
            if (formData.nameGereja || formData.namePriest || formData.dateBaptis || formData.numberBaptis) {
                return 'II. Baptis Kristen';
            }
            
            return 'Riwayat Lain';
        };

        // --- Pemetaan Nilai Kelompok/Group ke Numerik (0 dan 1) ---
        // 0 = Sakramen Baptis Bayi, 1 = Katekumen
        const rawGroupValue = props.data.group; 
        const mappedGroup = (() => {
            if (rawGroupValue === 1) {
                return 1; // Katekumen
            } else if (rawGroupValue === 0) {
                return 0; // Sakramen Baptis Bayi
            }
            return null; // Tidak Ditentukan
        })();
        
        // --- Pemetaan Nilai Gender ke Numerik (0 dan 1) ---
        // 0 = Perempuan, 1 = Laki-laki
        const rawGenderValue = props.data.gender; 
        const mappedGender = (() => {
            if (rawGenderValue === 1) {
                return 1; // Laki-laki
            } else if (rawGenderValue === 0) {
                return 0; // Perempuan
            }
            return null; // Tidak Ditentukan/Kosong
        })();
        

        // Define form state using data from props.data (FLATTENED structure, matching edit.vue)
        const form = reactive({
            // Data Utama (Member/Registration)
            id: props.data.id || null, 
            name: props.data.name || '-',
            email: props.data.email || '-',
            contact: props.data.contact || '-',
            number: props.data.number || '-',
            status: props.data.status || 'pending', 
            kelompok: mappedGroup, // Menggunakan nilai numerik hasil pemetaan kelompok
            gender: mappedGender, // Menggunakan nilai numerik hasil pemetaan gender

            // Data Keluarga (Mapping dataKeluarga ke family_members)
            family_members: props.data.data_keluarga || [], 

            // Data Katekumen (FLATTENED from dataKatekumen)
            address: props.data.data_katekumen?.address || '',
            education: props.data.data_katekumen?.education || '',
            namePenjamin: props.data.data_katekumen?.namePenjamin || '', 
            data_katekumen_id: props.data.data_katekumen?.id || null, // Helper ID

            // Data Riwayat (FLATTENED from dataRiwayat)
            religion: props.data.data_riwayat?.religion || '',
            location: props.data.data_riwayat?.location || '',
            schedule: props.data.data_riwayat?.schedule || '',
            dateStart: formatDate(props.data.data_riwayat?.dateStart),
            dateEnd: formatDate(props.data.data_riwayat?.dateEnd),
            participateBefore: props.data.data_riwayat?.participateBefore || '',
            nameGuru: props.data.data_riwayat?.nameGuru || '',
            nameGereja: props.data.data_riwayat?.nameGereja || '',
            addressGereja: props.data.data_riwayat?.addressGereja || '',
            namePriest: props.data.data_riwayat?.namePriest || '',
            dateBaptis: formatDate(props.data.data_riwayat?.dateBaptis),
            numberBaptis: props.data.data_riwayat?.numberBaptis || '',
            data_riwayat_id: props.data.data_riwayat?.id || null, // Helper ID
            
            // Data Menikah (FLATTENED from dataMenikah)
            statusMarried: props.data.data_menikah?.statusMarried || '',
            namePasangan: props.data.data_menikah?.namePasangan || '', 
            religionPasangan: props.data.data_menikah?.religionPasangan || '',
            placeMarried1: props.data.data_menikah?.placeMarried1 || '', cityMarried1: props.data.data_menikah?.cityMarried1 || '', dateMarried1: formatDate(props.data.data_menikah?.dateMarried1), namePeneguh1: props.data.data_menikah?.namePeneguh1 || '', numberMarried1: props.data.data_menikah?.numberMarried1 || '', 
            placeMarried2: props.data.data_menikah?.placeMarried2 || '', cityMarried2: props.data.data_menikah?.cityMarried2 || '', dateMarried2: formatDate(props.data.data_menikah?.dateMarried2), namePeneguh2: props.data.data_menikah?.namePeneguh2 || '', numberMarried2: props.data.data_menikah?.numberMarried2 || '', 
            cityMarried3: props.data.data_menikah?.cityMarried3 || '', dateMarried3: formatDate(props.data.data_menikah?.dateMarried3), numberMarried3: props.data.data_menikah?.numberMarried3 || '', 
            placeMarried4: props.data.data_menikah?.placeMarried4 || '', cityMarried4: props.data.data_menikah?.cityMarried4 || '', dateMarried4: formatDate(props.data.data_menikah?.dateMarried4), namePeneguh4: props.data.data_menikah?.namePeneguh4 || '', numberMarried4: props.data.data_menikah?.numberMarried4 || '', 
            nameMantan: props.data.data_menikah?.nameMantan || '', cityMantan: props.data.data_menikah?.cityMantan || '', statusMantan: props.data.data_menikah?.statusMantan || '', yearMantan: props.data.data_menikah?.yearMantan || '',
            data_menikah_id: props.data.data_menikah?.id || null, // Helper ID

            // Data Baptis Bayi (FLATTENED from dataBaptis)
            namePastoor: props.data.data_baptis?.namePastoor || '',
            baptisStatus: props.data.data_baptis?.status || '', // RENAMED from 'status' to avoid conflict with main status
            nameWali: props.data.data_baptis?.nameWali || '',
            data_baptis_id: props.data.data_baptis?.id || null, // Helper ID
        });


        // =================================================================
        // === FUNGSI HELPER GENDER (BARU/DIMODIFIKASI) ===
        // 0 = Perempuan, 1 = Laki-laki
        // =================================================================
        const formatGender = (genderValue) => {
             if (genderValue === 1) {
                 return 'Laki-laki';
             } else if (genderValue === 0) {
                 return 'Perempuan';
             }
             return '-'; // Jika null atau nilai lain
        };
        
        // =================================================================
        // === FUNGSI HELPER KELOMPOK KATEKESE (DIMODIFIKASI BERDASARKAN REQUEST BARU) ==
        // 0 = Sakramen Baptis Bayi, 1 = Katekumen
        // =================================================================
        const getGroupName = (groupValue) => {
             if (groupValue === 1) {
                 return 'Katekumen';
             } else if (groupValue === 0) {
                 return 'Sakramen Baptis Bayi';
             }
             return null;
        };

        const getGroupBadgeClass = (groupValue) => {
             if (groupValue === 1) {
                 return 'badge bg-info-subtle text-info-emphasis border border-info-subtle fw-normal px-3 py-2';
             } else if (groupValue === 0) {
                 return 'badge bg-primary-subtle text-primary-emphasis border border-primary-subtle fw-normal px-3 py-2';
             }
             return 'badge bg-light text-muted border border-secondary-subtle fw-normal px-3 py-2';
        };

        const getGroupHeaderClass = (groupValue) => {
             if (groupValue === 1) {
                 return 'bg-info text-white';
             } else if (groupValue === 0) {
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
            // Tambahkan formatGender
            formatGender,
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
.bg-navy { background-color: #003366 !important; }
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
.bi-pencil-square::before { content: "\f484"; font-family: "bootstrap-icons"; }
.fa-user::before { content: "\f007"; }
.fa-users::before { content: "\f0c0"; }
.fa-book::before { content: "\f02d"; }
.bi-people-fill::before { content: "\f475"; font-family: "bootstrap-icons"; }
</style>