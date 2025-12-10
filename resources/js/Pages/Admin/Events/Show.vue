<template>
    <Head>
        <title>Detail Event - Administrator</title>
    </Head>

    <div class="container-fluid px-3 px-md-4 py-3 py-md-4">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <h2 class="fs-4 fs-md-3 fw-bold mb-0 text-navy">Detail Event</h2>
                    <Link href="/admin/events" class="btn btn-outline-secondary border-0 shadow-sm w-100 w-md-auto text-start text-md-center">
                        <i class="fa fa-arrow-left me-2"></i> Kembali
                    </Link>
                </div>

                <div class="card border-0 shadow mb-4 rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h4 class="fw-bold text-primary mb-0">{{ event.title }}</h4>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <table class="table table-borderless table-sm detail-table mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold text-muted text-uppercase small ls-1" style="width: 100px;">Tanggal</td>
                                            <td>: <span class="fw-bold text-dark">{{ formatDate(event.date) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted text-uppercase small ls-1">Tempat</td>
                                            <td>: {{ event.place || '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted text-uppercase small ls-1">Status</td>
                                            <td>
                                                : <span :class="getStatusBadgeClass(event.status)" class="badge py-1 px-3 fw-normal rounded-pill">
                                                    {{ formatStatus(event.status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr class="my-4 border-light">

                        <div class="mt-3">
                            <h5 class="fw-bold mb-3 fs-6 text-uppercase text-muted ls-1">Deskripsi Kegiatan</h5>
                            <div class="p-3 bg-light rounded-3 border border-light" style="min-height: 100px;">
                                <div v-html="event.body" class="text-break detail-content small-md"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow rounded-4">
                    <div class="card-body p-3 p-md-4">
                        <h4 class="fw-bold mb-4 fs-5 fs-md-4">Data Peserta</h4>

                        <div class="row mb-3 align-items-end g-3">
                            <div class="col-12 col-md-6 order-1 order-md-0">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group">
                                        <span class="input-group-text border-0 shadow-sm bg-white ps-3">
                                            <i class="fa fa-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-0 shadow-sm ps-2 py-2" v-model="search" placeholder="Cari nama peserta...">
                                    </div>
                                </form>
                            </div>
                            
                            <div class="col-12 col-md-6 text-md-end order-0 order-md-1">
                                <div v-if="event.status === 'active'" class="d-flex flex-column flex-md-row gap-2 justify-content-md-end">
                                    <Link :href="`/admin/events/${event.id}/unenroll`" class="btn btn-danger shadow-sm w-100 w-md-auto">
                                        <i class="fa fa-trash me-1"></i> Hapus Peserta
                                    </Link>
                                    <Link :href="`/admin/events/${event.id}/enroll`" class="btn btn-success shadow-sm w-100 w-md-auto">
                                        <i class="fa fa-user-plus me-1"></i> Enroll Peserta
                                    </Link>
                                </div>
                                <div v-else>
                                    <button class="btn btn-secondary shadow-sm w-100 w-md-auto" disabled>
                                        <i class="fa fa-lock me-1"></i> Event Ditutup
                                    </button>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs mb-3 border-bottom-0">
                            <li class="nav-item">
                                <a class="nav-link active fw-bold border-bottom border-3 border-primary text-primary bg-transparent px-0 me-3" href="#">
                                    List Peserta <span class="badge bg-primary-subtle text-primary ms-1 rounded-pill">{{ details.total }}</span>
                                </a>
                            </li>
                        </ul>

                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 rounded-start py-3 ps-3" style="width:5%">No.</th>
                                        <th class="border-0 py-3">Nama Peserta</th>
                                        <th class="border-0 py-3">Email / Kontak</th>
                                        <th class="border-0 rounded-end text-center py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(detail, index) in details.data" :key="index">
                                        <td class="fw-bold text-secondary ps-3">
                                            {{ ++index + (details.current_page - 1) * details.per_page }}
                                        </td>
                                        <td class="fw-bold text-navy">{{ detail.member.name }}</td>
                                        <td class="text-muted small">{{ detail.member.email }} / {{ detail.member.contact || '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">
                                                {{ detail.status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr v-if="details.data.length === 0">
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-people display-6 d-block mb-2 opacity-50"></i>
                                            Belum ada peserta yang terdaftar.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-md-none">
                            <div v-for="(detail, index) in details.data" :key="index" class="card mb-3 border shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-light text-secondary me-2 border">#{{ ++index + (details.current_page - 1) * details.per_page }}</span>
                                            <h6 class="fw-bold text-navy mb-0">{{ detail.member.name }}</h6>
                                        </div>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">
                                            {{ detail.status }}
                                        </span>
                                    </div>
                                    <hr class="my-2 border-light">
                                    <div class="text-muted small">
                                        <div class="mb-1"><i class="fa fa-envelope me-2 text-primary opacity-50"></i> {{ detail.member.email }}</div>
                                        <div><i class="fa fa-phone me-2 text-success opacity-50"></i> {{ detail.member.contact || '-' }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div v-if="details.data.length === 0" class="text-center py-5 bg-light rounded">
                                <p class="text-muted mb-0 small">Belum ada peserta yang terdaftar.</p>
                            </div>
                        </div>

                        <div class="mt-4 border-top pt-3">
                            <Pagination :links="details.links" align="center" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import layout
import LayoutAdmin from '../../../Layouts/Admin.vue';

//import component pagination
import Pagination from '../../../Components/Pagination.vue';

//import Heade and Link from Inertia
import { Head, Link } from '@inertiajs/inertia-vue3';

//import inertia adapter
import { Inertia } from '@inertiajs/inertia';

//import ref from vue
import { ref } from 'vue';

export default {
    layout: LayoutAdmin,

    components: {
        Head,
        Link,
        Pagination
    },

    props: {
        errors: Object,
        event: Object,
        details: Object,
    },

    setup(props) {
        // --- Helpers ---
        
        const formatDate = (dateString) => {
            if (!dateString) return '-';
            const date = new Date(dateString);
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            return date.toLocaleDateString('id-ID', options);
        };
        
        const getStatusBadgeClass = (status) => {
            return status === 'active' 
                ? 'bg-success-subtle text-success-emphasis border border-success-subtle' 
                : 'bg-secondary-subtle text-secondary border border-secondary-subtle';
        };

        const formatStatus = (status) => {
            if (!status) return '';
            const formatted = status === 'closed' ? 'Ditutup' : 'Aktif'; 
            return formatted.charAt(0).toUpperCase() + formatted.slice(1);
        };

        // --- Search Logic ---
        
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        const handleSearch = () => {
            Inertia.get(`/admin/events/${props.event.id}`, {
                q: search.value,
            }, {
                preserveState: true,
                preserveScroll: true
            });
        }

        return {
            search,
            handleSearch,
            formatDate,
            getStatusBadgeClass,
            formatStatus
        }
    }
}
</script>

<style scoped>
.text-navy { color: #003366; }
.text-primary { color: #003366 !important; }
.bg-primary-subtle { background-color: #e6f0ff !important; }

/* Custom Badge Colors */
.bg-success-subtle { background-color: #d1e7dd !important; }
.text-success-emphasis { color: #0f5132 !important; }
.bg-secondary-subtle { background-color: #e2e3e5 !important; }
.text-secondary { color: #6c757d !important; }

/* Letter Spacing Utility */
.ls-1 { letter-spacing: 0.5px; }

/* Utility render HTML agar gambar tidak overflow */
.detail-content :deep(img) {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.detail-table tr td {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
}

/* Pagination Adjustments for Mobile */
:deep(.pagination) {
    flex-wrap: wrap;
    justify-content: center;
    gap: 5px;
}

/* Responsiveness helpers */
@media (min-width: 768px) {
    .w-md-auto { width: auto !important; }
    .small-md { font-size: 1rem; }
}
@media (max-width: 767px) {
    .small-md { font-size: 0.9rem; }
}
</style>