<!-- begin::Admin Scripts -->
<!-- Required JavaScript (Bundled: jQuery, Bootstrap, Simplebar, Waves) -->
<script src="{{ asset('admin/libs/global/global.min.js') }}"></script>
<script src="{{ asset('admin/libs/sortable/Sortable.min.js') }}"></script>
<script src="{{ asset('admin/libs/chartjs/chart.js') }}"></script>
<script src="{{ asset('admin/libs/flatpickr/flatpickr.min.js') }}"></script>
<!-- ApexCharts from CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>
<!-- DataTables from CDN -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- Page Specific Scripts -->
@stack('scripts')

<!-- Main Application Script -->
<script src="{{ asset('admin/js/scripts.js') }}"></script>
<!-- end::Admin Scripts -->
