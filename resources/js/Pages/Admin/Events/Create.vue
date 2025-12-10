<template>
    <Head title="Tambah Kegiatan Baru" />

    <div class="container-fluid px-3 px-md-4 py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h2 class="fs-4 fs-md-3 fw-bold mb-0 text-navy">Tambah Kegiatan Baru</h2>
                    <Link href="/admin/events" class="btn btn-outline-secondary border-0 shadow-sm w-100 w-md-auto text-start text-md-center">
                        <i class="fa fa-arrow-left me-2"></i> Kembali
                    </Link>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-3 p-md-4">
                        <form @submit.prevent="submit">

                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted text-uppercase ls-1">Nama Kegiatan</label>
                                        <input type="text" class="form-control" v-model="form.title" @input="createSlug" :class="{ 'is-invalid': form.errors.title }" placeholder="Contoh: Misa Natal 2025">
                                        <div v-if="form.errors.title" class="invalid-feedback">{{ form.errors.title }}</div>
                                    </div>

                                    <input type="hidden" v-model="form.slug">

                                    </div>

                                <div class="col-12 col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted text-uppercase ls-1">Tanggal Pelaksanaan</label>
                                        <input type="date" class="form-control" v-model="form.date" :class="{ 'is-invalid': form.errors.date }">
                                        <div v-if="form.errors.date" class="invalid-feedback">{{ form.errors.date }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted text-uppercase ls-1">Tempat / Lokasi</label>
                                        <input type="text" class="form-control" v-model="form.place" :class="{ 'is-invalid': form.errors.place }" placeholder="Contoh: Gereja Utama">
                                        <div v-if="form.errors.place" class="invalid-feedback">{{ form.errors.place }}</div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted text-uppercase ls-1">Deskripsi Kegiatan</label>
                                <textarea class="form-control" v-model="form.body" rows="6" :class="{ 'is-invalid': form.errors.body }" placeholder="Masukkan detail lengkap dan isi kegiatan..."></textarea>
                                <div v-if="form.errors.body" class="invalid-feedback">{{ form.errors.body }}</div>
                            </div>

                            <div class="d-flex flex-column flex-md-row justify-content-end gap-2 pt-3 border-top">
                                <button type="reset" class="btn btn-light shadow-sm w-100 w-md-auto order-1 order-md-0">
                                    <i class="fa fa-refresh me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-navy shadow-sm w-100 w-md-auto order-0 order-md-1" :disabled="form.processing">
                                    <i class="fa fa-save me-1"></i>
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan Kegiatan' }}
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
import { useForm, Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    refevents: Array
});

const form = useForm({
    title: '',
    // ref_event_id: '',
    date: '',
    place: '',
    body: '', 
    status: 'active',
});

const createSlug = () => {
    // Pastikan title ada isinya sebelum replace
    if (form.title) {
        form.slug = form.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-*|-*$/g, '');
    } else {
        form.slug = '';
    }
};

const submit = () => {
    form.post('/admin/events');
};
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>

<style scoped>
.text-navy { color: #003366; }

/* Custom Button Style */
.btn-navy {
    background-color: #003366;
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-navy:hover:not(:disabled) {
    background-color: #002244;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 51, 102, 0.2);
}

.btn-navy:disabled {
    background-color: #556b83;
    cursor: not-allowed;
}

.ls-1 { letter-spacing: 1px; font-size: 0.75rem; }

/* Utility untuk responsive width di tombol */
@media (min-width: 768px) {
    .w-md-auto { width: auto !important; }
}
</style>