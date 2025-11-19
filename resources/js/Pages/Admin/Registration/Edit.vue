<template>
  <Head title="Edit Data Peserta" />

  <div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="fs-3 fw-bold">Edit Data Peserta</h2>
          <Link href="/admin/registration" class="btn btn-outline-secondary btn-sm">
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
              Inertia akan mengirim _method: 'PUT' via POST
              karena ada file upload.
            -->
            <form @submit.prevent="submit">

              <div class="row">
                <!-- NIK -->
                <div class="col-md-6 mb-3">
                  <label for="nik" class="form-label fw-semibold">NIK (No. KTP)</label>
                  <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.nik }" id="nik" v-model="form.nik">
                  <div v-if="form.errors.nik" class="invalid-feedback">{{ form.errors.nik }}</div>
                </div>

                <!-- Nama Lengkap -->
                <div class="col-md-6 mb-3">
                  <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                  <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.name }" id="name" v-model="form.name">
                  <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                </div>
              </div>

              <div class="row">
                <!-- Email -->
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label fw-semibold">Alamat Email</label>
                  <input type="email" class="form-control" :class="{ 'is-invalid': form.errors.email }" id="email" v-model="form.email">
                  <div v-if="form.errors.email" class="invalid-feedback">{{ form.errors.email }}</div>
                </div>

                <!-- Contact (Pengganti Phone) -->
                <div class="col-md-6 mb-3">
                  <label for="contact" class="form-label fw-semibold">Nomor WhatsApp/HP</label>
                  <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.contact }" id="contact" v-model="form.contact">
                  <div v-if="form.errors.contact" class="invalid-feedback">{{ form.errors.contact }}</div>
                </div>
              </div>

              <div class="row">
                <!-- Document (File Upload) -->
                <div class="col-12 mb-3">
                  <label for="document" class="form-label fw-semibold">Upload Dokumen Baru (Opsional)</label>

                  <input type="file" class="form-control" :class="{ 'is-invalid': form.errors.document }" id="document" @input="form.document = $event.target.files[0]">

                  <div v-if="form.errors.document" class="invalid-feedback">{{ form.errors.document }}</div>
                  <div class="form-text">Kosongkan jika tidak ingin mengganti dokumen.</div>

                  <!-- Menampilkan Dokumen Saat Ini -->
                  <div v-if="register.document_url" class="mt-3">
                    <span class="form-text">Dokumen saat ini:</span><br>
                    <a :href="register.document_url" target="_blank" class="btn btn-sm btn-outline-dark">
                      <i class="bi bi-file-earmark-text me-1"></i>
                      Lihat Dokumen
                    </a>
                  </div>

                  <!-- Progress Bar untuk File Upload (diubah jadi warning) -->
                  <div v-if="form.progress" class="progress mt-2" style="height: 8px;">
                    <div class="progress-bar progress-bar-striped bg-warning"
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
                <Link href="/admin/registration" class="btn btn-light">Batal</Link>
                <!-- Tombol Update -->
                <button type="submit" class="btn btn-warning px-4" :disabled="form.processing">
                  <i class="bi bi-pencil-square me-1"></i>
                  {{ form.processing ? 'Menyimpan Perubahan...' : 'Update Data' }}
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
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'

// Menerima props 'register' dari controller
const props = defineProps({
    register: Object
})

// Mengisi form dengan data yang ada
const form = useForm({
    _method: 'PUT', // Penting untuk routing update
    nik: props.register.nik,
    name: props.register.name,
    email: props.register.email,
    contact: props.register.contact,
    document: null     // Diisi null, hanya diisi jika ada file baru
})

// Fungsi submit
const submit = () => {
    // Gunakan form.post untuk update jika ada file (multipart/form-data)
    // Inertia akan membaca _method: 'PUT' dan mengirimkannya dengan benar
    form.post(`/admin/registration/${props.register.id}`, {
        // Hapus file dari form jika error
        onError: () => {
            if (form.errors.document) {
                form.reset('document');
            }
        },
        // Jaga scroll position saat validasi error
        preserveScroll: true,
    })
}
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin };
</script>
