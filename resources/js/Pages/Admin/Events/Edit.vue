<template>
    <Head :title="`Edit Kegiatan: ${form.title}`" />

    <div class="container-fluid px-3 px-md-4 py-3 py-md-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <h2 class="fs-4 fs-md-3 fw-bold mb-0">Edit Kegiatan</h2>
                        <p class="text-muted mb-0 small text-truncate" style="max-width: 300px;">
                            {{ event.title }}
                        </p>
                    </div>
                    
                    <Link href="/admin/events" class="btn btn-outline-secondary border-0 shadow-sm w-100 w-md-auto text-center">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </Link>
                </div>

                <div class="card border-0 shadow rounded-3">
                    <div class="card-body p-3 p-md-4">
                        <form @submit.prevent="submit">

                            <div class="row">
                                <div class="col-12 col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Kegiatan</label>
                                        <input type="text" class="form-control" v-model="form.title" @input="createSlug" :class="{ 'is-invalid': form.errors.title }" placeholder="Contoh: Misa Natal 2025">
                                        <div v-if="form.errors.title" class="invalid-feedback">{{ form.errors.title }}</div>
                                    </div>
                                    
                                </div>

                                <div class="col-12 col-md-6">

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
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Deskripsi Kegiatan</label>
                                        <textarea class="form-control" v-model="form.body" rows="6" :class="{ 'is-invalid': form.errors.body }" placeholder="Masukkan detail lengkap dan isi kegiatan..."></textarea>
                                        <div v-if="form.errors.body" class="invalid-feedback">{{ form.errors.body }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status Kegiatan</label>
                                        <select class="form-select" v-model="form.status" :class="{ 'is-invalid': form.errors.status }">
                                            <option value="active">Aktif</option>
                                            <option value="closed">Ditutup</option>
                                        </select>
                                        <div v-if="form.errors.status" class="invalid-feedback">{{ form.errors.status }}</div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            <div class="d-flex flex-column flex-md-row justify-content-end gap-2">
                                <button type="reset" class="btn btn-light shadow-sm w-100 w-md-auto order-1 order-md-0">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary shadow-sm w-100 w-md-auto order-0 order-md-1" :disabled="form.processing">
                                    <i class="fa fa-save me-1"></i>
                                    {{ form.processing ? 'Menyimpan...' : 'Update Kegiatan' }}
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
    event: Object,
    refevents: Array
});

const form = useForm({
    _method: 'PUT',
    title: props.event.title,
    date: props.event.date,
    place: props.event.place,
    body: props.event.body,
    status: props.event.status, 
});

const createSlug = () => {
    // Logic slug
};

const submit = () => {
    form.put(`/admin/events/${props.event.id}`);
};
</script>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
export default { 
    layout: LayoutAdmin 
}
</script>

<style scoped>
/* Utility tambahan untuk responsivitas */
@media (min-width: 768px) {
    .w-md-auto { width: auto !important; }
}
</style>