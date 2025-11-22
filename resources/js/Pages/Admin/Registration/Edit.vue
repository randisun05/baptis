<template>
    <Head title="Edit Data Registrasi" />

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <!-- Menggunakan nama peserta di judul untuk konteks -->
                        <h2 class="fs-3 fw-bold text-navy mb-0">Edit Data Peserta: {{ registration.name }}</h2>
                        <p class="text-muted small mb-0">Perbarui informasi registrasi peserta. (No. Reg: {{ registration.number }})</p>
                    </div>
                    <Link href="/admin/registration" class="btn btn-outline-navy btn-sm shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                    </Link>
                </div>

                <div v-if="$page.props.session?.error"
                    class="alert alert-danger bg-danger-subtle text-danger-emphasis alert-dismissible fade show shadow-sm border-0 mb-4"
                    role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $page.props.session?.error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <!-- Menggunakan form.put untuk proses update -->
                <form @submit.prevent="submit">
                    
                    <!-- CARD 1: INFORMASI DATA DIRI (WAJIB) -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">1. Informasi Data Diri Utama</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="number" class="form-label fw-bold text-navy">Tahun/Nomor Registrasi</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas bg-light-subtle" 
                                        :class="{ 'is-invalid': form.errors.number }" 
                                        id="number" 
                                        v-model="form.number" 
                                        readonly 
                                        disabled
                                    >
                                    <div v-if="form.errors.number" class="invalid-feedback">{{ form.errors.number }}</div>
                                    <div class="form-text text-muted small">Nomor Registrasi tidak dapat diubah.</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-bold text-navy">Nama Lengkap Peserta</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.name }" 
                                        id="name" 
                                        v-model="form.name" 
                                        placeholder="Contoh: Budi Santoso"
                                    >
                                    <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label fw-bold text-navy">Jenis Kelamin</label>
                                    <select 
                                        class="form-select input-tegas" 
                                        :class="{ 'is-invalid': form.errors.gender }" 
                                        id="gender" 
                                        v-model="form.gender"
                                    >
                                        <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <div v-if="form.errors.gender" class="invalid-feedback">{{ form.errors.gender }}</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="kelompok" class="form-label fw-bold text-navy">Kelompok Katekese</label>
                                    <select 
                                        class="form-select input-tegas" 
                                        :class="{ 'is-invalid': form.errors.kelompok }" 
                                        id="kelompok" 
                                        v-model="form.kelompok"
                                        :disabled="true"
                                    >
                                        <!-- Kelompok tidak diizinkan diubah setelah registrasi awal -->
                                        <option value="" disabled>-- Pilih Kelompok Pelayanan --</option>
                                        <option value="Katekumen">Katekumen (Dewasa/Anak)</option>
                                        <option value="Sakramen Baptis Bayi">Sakramen Baptis Bayi</option>
                                    </select>
                                    <div v-if="form.errors.kelompok" class="invalid-feedback">{{ form.errors.kelompok }}</div>
                                    <div class="form-text text-muted small">Jenis Kelompok tidak dapat diubah.</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold text-navy">Alamat Email</label>
                                    <input 
                                        type="email" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.email }" 
                                        id="email" 
                                        v-model="form.email" 
                                        placeholder="nama@email.com"
                                    >
                                    <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact" class="form-label fw-bold text-navy">No. Telepon / WhatsApp</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.contact }" 
                                        id="contact" 
                                        v-model="form.contact" 
                                        placeholder="08123xxxx"
                                    >
                                    <div v-if="form.errors.contact" class="invalid-feedback">{{ form.errors.contact }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ============================================== -->
                    <!-- CARD 2: FORM KONDISIONAL - KATEKUMEN -->
                    <!-- ============================================== -->
                    <div v-if="form.kelompok === 'Katekumen'" class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">2. Data Tambahan Katekumen</h5>

                            <!-- Data Katekumen (DataKatekumen Model) -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label fw-bold text-navy">Alamat Lengkap</label>
                                    <textarea 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.address }" 
                                        id="address" 
                                        v-model="form.address"
                                        placeholder="Alamat tempat tinggal saat ini"
                                    ></textarea>
                                    <div v-if="form.errors.address" class="invalid-feedback">{{ form.errors.address }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="education" class="form-label fw-bold text-navy">Pendidikan Terakhir</label>
                                        <input 
                                            type="text" 
                                            class="form-control input-tegas" 
                                            :class="{ 'is-invalid': form.errors.education }" 
                                            id="education" 
                                            v-model="form.education"
                                            placeholder="Contoh: S1 Teknik"
                                        >
                                        <div v-if="form.errors.education" class="invalid-feedback">{{ form.errors.education }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="namePenjamin" class="form-label fw-bold text-navy">Nama Penjamin</label>
                                        <input 
                                            type="text" 
                                            class="form-control input-tegas" 
                                            :class="{ 'is-invalid': form.errors.namePenjamin }" 
                                            id="namePenjamin" 
                                            v-model="form.namePenjamin"
                                            placeholder="Nama penjamin baptis/wali"
                                        >
                                        <div v-if="form.errors.namePenjamin" class="invalid-feedback">{{ form.errors.namePenjamin }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Data Riwayat (DataRiwayat Model) -->
                            <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">2b. Riwayat Agama & Kegiatan</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="religion" class="form-label fw-bold text-navy">Agama Awal</label>
                                    <input type="text" class="form-control input-tegas" v-model="form.religion" :class="{ 'is-invalid': form.errors.religion }" id="religion">
                                    <div v-if="form.errors.religion" class="invalid-feedback">{{ form.errors.religion }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="location" class="form-label fw-bold text-navy">Lokasi</label>
                                    <input type="text" class="form-control input-tegas" v-model="form.location" :class="{ 'is-invalid': form.errors.location }" id="location">
                                    <div v-if="form.errors.location" class="invalid-feedback">{{ form.errors.location }}</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="dateStart" class="form-label fw-bold text-navy">Tanggal Mulai</label>
                                    <input type="date" class="form-control input-tegas" v-model="form.dateStart" :class="{ 'is-invalid': form.errors.dateStart }" id="dateStart">
                                    <div v-if="form.errors.dateStart" class="invalid-feedback">{{ form.errors.dateStart }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="nameGuru" class="form-label fw-bold text-navy">Nama Guru Agama</label>
                                    <input type="text" class="form-control input-tegas" v-model="form.nameGuru" id="nameGuru">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="nameGereja" class="form-label fw-bold text-navy">Nama Gereja</label>
                                    <input type="text" class="form-control input-tegas" v-model="form.nameGereja" id="nameGereja">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="dateBaptis" class="form-label fw-bold text-navy">Tanggal Dibaptis</label>
                                    <input type="date" class="form-control input-tegas" v-model="form.dateBaptis" id="dateBaptis">
                                </div>
                            </div>


                             <!-- Data Menikah (DataMenikah Model) -->
                            <h6 class="fw-bold text-navy mt-4 mb-3 border-bottom pb-1">2c. Status Pernikahan</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="statusMarried" class="form-label fw-bold text-navy">Status Nikah</label>
                                    <select 
                                        class="form-select input-tegas" 
                                        :class="{ 'is-invalid': form.errors.statusMarried }" 
                                        id="statusMarried" 
                                        v-model="form.statusMarried"
                                    >
                                        <option value="" disabled>-- Pilih Status Nikah --</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        <option value="Menikah Katolik">Menikah Katolik</option>
                                        <option value="Menikah Sipil">Menikah Sipil</option>
                                        <option value="Pernah Menikah">Pernah Menikah (Janda/Duda)</option>
                                    </select>
                                    <div v-if="form.errors.statusMarried" class="invalid-feedback">{{ form.errors.statusMarried }}</div>
                                </div>
                            </div>
                            
                            <!-- Form Pasangan (Conditional) -->
                            <div v-if="form.statusMarried && form.statusMarried !== 'Belum Menikah'" class="p-3 border rounded bg-white mt-3">
                                <h6 class="fw-bold mb-3 text-secondary">Data Pasangan</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="namePasangan" class="form-label small fw-bold">Nama Pasangan</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.namePasangan" :class="{ 'is-invalid': form.errors.namePasangan }" id="namePasangan">
                                        <div v-if="form.errors.namePasangan" class="invalid-feedback">{{ form.errors.namePasangan }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="religionPasangan" class="form-label small fw-bold">Agama Pasangan</label>
                                        <input type="text" class="form-control input-tegas" v-model="form.religionPasangan" :class="{ 'is-invalid': form.errors.religionPasangan }" id="religionPasangan">
                                        <div v-if="form.errors.religionPasangan" class="invalid-feedback">{{ form.errors.religionPasangan }}</div>
                                    </div>
                                </div>
                                
                                <!-- DETAIL KHUSUS: MENIKAH KATOLIK -->
                                <div v-if="form.statusMarried === 'Menikah Katolik'" class="mt-3">
                                    <h6 class="fw-bold mt-3 mb-3 text-secondary border-bottom pb-2">Detail Pernikahan Katolik</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="placeMarried1" class="form-label small fw-bold">Secara Katolik di Gereja</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.placeMarried1" id="placeMarried1">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cityMarried1" class="form-label small fw-bold">Kota</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.cityMarried1" id="cityMarried1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="dateMarried1" class="form-label small fw-bold">Tanggal</label>
                                            <input type="date" class="form-control input-tegas" v-model="form.dateMarried1" id="dateMarried1">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="namePeneguh1" class="form-label small fw-bold">Peneguh Nikah</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.namePeneguh1" id="namePeneguh1">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="numberMarried1" class="form-label small fw-bold">No. Surat Nikah</label>
                                            <input type="text" class="form-control input-tegas" v-model="form.numberMarried1" id="numberMarried1">
                                        </div>
                                    </div>
                                </div>
                                <!-- END DETAIL KHUSUS: MENIKAH KATOLIK -->

                            </div>
                        </div>
                    </div>
                    
                    <!-- ============================================== -->
                    <!-- CARD 2: FORM KONDISIONAL - SAKRAMEN BAPTIS BAYI -->
                    <!-- ============================================== -->
                    <div v-else-if="form.kelompok === 'Sakramen Baptis Bayi'" class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">2. Data Sakramen Baptis Bayi</h5>

                            <!-- Data Baptis Bayi (DataBaptis Model) -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <!-- Di sini nama diambil dari form utama, asumsi field 'name' hanya satu -->
                                    <label for="name" class="form-label fw-bold text-navy">Nama Bayi</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.name }" 
                                        id="name" 
                                        v-model="form.name"
                                    >
                                    <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label fw-bold text-navy">Status Data Baptis</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.status }" 
                                        id="status" 
                                        v-model="form.status"
                                        placeholder="Status di Model DataBaptis"
                                    >
                                    <div v-if="form.errors.status" class="invalid-feedback">{{ form.errors.status }}</div>
                                </div>
                                    <div class="col-md-6 mb-3">
                                    <label for="namePastoor" class="form-label fw-bold text-navy">Nama Pastoor</label>
                                    <input 
                                        type="text" 
                                        class="form-control input-tegas" 
                                        :class="{ 'is-invalid': form.errors.namePastoor }" 
                                        id="namePastoor" 
                                        v-model="form.namePastoor"
                                    >
                                    <div v-if="form.errors.namePastoor" class="invalid-feedback">{{ form.errors.namePastoor }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ============================================== -->
                    <!-- CARD 3: DATA KELUARGA (DYNAMIC ARRAY) -->
                    <!-- ============================================== -->
                    <div v-if="form.kelompok" class="card shadow-sm border-0 rounded-4 mb-4 fade-in">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">3. Data Anggota Keluarga (Ayah, Ibu, dll.)</h5>
                            
                            <p v-if="form.family_members.length === 0" class="text-muted text-center small">
                                Belum ada anggota keluarga ditambahkan. Anggota keluarga wajib diisi.
                            </p>

                            <div v-for="(member, index) in form.family_members" :key="index" class="p-3 border rounded mb-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold text-dark">Anggota #{{ index + 1 }}</span>
                                    <button type="button" @click="removeFamilyMember(index)" class="btn btn-sm btn-danger">
                                        <i class="bi bi-x-lg"></i> Hapus
                                    </button>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label :for="`fam_name_${index}`" class="form-label small fw-bold">Nama</label>
                                        <input type="text" class="form-control input-tegas" v-model="member.name" :class="{ 'is-invalid': form.errors[`family_members.${index}.name`] }" :id="`fam_name_${index}`">
                                        <div v-if="form.errors[`family_members.${index}.name`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.name`] }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label :for="`fam_rel_${index}`" class="form-label small fw-bold">Hubungan</label>
                                        <input type="text" class="form-control input-tegas" v-model="member.relation" :class="{ 'is-invalid': form.errors[`family_members.${index}.relation`] }" :id="`fam_rel_${index}`">
                                        <div v-if="form.errors[`family_members.${index}.relation`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.relation`] }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label :for="`fam_relig_${index}`" class="form-label small fw-bold">Agama</label>
                                        <input type="text" class="form-control input-tegas" v-model="member.religion" :class="{ 'is-invalid': form.errors[`family_members.${index}.religion`] }" :id="`fam_relig_${index}`">
                                        <div v-if="form.errors[`family_members.${index}.religion`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.religion`] }}</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label :for="`fam_contact_${index}`" class="form-label small fw-bold">Kontak</label>
                                        <input type="text" class="form-control input-tegas" v-model="member.contact" :class="{ 'is-invalid': form.errors[`family_members.${index}.contact`] }" :id="`fam_contact_${index}`">
                                        <div v-if="form.errors[`family_members.${index}.contact`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.contact`] }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label :for="`fam_addr_${index}`" class="form-label small fw-bold">Alamat</label>
                                        <textarea class="form-control input-tegas" v-model="member.address" :class="{ 'is-invalid': form.errors[`family_members.${index}.address`] }" :id="`fam_addr_${index}`"></textarea>
                                        <div v-if="form.errors[`family_members.${index}.address`]" class="invalid-feedback">{{ form.errors[`family_members.${index}.address`] }}</div>
                                    </div>
                                </div>

                            </div>

                            <button type="button" @click="addFamilyMember" class="btn btn-sm btn-outline-success mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Anggota Keluarga
                            </button>
                            <div v-if="form.errors.family_members" class="text-danger small mt-2">{{ form.errors.family_members }}</div>
                        </div>
                    </div>
                    
                    <!-- === Tombol Aksi === -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <button type="button" @click="resetForm()" class="btn btn-link text-danger text-decoration-none px-0">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Perubahan
                        </button>

                        <div class="d-flex gap-2">
                            <Link :href="'admin/registration'" class="btn btn-light border">Batal</Link>
                            <button type="submit" class="btn btn-navy px-4 shadow-sm" :disabled="form.processing">
                            <span v-if="form.processing">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Memperbarui...
                            </span>
                                <span v-else>
                                    <i class="bi bi-save me-1"></i> Update Data
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import Swal from 'sweetalert2'
import { watch } from 'vue';

const props = defineProps({
    registration: {
        type: Object,
        required: true
    }
});

// Helper untuk format data tanggal (YYYY-MM-DD)
const formatDate = (dateString) => {
    if (!dateString) return '';
    try {
        // Cek apakah data sudah dalam format YYYY-MM-DD
        if (/^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
            return dateString;
        }
        // Jika tidak, parse sebagai objek Date
        return new Date(dateString).toISOString().slice(0, 10);
    } catch (e) {
        console.error("Failed to format date:", e);
        return dateString; // Kembalikan string asli jika gagal
    }
};

// Fungsi untuk menyiapkan data awal form dari prop
const prepareFormData = (data) => {
    const isCatechumen = data.registration.group; // group: 1 (Katekumen), 0 (Baptis Bayi)
    
    // Data dasar
    let formData = {
        id: data.registration.id, // ID Registrasi
        number: data.registration.number,
        name: data.registration.name,
        gender: data.registration.gender ? 'Laki-laki' : 'Perempuan',
        email: data.registration.email,
        contact: data.registration.contact,
        kelompok: isCatechumen ? 'Katekumen' : 'Sakramen Baptis Bayi',
        
        // Data Keluarga
        family_members: data.family_members && data.family_members.length > 0 ? 
            data.family_members.map(member => ({
                id: member.id, // Penting untuk update
                name: member.name,
                relation: member.relation,
                religion: member.religion,
                address: member.address,
                contact: member.contact,
            })) : 
            [{ name: '', relation: '', religion: '', address: '', contact: '' }], // Jika kosong, set array default

        // Initialize all conditional fields as empty/null for consistency
        address: '', education: '', namePenjamin: '', // DataKatekumen
        religion: '', location: '', schedule: '', dateStart: '', dateEnd: '', participateBefore: false,
        nameGuru: '', nameGereja: '', addressGereja: '', namePriest: '', dateBaptis: '', numberBaptis: '', // DataRiwayat
        statusMarried: '', namePasangan: '', religionPasangan: '',
        placeMarried1: '', cityMarried1: '', dateMarried1: '', namePeneguh1: '', numberMarried1: '', 
        placeMarried2: '', cityMarried2: '', dateMarried2: '', namePeneguh2: '', numberMarried2: '', 
        cityMarried3: '', dateMarried3: '', numberMarried3: '', religionMarried: '', placeMarried4: '', 
        cityMarried4: '', namePeneguh4: '', dateMarried4: '', numberMarried4: '', 
        nameMantan: '', cityMantan: '', statusMantan: '', yearMantan: '', // DataMenikah
        namePastoor: '', status: '', // DataBaptis
    };

    // Mapping data kondisional
    if (isCatechumen) {
        // Data Katekumen
        if (data.data_katekumen) {
            formData.address = data.data_katekumen.address;
            formData.education = data.data_katekumen.education;
            formData.namePenjamin = data.data_katekumen.namePenjamin;
        }

        // Data Riwayat
        if (data.data_riwayat) {
            formData.religion = data.data_riwayat.religion;
            formData.location = data.data_riwayat.location;
            formData.schedule = data.data_riwayat.schedule;
            formData.dateStart = formatDate(data.data_riwayat.dateStart);
            formData.dateEnd = formatDate(data.data_riwayat.dateEnd);
            formData.participateBefore = data.data_riwayat.participateBefore;
            formData.nameGuru = data.data_riwayat.nameGuru;
            formData.nameGereja = data.data_riwayat.nameGereja;
            formData.addressGereja = data.data_riwayat.addressGereja;
            formData.namePriest = data.data_riwayat.namePriest;
            formData.dateBaptis = formatDate(data.data_riwayat.dateBaptis);
            formData.numberBaptis = data.data_riwayat.numberBaptis;
        }

        // Data Menikah
        if (data.data_menikah) {
            formData.statusMarried = data.data_menikah.statusMarried;
            formData.namePasangan = data.data_menikah.namePasangan;
            formData.religionPasangan = data.data_menikah.religionPasangan;
            formData.placeMarried1 = data.data_menikah.placeMarried1;
            formData.cityMarried1 = data.data_menikah.cityMarried1;
            formData.dateMarried1 = formatDate(data.data_menikah.dateMarried1);
            formData.namePeneguh1 = data.data_menikah.namePeneguh1;
            formData.numberMarried1 = data.data_menikah.numberMarried1;
            formData.placeMarried2 = data.data_menikah.placeMarried2;
            formData.cityMarried2 = data.data_menikah.cityMarried2;
            formData.dateMarried2 = formatDate(data.data_menikah.dateMarried2);
            formData.namePeneguh2 = data.data_menikah.namePeneguh2;
            formData.numberMarried2 = data.data_menikah.numberMarried2;
            formData.cityMarried3 = data.data_menikah.cityMarried3;
            formData.dateMarried3 = formatDate(data.data_menikah.dateMarried3);
            formData.numberMarried3 = data.data_menikah.numberMarried3;
            formData.religionMarried = data.data_menikah.religionMarried;
            formData.placeMarried4 = data.data_menikah.placeMarried4;
            formData.cityMarried4 = data.data_menikah.cityMarried4;
            formData.namePeneguh4 = data.data_menikah.namePeneguh4;
            formData.dateMarried4 = formatDate(data.data_menikah.dateMarried4);
            formData.numberMarried4 = data.data_menikah.numberMarried4;
            formData.nameMantan = data.data_menikah.nameMantan;
            formData.cityMantan = data.data_menikah.cityMantan;
            formData.statusMantan = data.data_menikah.statusMantan;
            formData.yearMantan = data.data_menikah.yearMantan;
        }
    } else {
        // Data Baptis Bayi
        if (data.data_baptis) {
            // Catatan: name di DataBaptis juga diisi, tapi kita gunakan name dari registration utama
            // formData.name = data.data_baptis.name; 
            formData.status = data.data_baptis.status;
            formData.namePastoor = data.data_baptis.namePastoor;
        }
    }

    return formData;
};

// Inisialisasi form dengan data yang sudah di-load
const form = useForm(prepareFormData(props.registration));


// Fungsi untuk menambahkan anggota keluarga baru
const addFamilyMember = () => {
    // Memberikan ID null untuk membedakan dengan data yang sudah ada
    form.family_members.push({ id: null, name: '', relation: '', religion: '', address: '', contact: '' });
}

// Fungsi untuk menghapus anggota keluarga
const removeFamilyMember = (index) => {
    form.family_members.splice(index, 1);
    // Hapus error validation terkait item yang dihapus
    Object.keys(form.errors).forEach(key => {
        if (key.startsWith(`family_members.${index}`)) {
            delete form.errors[key];
        }
    });
}

// Fungsi untuk mereset form ke data awal yang dimuat dari prop
const resetForm = () => {
    // Membuat ulang form dengan data awal dari prop
    const initialData = prepareFormData(props.registration);
    form.defaults(initialData).reset();
    
    // Menghapus semua error
    Object.keys(form.errors).forEach(key => {
        delete form.errors[key];
    });

    // Tampilkan notifikasi
     Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: 'Perubahan dibatalkan!',
        showConfirmButton: false,
        timer: 3000
    });
}

// Fungsi submit untuk melakukan update data
const submit = () => {
    // --- PERBAIKAN: Menggunakan template literal untuk URL manual ---
    const updateUrl = `/admin/registration/${props.registration.registration.id}`;
    
    form.put(updateUrl, {
        onSuccess: () => {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data peserta berhasil diperbarui.',
                icon: 'success',
                confirmButtonColor: '#003366',
                confirmButtonText: 'OK'
            });
        },
        onError: () => {
             Swal.fire({
                title: 'Gagal Validasi!',
                text: 'Mohon periksa kembali isian formulir Anda.',
                icon: 'error',
                confirmButtonColor: '#003366',
                confirmButtonText: 'OK'
            });
        }
    });
}
// ... (Watcher dan export default lainnya tidak berubah)

// Watcher untuk mereset field kondisional jika kelompok berubah
watch(() => form.kelompok, (newKelompok) => {
    // Di mode Edit, 'kelompok' disabled, tapi ini sebagai fallback yang baik:
    if (newKelompok === 'Sakramen Baptis Bayi') {
        // Reset field Katekumen/Riwayat/Menikah
        form.address = form.education = form.namePenjamin = '';
        form.religion = form.location = form.schedule = form.dateStart = form.dateEnd = '';
        form.nameGuru = form.nameGereja = form.addressGereja = form.namePriest = form.dateBaptis = form.numberBaptis = '';
        form.statusMarried = form.namePasangan = form.religionPasangan = '';
        // ... reset semua field DataMenikah

    } else if (newKelompok === 'Katekumen') {
        // Reset field Baptis Bayi
        form.namePastoor = form.status = '';
    }
});

</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
// Import layout dan styles tetap sama
export default { 
    layout: LayoutAdmin,
    // Styles yang sama dari file Create.vue
    mounted() {
        // Terapkan styles kustom (seperti dari file Create.vue)
        const style = document.createElement('style');
        style.innerHTML = `
            /* --- ANIMASI & UX --- */
            .fade-in { animation: fadeIn 0.5s ease-in-out; }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            :root {
                --navy-primary: #003366;
                --navy-hover: #002244;
            }
            .text-navy { color: #003366; }
            .bg-navy { background-color: #003366; }
            .input-tegas {
                border: 1px solid #b0b8c4;
                border-radius: 8px; 	 	
                padding: 0.7rem 1rem; 	 	
                font-size: 0.95rem;
                background-color: #fcfcfc;
                transition: all 0.3s ease;
            }
            .input-tegas:hover {
                border-color: #859bb3;
                background-color: #ffffff;
            }
            .input-tegas:focus {
                border-color: #003366; 	 	
                box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1); 
                background-color: #ffffff;
                outline: none;
            }
            select.input-tegas { cursor: pointer; }
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
            .card { border-radius: 16px; }
            .bg-danger-subtle { background-color: #f8d7da; }
            .text-danger-emphasis { color: #842029; }
        `;
        document.head.appendChild(style);
    }
};
</script>