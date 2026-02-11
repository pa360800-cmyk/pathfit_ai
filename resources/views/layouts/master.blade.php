<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="theme-color" content="#10b981" />

    <title>@yield('title')</title>

    <!-- Google Font: Inter -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" />
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/fontawesome-free-V6/css/all.min.css') }}" />
    
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/toastr/toastr.min.css') }}" />
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" />
    
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('templates/dist/css/adminlte.min.css') }}" />
    
    <!-- DataTables  -->
    <link rel="stylesheet" href="{{ asset('templates/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templates/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('templates/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
    
    <!-- Logo  -->
    <link rel="shortcut icon" type="" href="{{ asset('templates/dist/img/cpsulogo.jpg') }}" />
    
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        :root {
            --primary: #b6bebc;
            --primary-dark: #eaf1ef;
            --bg-light: #ffffff;
            --bg-lighter: #fafafa;
            --bg-lightest: #f5f5f5;
            --text: #000000;
            --text-light: #000000;
            --text-lighter: #000000;
            --hover-gray: #a7b4b4;
            --border: #e5e7eb;
            --border-light: black;
            --shadow-sm: rgba(0, 0, 0, 0.03);
            --shadow-md: rgba(0, 0, 0, 0.05);
        }
       p{
        color: black;
       }
        body {
            background: var(--bg-lighter);
            color: var(--text);
            transition: all 0.3s ease;
        }

        /* ========== NAVBAR ========== */
        .main-header {
            background: var(--bg-light) !important;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 2px var(--shadow-sm);
            height: 60px;
            padding: 0 1.5rem;
            transition: all 0.3s ease;
        }

        .main-header .navbar-nav {
            align-items: center;
        }

        .main-header .nav-link {
            color: var(--text) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .main-header .nav-link:hover {
            background: var(--hover-gray);
            color: var(--text) !important;
        }

        .main-header .nav-link i {
            font-size: 1rem;
            color: var(--text) !important;
        }

        .main-header .nav-link:hover i {
            color: var(--text) !important;
        }

        .main-header .nav-link b {
            font-weight: 600;
        }

        /* Menu Button */
        .main-header .nav-link[data-widget="pushmenu"] {
            font-size: 1.125rem;
            background-color: rgb(237, 245, 241);
        }

        /* Sign Out Button */
        .main-header .nav-link[href*="logout"] {
            background: var(--bg-lightest);
            border: 1px solid var(--border);
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .main-header .nav-link[href*="logout"]:hover {
            background: var(--hover-gray);
            border-color: var(--border);
            color: var(--text) !important;
        }

        .main-header .nav-link[href*="logout"]:hover i,
        .main-header .nav-link[href*="logout"]:hover b {
            color: var(--text) !important;
        }

        /* ========== SIDEBAR ========== */
        .main-sidebar {
            background: var(--bg-light);
            border-right: 1px solid var(--border);
            box-shadow: 1px 0 3px var(--shadow-sm);
        }

        .brand-link {
            background: var(--bg-light) !important;
            border-bottom: 1px solid var(--border);
            height: 60px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .brand-link:hover {
            background: var(--bg-lightest) !important;
        }

        .brand-image {
            width: 40px !important;
            height: 40px !important;
            margin: 0 !important;
            box-shadow: 0 2px 4px var(--shadow-sm);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .brand-link:hover .brand-image {
            transform: scale(1.05);
            border-color: var(--primary);
        }

        /* ========== USER PANEL ========== */
        .sidebar {
            padding-top: 1.25rem;
            background: var(--bg-light);
        }

        .user-panel {
            padding: 1.25rem 1rem !important;
            margin-bottom: 1rem;
            background: var(--bg-lighter);
            border-radius: 12px;
            margin: 0 1rem 1.25rem 1rem;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .user-panel:hover {
            background: white;
            box-shadow: 0 2px 8px var(--shadow-md);
        }

        .user-panel .image img {
            width: 70px !important;
            height: 70px !important;
            border-radius: 50%;
            border: 2px solid var(--border);
            box-shadow: 0 2px 6px var(--shadow-sm);
            transition: all 0.3s ease;
            margin-top: 0 !important;
        }

        .user-panel .image img:hover {
            transform: scale(1.05);
            border-color: var(--primary);
        }

        .user-panel .info a {
            font-weight: 600 !important;
            font-size: 0.9rem !important;
            color: var(--text) !important;
            transition: color 0.3s ease;
        }

        .user-panel .info a:hover {
            color: var(--primary) !important;
        }

        /* ========== SIDEBAR SEARCH ========== */
        .sidebar-search {
            padding: 0 1rem;
            margin-bottom: 1rem;
        }

        .sidebar-search .form-control {
            border-radius: 8px;
            background: var(--bg-lighter);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 0.5rem 0.875rem;
            font-size: 0.8125rem;
            transition: all 0.3s ease;
        }

        .sidebar-search .form-control:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08);
            outline: none;
        }

        .sidebar-search .form-control::placeholder {
            color: var(--text);
            opacity: 0.5;
        }

        .sidebar-search .btn {
            background: var(--bg-lighter);
            color: var(--text);
            border-radius: 8px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .sidebar-search .btn:hover {
            background: var(--hover-gray);
            color: var(--text);
            border-color: var(--border);
        }

        /* ========== SIDEBAR MENU ========== */
        .nav-sidebar {
            padding: 0 0.75rem;
        }

        .nav-sidebar .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-sidebar .nav-link {
            border-radius: 8px;
            padding: 0.625rem 0.875rem;
            color: var(--text);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            background: transparent;
            font-size: 0.875rem;
        }

        .nav-sidebar .nav-link:hover {
            background: var(--hover-gray);
            color: var(--text);
        }

        .nav-sidebar .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.2);
        }

        .nav-sidebar .nav-link i {
            color: var(--text);
            margin-right: 0.75rem;
            font-size: 1rem;
            width: 18px;
            transition: all 0.3s ease;
        }

        .nav-sidebar .nav-link:hover i {
            color: var(--text);
        }

        .nav-sidebar .nav-link.active i {
            color: white;
        }

        .nav-sidebar .nav-link p {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* ========== CONTENT WRAPPER ========== */
        .content-wrapper {
            background: var(--bg-lighter);
            padding: 1.5rem;
        }

        /* ========== DATATABLES ========== */
        table.dataTable {
            background: var(--bg-light);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        table.dataTable thead th {
            background: var(--bg-lightest);
            color: var(--text);
            font-weight: 600;
            border-bottom: 1px solid var(--border);
            padding: 0.875rem 1rem;
            font-size: 0.8125rem;
        }

        table.dataTable tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-light);
            color: var(--text);
            font-size: 0.875rem;
        }

        table.dataTable tbody tr:hover {
            background: var(--hover-gray);
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.375rem 0.625rem;
            transition: all 0.3s ease;
            color: var(--text);
            background: var(--bg-light);
            font-size: 0.875rem;
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.08);
            outline: none;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            color: var(--text);
            font-size: 0.875rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.625rem;
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid var(--border);
            color: var(--text) !important;
            background: var(--bg-light);
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary) !important;
            color: white !important;
            border-color: var(--primary);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--primary) !important;
            color: white !important;
            border-color: var(--primary);
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: var(--bg-light) !important;
            color: var(--text) !important;
            border-color: var(--border) !important;
        }

        /* ========== CUSTOM SCROLLBAR ========== */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--text-lighter);
        }

        /* ========== TOASTR CUSTOM ========== */
        .toast-success {
            background-color: var(--primary) !important;
        }

        .toast-error {
            background-color: #ef4444 !important;
        }

        /* ========== CARDS & BOXES ========== */
        .card {
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px var(--shadow-sm);
            border-radius: 8px;
            background: var(--bg-light);
        }

        .card-header {
            background: var(--bg-lightest);
            color: var(--text);
            border-bottom: 1px solid var(--border);
            font-weight: 600;
        }

        .btn-primary {
            background: var(--primary);
            border: 1px solid var(--primary);
            color: white;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.2);
        }

        .btn {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .main-header {
                padding: 0 1rem;
            }

            .user-panel .image img {
                width: 60px !important;
                height: 60px !important;
            }
        }
     .image{
      width: 100%;
     }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="button">
                        <i class="fas fa-power-off"></i>
                        <b>Sign Out</b>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="./" class="brand-link">
                <img
                    src="{{ asset('templates/dist/img/cpsulogo.jpg') }}"
                    alt="Logo"
                    class="brand-image img-circle elevation-3"
                />
            </a>

            <div class="sidebar">
                @php
                    $user = Auth::user();
                @endphp
                <center>
                    <div class="user-panel">
                        <div class="">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" class="" alt="User Image" style="width: 100px; height: 100px; object-fit: cover; ">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" class="" alt="Default User Image" style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                        </div>
                    </div>
                </center>

                <div class="form-inline sidebar-search">
                    <div class="input-group" data-widget="sidebar-search">
                        <input
                            class="form-control form-control-sidebar"
                            type="search"
                            placeholder="Search menu..."
                            aria-label="Search"
                        />
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                @include('menu.sidebar')
            </div>
        </aside>

        <!-- Content Wrapper -->
        @yield("body")

        @yield("content")
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('styles')
    @stack('scripts')
        @yield("scripts")

           



        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <div class="p-3">
                <h5>Settings</h5>
                <p>Control panel content</p>
            </div>
        </aside>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('templates/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('templates/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('templates/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        @if(Session::has('error'))
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000,
        };
        toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('success'))
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
            timeOut: 3000,
        };
        toastr.success("{{ Session::get('success') }}");
        @endif

        $(function () {
            $("#example1")
                .DataTable({
                    responsive: true,
                    lengthChange: true,
                    autoWidth: false,
                })
                .buttons()
                .container()
                .appendTo("#example1_wrapper .col-md-6:eq(0)");
        });
    </script>
</body>

</html>