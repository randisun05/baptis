<template>
    <Head title="Tambah Kegiatan Baru" />

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fs-3 fw-bold mb-0">Tambah Kegiatan Baru</h2>
                    <Link href="/admin/events" class="btn btn-outline-secondary border-0 shadow-sm">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </Link>
                </div>

                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <form @submit.prevent="submit">

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Kegiatan</label>
                                        <input type="text" class="form-control" v-model="form.title" @input="createSlug" :class="{ 'is-invalid': form.errors.title }" placeholder="Contoh: Misa Natal 2025">
                                        <div v-if="form.errors.title" class="invalid-feedback">{{ form.errors.title }}</div>
                                    </div>

                                    <input type="hidden" v-model="form.slug">

                                    <!-- <div class="mb-3">
                                        <label class="form-label fw-bold">Referensi Kegiatan</label>
                                        <select class="form-select" v-model="form.ref_event_id" :class="{ 'is-invalid': form.errors.ref_event_id }">
                                            <option value="" disabled>-- Pilih Kategori Referensi --</option>
                                            <option v-for="ref in refevents" :key="ref.id" :value="ref.id">
                                                {{ ref.title }}
                                            </option>
                                        </select>
                                        <div v-if="form.errors.ref_event_id" class="invalid-feedback">{{ form.errors.ref_event_id }}</div>
                                    </div> -->

                                </div>

                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Pelaksanaan</label>
                                        <input type="date" class="form-control" v-model="form.date" :class="{ 'is-invalid': form.errors.date }">
                                        <div v-if="form.errors.date" class="invalid-feedback">{{ form.errors.date }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tempat / Lokasi</label>
                                        <input type="text" class="form-control" v-model="form.place" :class="{ 'is-invalid': form.errors.place }" placeholder="Contoh: Gereja Utama">
                                        <div v-if="form.errors.place" class="invalid-feedback">{{ form.errors.place }}</div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Deskripsi Kegiatan</label>
                                <textarea class="form-control" v-model="form.body" rows="6" :class="{ 'is-invalid': form.errors.body }" placeholder="Masukkan detail lengkap dan isi kegiatan..."></textarea>
                                <div v-if="form.errors.body" class="invalid-feedback">{{ form.errors.body }}</div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-light shadow-sm">Reset</button>
                                <button type="submit" class="btn btn-primary shadow-sm" :disabled="form.processing">
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
    body: '', // Sesuai dengan kolom 'body' (wajib)
    status: 'active',
});


const createSlug = () => {
    form.slug = form.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-*|-*$/g, '');
};


const submit = () => {
    form.post('/admin/events');
};
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { layout: LayoutAdmin }
</script>