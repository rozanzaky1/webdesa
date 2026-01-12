<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sidesa - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset ('template/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset ('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom Olive Green Theme -->
    <style>
        :root {
            --primary: #4A7C2C;
            --primary-dark: #355719;
            --primary-light: #5a9438;
        }

        /* Override Bootstrap Primary Colors */
        .bg-gradient-primary {
            background-color: #4A7C2C;
            background-image: linear-gradient(180deg, #4A7C2C 10%, #355719 100%);
            background-size: cover;
        }

        .bg-primary {
            background-color: #4A7C2C !important;
        }

        .text-primary {
            color: #4A7C2C !important;
        }

        .btn-primary {
            background-color: #4A7C2C;
            border-color: #4A7C2C;
        }

        .btn-primary:hover {
            background-color: #355719;
            border-color: #2a4513;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4A7C2C !important;
        }

        .sidebar .nav-item.active .nav-link {
            color: #ffffff !important;
        }

        a {
            color: #4A7C2C;
        }

        a:hover {
            color: #355719;
        }

        /* Elegant Sidebar Animations */
        .sidebar .nav-link {
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            padding-left: 1.2rem;
            transform: translateX(3px);
        }

        .sidebar .nav-item.active .nav-link {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.15) 0%, transparent 100%);
            border-left: 3px solid #ffffff;
            font-weight: 600;
            color: #ffffff !important;
        }

        .sidebar .nav-link i {
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.15);
        }

        .sidebar .collapse-item {
            transition: all 0.25s ease;
            position: relative;
            color: #5a5c69 !important;
            font-size: 0.85rem;
        }

        .sidebar .collapse-item:hover {
            background-color: rgba(74, 124, 44, 0.08);
            padding-left: 1.8rem;
            color: #4A7C2C !important;
        }

        .sidebar .collapse-item.active {
            background-color: rgba(74, 124, 44, 0.15);
            color: #4A7C2C !important;
            font-weight: 600;
            border-left: 2px solid #4A7C2C;
        }

        .sidebar .collapse-inner {
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            transition: all 0.3s ease;
        }

        .sidebar-brand:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
    </style>

    @stack('styles')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
       @include('layouts.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
               @include('layouts.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                        @yield('content')
                    
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
           @include('layouts.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Logout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah Anda yakin ingin keluar dari sesi ini?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset ('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset ('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset ('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset ('template/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset ('template/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset ('template/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset ('template/js/demo/chart-pie-demo.js') }}"></script>

    
</body>

</html>