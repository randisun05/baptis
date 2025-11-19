<template>
  <Head title="Registrasi Peserta Baru" />

  <div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="fs-3 fw-bold text-navy mb-0">Registrasi Pengguna</h2>
            <p class="text-muted small mb-0">Isi formulir pendaftaran peserta baru.</p>
          </div>
          <Link href="/admin/registration" class="btn btn-outline-navy btn-sm shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </Link>
        </div>

        <div v-if="$page.props.session?.error"
             class="alert alert-danger bg-danger-subtle text-danger-emphasis alert-dismissible fade show shadow-sm border-0 mb-4"
             role="alert">
             <i class="bi bi-exclamation-triangle-fill me-2"></i>
             {{ $page.props.session?.error }}
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
          <div class="card-body p-4">
            
            <form @submit.prevent="submit">

              <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Informasi Data Diri</h5>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="name" class="form-label fw-bold text-navy">Nama Lengkap</label>
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
              </div>

              <div class="row">
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

              <div class="row">
                <div class="col-12 mb-3">
                  <label for="kelompok" class="form-label fw-bold text-navy">Kelompok Katekese</label>
                  <select 
                    class="form-select input-tegas" 
                    :class="{ 'is-invalid': form.errors.kelompok }" 
                    id="kelompok" 
                    v-model="form.kelompok"
                  >
                    <option value="" disabled>-- Pilih Kelompok Pelayanan --</option>
                    <option value="Katekumen">Katekumen (Dewasa/Anak)</option>
                    <option value="Sakramen Baptis Bayi">Sakramen Baptis Bayi</option>
                  </select>
                  <div v-if="form.errors.kelompok" class="invalid-feedback">{{ form.errors.kelompok }}</div>
                  <div class="form-text text-muted small">Pilih jenis pelayanan yang akan diikuti peserta.</div>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                
                <button type="button" @click="form.reset()" class="btn btn-link text-danger text-decoration-none px-0">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Form
                </button>

                <div class="d-flex gap-2">
                    <Link href="/admin/registration" class="btn btn-light border">Batal</Link>
                    <button type="submit" class="btn btn-navy px-4 shadow-sm" :disabled="form.processing">
                    <span v-if="form.processing">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Menyimpan...
                        </span>
                        <span v-else>
                            <i class="bi bi-save me-1"></i> Simpan Data
                        </span>
                    </button>
                </div>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
// 1. Import SweetAlert2
import Swal from 'sweetalert2'

const form = useForm({
    name: '',
    gender: '',      
    email: '',
    contact: '',     
    kelompok: '',    
})

const submit = () => {
    form.post('/admin/registration', {
        // 2. Tambahkan event onSuccess
        onSuccess: () => {
            // Tampilkan Alert Sukses
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data peserta baru berhasil disimpan.',
                icon: 'success',
                confirmButtonColor: '#003366', // Warna Navy sesuai tema
                confirmButtonText: 'OK'
            });
            // Form otomatis di-reset jika sukses (opsional, hapus baris ini jika tidak ingin reset)
            form.reset(); 
        }
    });
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin };
</script>

<style scoped>
/* --- Theme Variables & Styles --- */
:root {
    --navy-primary: #003366;
    --navy-hover: #002244;
}

.text-navy { color: #003366; }
.bg-navy { background-color: #003366; }

/* --- Input Style (Tegas & Rapi) --- */
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

select.input-tegas {
    cursor: pointer;
}

/* Button Custom Navy */
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

/* Button Outline Navy */
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

/* Utils */
.card { border-radius: 16px; }
.bg-danger-subtle { background-color: #f8d7da; }
.text-danger-emphasis { color: #842029; }
</style>