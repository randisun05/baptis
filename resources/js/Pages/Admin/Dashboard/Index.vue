<template>

<div class="container-fluid px-4 py-4">

                <h2 class="fs-2 mb-4">Dashboard Overview</h2>

                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 border-start border-primary border-4 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted fw-semibold mb-2">Total Sales</h6>
                                        <h4 class="mb-0 fw-bold">$24,000</h4>
                                    </div>
                                    <div class="feature bg-primary bg-gradient text-white rounded-3">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted fw-semibold mb-2">New Orders</h6>
                                        <h4 class="mb-0 fw-bold">125</h4>
                                    </div>
                                    <div class="feature bg-success bg-gradient text-white rounded-3">
                                        <i class="bi bi-cart-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 border-start border-warning border-4 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted fw-semibold mb-2">Pending</h6>
                                        <h4 class="mb-0 fw-bold">34</h4>
                                    </div>
                                    <div class="feature bg-warning bg-gradient text-dark rounded-3">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm border-0 border-start border-danger border-4 h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-uppercase text-muted fw-semibold mb-2">Issues</h6>
                                        <h4 class="mb-0 fw-bold">3</h4>
                                    </div>
                                    <div class="feature bg-danger bg-gradient text-white rounded-3">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Recent Transactions</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#1245</td>
                                                <td>John Doe</td>
                                                <td>Oct 24, 2023</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>$120.00</td>
                                                <td><button class="btn btn-sm btn-outline-primary">View</button></td>
                                            </tr>
                                            <tr>
                                                <td>#1246</td>
                                                <td>Jane Smith</td>
                                                <td>Oct 25, 2023</td>
                                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                                                <td>$85.50</td>
                                                <td><button class="btn btn-sm btn-outline-primary">View</button></td>
                                            </tr>
                                            <tr>
                                                <td>#1247</td>
                                                <td>Michael Brown</td>
                                                <td>Oct 26, 2023</td>
                                                <td><span class="badge bg-danger">Cancelled</span></td>
                                                <td>$45.00</td>
                                                <td><button class="btn btn-sm btn-outline-primary">View</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white py-3">
                                <h5 class="mb-0 fw-bold">Server Status</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1">CPU Usage</p>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <p class="mb-1">Memory Usage</p>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                                <p class="mb-1">Disk Space</p>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<!--Our Blogs Ends-->

</template>

<script>
    //import layout Admin
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { ref, reactive, onMounted } from 'vue';
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

        },
        setup(props) {


            return {

            };
            }
        };

</script>

<style>

</style>
