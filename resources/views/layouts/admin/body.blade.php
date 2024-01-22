<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Gestion des Etudiants</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ asset('assets/img/Blason_univ_Yaoundé_1.png') }}" rel="icon">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <style>
        .specifie_collapase {
            display: none;
        }
        .header {
    transition: all 0.5s;
    z-index: 997;
    height: 60px;
    box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.1);
    background-color: #232323;
    padding-left: 20px;
}
.header-nav .nav-profile {
    color: #fff;
}
.sidebar-nav .nav-link.collapsed {
    color: #232323;
    background: #fff;
}
.sidebar-nav .nav-link:hover {
    color: #ff8400;
    background: #f6f9ff;
}
.sidebar-nav .nav-content a:hover, .sidebar-nav .nav-content a.active {
    color: #ff8400;
}
.sidebar-nav .nav-link.collapsed i {
    color: #232323;
}
.sidebar-nav .nav-link {
    display: flex;
    align-items: center;
    font-size: 15px;
    font-weight: 600;
    color: #ff8400;
    transition: 0.3;
    background: #f6f9ff;
    padding: 10px 15px;
    border-radius: 4px;
}
.sidebar-nav .nav-content a.active i {
    background-color: #f6f9ff;
}
.sidebar-nav .nav-link i {
    font-size: 16px;
    margin-right: 10px;
    color: #232323;
}
.breadcrumb .active {
    color: #232323;
    font-weight: 600;
}
.dashboard .sales-card .card-icon {
    color: #008374;
    background: #f6f6fe;
}
.footer .copyright {
    text-align: center;
    color: #232323;
}
.pagetitle h1 {
    font-size: 24px;
    margin-bottom: 0;
    font-weight: 600;
    color: #ff8400;
}
.sidebar-nav .nav-content a {
    display: flex;
    align-items: center;
    font-size: 14px;
    font-weight: 600;
    color: #232323;
     /* #008374; */
    transition: 0.3;
    padding: 10px 0 10px 40px;
    transition: 0.3s;
}
.btn-success {
    --bs-btn-color: #fff;
    --bs-btn-bg: #008374;
    --bs-btn-border-color: #008374;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #008374;
    --bs-btn-hover-border-color: #008374;
    --bs-btn-focus-shadow-rgb: 60,153,110;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: #008374;
    --bs-btn-active-border-color: #008374;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #008374;
    --bs-btn-disabled-border-color: #008374;
}
.btn-info {
    --bs-btn-color: #000;
    --bs-btn-bg: #232323;
    --bs-btn-border-color: #232323;
    --bs-btn-hover-color: #000;
    --bs-btn-hover-bg: #232323;
    --bs-btn-hover-border-color: #232323;
    --bs-btn-focus-shadow-rgb: 11,172,204;
    --bs-btn-active-color: #000;
    --bs-btn-active-bg: #232323;
    --bs-btn-active-border-color: #232323;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #000;
    --bs-btn-disabled-bg: #232323;
    --bs-btn-disabled-border-color: #232323;
}

.card-title {
    padding: 20px 0 15px 0;
    font-size: 18px;
    font-weight: 500;
    color: #232323;
    font-family: "Poppins", sans-serif;
}
.back-to-top {
    position: fixed;
    visibility: hidden;
    opacity: 0;
    right: 15px;
    bottom: 15px;
    z-index: 99999;
    background: #008374;
    width: 40px;
    height: 40px;
    border-radius: 4px;
    transition: all 0.4s;
}

element.style {
}
.back-to-top i {
    font-size: 24px;
    color: #fff;
    line-height: 0;
}
*, ::after, ::before {
    box-sizing: border-box;
}
user agent stylesheet
i {
    font-style: italic;
}
.back-to-top:hover {
    background: #ff8400;
    color: #fff;
}
a:hover {
    color: #232323;
    text-decoration: none;
}
a:hover {
    color: #232323;
}
.nav-tabs-bordered .nav-link.active {
    background-color: #fff;
    color: #ff8400;
    border-bottom: 2px solid #ff8400;
}
.nav-tabs-bordered .nav-link {
    margin-bottom: -2px;
    border: none;
    color: #232323;
}
.back-to-top {
    position: fixed;
    visibility: hidden;
    opacity: 0;
    right: 15px;
    bottom: 15px;
    z-index: 99999;
    background: #008374;
    width: 40px;
    height: 40px;
    border-radius: 4px;
    transition: all 0.4s;
}
.sidebar-nav .nav-link:hover i {
    color: #232323;
}
element.style {
    background: #008374;
}
.nav {
    --bs-nav-link-padding-x: 1rem;
    --bs-nav-link-padding-y: 0.5rem;
    --bs-nav-link-font-weight: ;
    --bs-nav-link-color: var(--bs-link-color);
    --bs-nav-link-hover-color:#232323;
    --bs-nav-link-disabled-color: #6c757d;
    display: flex;
    flex-wrap: wrap;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}

    </style>
</head>

<body>
    @include('layouts.admin.header')
    @yield('content')
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Pub</span></strong> from <strong><span>Te-sea Incubator</span></strong>. All Rights Reserved
        </div>
    </footer>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    @yield('modals')

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="{{ asset('js/jquery.js') }}"></script>

    @yield('scripts')
</body>

</html>
