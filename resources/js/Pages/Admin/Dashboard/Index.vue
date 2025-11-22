<template>
    <Head title="Dashboard Admin">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </Head>

    <div class="container-fluid px-4 py-4">

        <h2 class="fs-2 mb-4 fw-bold">Dashboard Admin</h2>

        <div class="row g-4 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 border-start border-primary border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Peserta</h6>
                                <h4 class="mb-0 fw-bold text-primary">{{ stats.total_participants }}</h4>
                            </div>
                            <div class="feature bg-primary bg-gradient text-white rounded-3 p-3">
                                <i class="fas fa-users fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 border-start border-info border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-semibold mb-2">Kelompok Katekumen</h6>
                                <h4 class="mb-0 fw-bold text-info">{{ stats.katekumen_count }}</h4>
                            </div>
                            <div class="feature bg-info bg-gradient text-white rounded-3 p-3">
                                <i class="fas fa-user-friends fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-semibold mb-2">Baptis Bayi</h6>
                                <h4 class="mb-0 fw-bold text-success">{{ stats.baptis_bayi_count }}</h4>
                            </div>
                            <div class="feature bg-success bg-gradient text-white rounded-3 p-3">
                                <i class="fas fa-baby fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 border-start border-warning border-4 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase text-muted fw-semibold mb-2">Akun Terverifikasi</h6>
                                <h4 class="mb-0 fw-bold text-warning">{{ stats.verified_count }}</h4>
                            </div>
                            <div class="feature bg-warning bg-gradient text-dark rounded-3 p-3">
                                <i class="fas fa-check-circle fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Distribusi Kelompok Peserta</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height: 350px;">
                        <canvas id="groupChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Peserta Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kelompok</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="member in stats.recent_members" :key="member.id">
                                        <td class="fw-bold">{{ member.name }}</td>
                                        <td>
                                            <span :class="getGroupBadgeClass(member.group)">
                                                <i class="bi bi-people-fill me-1"></i> {{ getGroupName(member.group) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span :class="getStatusBadgeClass(member.status)">{{ formatStatus(member.status) }}</span>
                                        </td>
                                        <td>
                                            <Link :href="`/admin/members/${member.id}`" class="btn btn-sm btn-outline-primary">Detail</Link>
                                        </td>
                                    </tr>
                                    <tr v-if="stats.recent_members.length === 0">
                                        <td colspan="4" class="text-center text-muted py-4">Tidak ada data peserta terbaru.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LayoutAdmin from '../../../Layouts/Admin.vue';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { ref, reactive, onMounted } from 'vue';
    import Chart from 'chart.js/auto'; 
    import { Inertia } from '@inertiajs/inertia';
    import Swal from 'sweetalert2';
    
    export default {
        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link,
        },

        //props
        props: {
             stats: Object 
        },
        
        setup(props) {
            const stats = reactive(props.stats);

            // --- HELPER FUNCTIONS (DISINKRONKAN) ---

            const getGroupName = (groupValue) => {
                 // Logika disinkronkan dengan file Data Peserta
                 if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) {
                     return 'Katekumen';
                 } else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) {
                     return 'Sakramen Baptis Bayi';
                 }
                 return 'N/A';
            };

            const getGroupBadgeClass = (groupValue) => {
                 // Kelas disinkronkan dengan file Data Peserta (menggunakan subtle/border)
                 if (groupValue === true || groupValue === 'Katekumen' || groupValue === 1) {
                     // Katekumen: Warna Cyan
                     return 'badge bg-info-subtle text-info-emphasis border border-info-subtle fw-normal px-3 py-2';
                 } else if (groupValue === false || groupValue === 'Sakramen Baptis Bayi' || groupValue === 0) {
                      // Sakramen Baptis Bayi: Hijau
                    return 'badge bg-success-subtle text-success-emphasis border border-success-subtle fw-normal px-3 py-2';
                 }
                 return 'badge bg-light text-muted border border-secondary-subtle fw-normal px-3 py-2';
            };

            const getStatusBadgeClass = (status) => {
                 // Kelas disinkronkan dengan file Data Peserta (menggunakan subtle/border)
                 switch (status) {
                     case 'verified':
                         return 'badge bg-success-subtle text-success-emphasis border border-success-subtle fw-normal px-3 py-2';
                     case 'confirm':
                         return 'badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fw-normal px-3 py-2';
                     case 'pending':
                         return 'badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle fw-normal px-3 py-2';
                     default:
                         return 'badge bg-light text-muted border border-secondary-subtle fw-normal px-3 py-2';
                 }
            };
            
            // FUNGSI BARU DISALIN DARI DATA PESERTA UNTUK FORMAT TEKS STATUS
            const formatStatus = (status) => {
                switch (status) {
                    case 'confirmed':
                        return 'Terverifikasi';
                    case 'confirm':
                        return 'Menunggu Verifikasi';
                    case 'pending':
                        return 'Tertunda';
                    default:
                        return status;
                }
            };
            
            // --- CHART.JS INITIALIZATION (DOUGHNUT CHART) ---
            const renderChart = () => {
                const ctx = document.getElementById('groupChart');
                
                if (ctx && typeof Chart !== 'undefined') {
                    if (Chart.getChart(ctx)) {
                        Chart.getChart(ctx).destroy();
                    }

                    new Chart(ctx, {
                        type: 'doughnut', 
                        data: {
                            labels: ['Katekumen', 'Baptis Bayi'],
                            datasets: [{
                                label: 'Jumlah Peserta',
                                data: [stats.katekumen_count, stats.baptis_bayi_count],
                                backgroundColor: [
                                    '#0dcaf0', 
                                    '#198754' 
                                ],
                                borderColor: [
                                    '#ffffff', 
                                    '#ffffff'
                                ],
                                borderWidth: 2,
                                hoverOffset: 10
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false, 
                            cutout: '70%', 
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        font: {
                                            size: 14,
                                            weight: 'bold'
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed !== null) {
                                                const total = stats.katekumen_count + stats.baptis_bayi_count;
                                                const value = context.parsed;
                                                const percentage = ((value / total) * 100).toFixed(1) + '%';
                                                label += value + ' (' + percentage + ')';
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            };

            onMounted(() => {
                setTimeout(renderChart, 100); 
            });


            return {
                stats,
                getGroupName,
                getGroupBadgeClass,
                getStatusBadgeClass,
                formatStatus, // Export fungsi baru
            };
        }
    };
</script>

<style scoped>
/* Menyesuaikan gaya Bootstrap untuk fitur card */
.feature {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}
.card {
    border-radius: 10px;
}

/* --- BADGE STYLE DISINKRONKAN DARI KODE DATA PESERTA --- */
.bg-success-subtle { background-color: #d1e7dd; }
.text-success-emphasis { color: #0f5132; }
.bg-danger-subtle { background-color: #f8d7da; }
.text-danger-emphasis { color: #842029; }
.bg-warning-subtle { background-color: #fff3cd; }
.text-warning-emphasis { color: #664d03; }
.bg-secondary-subtle { background-color: #e2e3e5; }
.text-secondary-emphasis { color: #41464b; }
.bg-info-subtle { background-color: #cff4fc; } /* Custom Info Subtle */
.text-info-emphasis { color: #055160; } /* Custom Info Emphasis */
.bg-primary-subtle { background-color: #cfe2ff; }
.text-primary-emphasis { color: #0a58ca; }
/* -------------------------------------------------------- */
</style>