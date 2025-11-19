<template>
  <Head title="Registrasi Peserta Baru" />

  <div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fs-3 fw-bold">Registrasi Peserta</h2>
          <Link href="/participants" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </Link>
        </div>

        <div class="card shadow-sm border-0">
          <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-muted">Formulir Data Diri</h5>
          </div>
          <div class="card-body p-4">

            <!--
              Form @submit.prevent="submit"
              Inertia (useForm) akan otomatis menangani file upload
              menjadi multipart/form-data.
            -->
            <form @submit.prevent="submit">

              <div class="row">
                <!-- NIK -->
                <div class="col-md-6 mb-3">
                  <label for="nik" class="form-label fw-semibold">NIK (No. KTP)</label>
                  <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.nik }" id="nik" v-model="form.nik" placeholder="Contoh: 3201...">
                  <div v-if="form.errors.nik" class="invalid-feedback">{{ form.errors.nik }}</div>
                </div>

                <!-- Nama Lengkap -->
                <div class="col-md-6 mb-3">
                  <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                  <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.name }" id="name" v-model="form.name" placeholder="Contoh: Budi Santoso">
                  <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                </div>
              </div>

              <div class="row">
                <!-- Email -->
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label fw-semibold">Alamat Email</label>
                  <input type="email" class="form-control" :class="{ 'is-invalid': form.errors.email }" id="email" v-model="form.email" placeholder="nama@email.com">
                  <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
                </div>

                <!-- Contact (Pengganti Phone) -->
                <div class="col-md-6 mb-3">
                  <label for="contact" class="form-label fw-semibold">Nomor WhatsApp/HP</label>
                  <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.contact }" id="contact" v-model="form.contact" placeholder="08123xxxx">
                  <div v-if="form.errors.contact" class="invalid-feedback">{{ form.errors.contact }}</div>
                </div>
              </div>

              <div class="row">
                <!-- Document (File Upload) -->
                <div class="col-12 mb-3">
                  <label for="document" class="form-label fw-semibold">Upload Dokumen</label>

                  <!--
                    Gunakan @input untuk file, bukan v-model.
                    $event.target.files[0] mengambil file yang dipilih.
                  -->
                  <input type="file" class="form-control" :class="{ 'is-invalid': form.errors.document }" id="document" @input="form.document = $event.target.files[0]">

                  <div v-if="form.errors.document" class="invalid-feedback">{{ form.errors.document }}</div>
                  <div class="form-text">Tipe file: PDF, JPG, PNG. Max: 2MB.</div>

                  <!-- Progress Bar untuk File Upload -->
                  <div v-if="form.progress" class="progress mt-2" style="height: 8px;">
                    <div class="progress-bar progress-bar-striped bg-primary"
                         role="progressbar"
                         :style="{ width: form.progress.percentage + '%' }"
                         :aria-valuenow="form.progress.percentage"
                         aria-valuemin="0"
                         aria-valuemax="100">
                    </div>
                  </div>

                </div>
              </div>

              <hr class="my-4">

              <div class="d-flex justify-content-end gap-2">
                <Link href="/participants" class="btn btn-light">Batal</Link>
                <button type="submit" class="btn btn-primary px-4" :disabled="form.processing">
                  <i class="bi bi-save me-1"></i>
                  {{ form.processing ? 'Menyimpan...' : 'Daftarkan Peserta' }}
                </button>
              </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm} from '@inertiajs/inertia-vue3'

// Menyesuaikan useForm dengan validasi baru
const form = useForm({
    nik: '',
    name: '',
    email: '',
    contact: '',       // Mengganti 'phone' dan 'agency'
    document: null     // Default 'null' untuk file input
})

// Fungsi submit
const submit = () => {
    // form.post akan otomatis mengirim sebagai multipart/form-data
    // karena 'document' (file) terdeteksi.
    form.post('/admin/registration', {
        // Hapus file dari form jika error agar tidak dikirim ulang
        // dan tidak menyebabkan error validasi "file must be a file"
        onError: () => {
            if (form.errors.document) {
                form.reset('document');
            }
        }
    })
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin };
</script>

