<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link type="image/x-icon" href="{{ asset('/img/logo.png') }}" rel="icon">
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts External -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery-chained.min.js') }}"></script>
    <script src="{{ asset('js/notify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Charts -->
    <script src="{{ asset('js/apexcharts.js') }}"></script>

    <!-- AOS -->
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">

    <!-- DataTables -->
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Custom Style -->
    <link href="{{ asset('css/webv2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  </head>

  <body>
    <div class="wrapper">
      <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
          <a class="sidebar-brand text-center" href="#">
            <span class="align-middle" style="font-size: 1.7rem">9-BOX TALENT</span>
          </a>
          <ul class="sidebar-nav">
            <li class="sidebar-header pt-0">
              Menu Utama
            </li>
            <li class="sidebar-item {{ (request()->is('home')) ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('home') }}">
                <i class="bi-house-door-fill"></i> <span class="align-middle">Beranda</span>
              </a>
            </li>
            <li class="sidebar-item {{ (request()->is('evaluation*')) ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('evaluation') }}">
                <i class="bi-trophy-fill"></i> <span class="align-middle">Penilaian Pegawai</span>
              </a>
            </li>
            <li class="sidebar-item {{ (request()->is('performance*')) || (request()->is('competency*')) ? 'active' : '' }}">
              <a data-bs-target="#history" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                <i class="bi-clock-history"></i> <span class="align-middle">Riwayat Penilaian</span>
                <span class="sidebar-badge"><i class="bi-caret-down-fill"></i></span>
              </a>
              <ul id="history" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                  <a href="{{ route('performance') }}" class="sidebar-link"><span class="ms-4">&nbsp;&nbsp;Performa</span></a>
                </li>
                <li class="sidebar-item">
                  <a href="{{ route('competency') }}" class="sidebar-link"><span class="ms-4">&nbsp;&nbsp;Kompetensi</span></a>
                </li>
              </ul>
            </li>

            <li class="sidebar-header">
              Pengaturan
            </li>
            <li class="sidebar-item {{ (request()->is('employee*')) || (request()->is('position*')) ? 'active' : '' }}">
              <a data-bs-target="#master" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                <i class="bi-clipboard-data-fill"></i> <span class="align-middle">Data Master</span>
                <span class="sidebar-badge"><i class="bi-caret-down-fill"></i></span>
              </a>
              <ul id="master" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                  <a href="{{ route('employee') }}" class="sidebar-link"><span class="ms-4">&nbsp;&nbsp;Pegawai</span></a>
                </li>
                <li class="sidebar-item">
                  <a href="{{ route('position') }}" class="sidebar-link"><span class="ms-4">&nbsp;&nbsp;Jabatan</span></a>
                </li>
                <li class="sidebar-item">
                  <a href="{{ route('competency-item') }}" class="sidebar-link"><span class="ms-4">&nbsp;&nbsp;Item Kompetensi</span></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-item {{ (request()->is('user*')) ? 'active' : '' }}">
              <a class="sidebar-link" href="{{ route('user') }}">
                <i class="bi-people-fill"></i> <span class="align-middle">Manajemen User</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <div class="main">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
          <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
          </a>
          <div class="navbar-collapse collapse">
            <ul class="navbar-nav navbar-align">
              <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                  <i class="align-middle" data-feather="settings"></i>
                </a>
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                  <span class="btn-icon" data-feather="user-check"></span>&nbsp;
                  <span class="text-dark">Administrator</span>&nbsp;
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item" href="#">
                    <i class="align-middle me-1 btn-icon" data-feather="user"></i> Profil Pengguna
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:void(0)" onclick="aboutApp()">
                    <i class="align-middle me-1 btn-icon" data-feather="info"></i> Tentang Aplikasi
                  </a>
                  <a class="dropdown-item" href="#">
                    <i class="align-middle me-1 btn-icon" data-feather="help-circle"></i> Bantuan
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="bi-box-arrow-right"></i>&nbsp; {{ __('Keluar') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </div>
        </nav>

        <main class="content p-3">
          <div class="row">
            @yield('content')
          </div>
        </main>

      </div>
    </div>

    <div class="modal fade" id="changePassword" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Penggantian Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <form id="form_change_password">
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-danger" role="alert">
                    - Password minimal 8 karakter.<br>
                    - Disarankan menggunakan kombinasi huruf dan angka.
                  </div>
                </div>
                <div class="col-md-12 p-3">
                  <div class="row">
                    <label class="col-md-5 col-form-label">Password Baru <span class="text-danger">*</span></label>
                    <div class="col-md-7">
                      <input type="password" name="password" class="form-control" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 p-3">
                  <div class="row">
                    <label class="col-md-5 col-form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <div class="col-md-7">
                      <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary" onclick="return changePassword()">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    @yield('footer-script')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/fnPagingInfo.js') }}"></script>

    <!-- AOS -->
    <script src="{{ asset('js/aos.js') }}"></script>

    <script>
    /* ============================ */
    /* AOS Config
    /* ============================ */
    
    AOS.init({
      delay: 100,
      duration: 1000,
    });
    
    /* ============================ */
    /* Disable Autocomplete
    /* ============================ */

    $(".form-control").attr("autocomplete", "off");
    
    /* ============================ */
    /* Number Only
    /* ============================ */
    
    $('.number').keypress(function(event) {
      var charCode = event.keyCode

      if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
        return false;
      return true;
    });
    
    /* ============================ */
    /* Notify Config
    /* ============================ */
    
    $.notify.defaults({
      autoHideDelay: 5000
    });
    
    /* ============================ */
    /* Change Password
    /* ============================ */

    function changePassword() {
      let form        = document.querySelector('#form_change_password');
      let data        = new FormData(form);
      let url         = "{{ route('change-password') }}";
      let csrf_token  = document.getElementsByTagName("META")[2].content;
      
      const options = {
        headers: {'X-CSRF-TOKEN': csrf_token}
      };
    
      axios.post(url, data, options)
      .then((response) => {
        if (response.data.success == true)
        {
          $("#changePassword").modal('hide');
    
          Swal.fire({
            icon: 'success',
            title: 'BERHASIL !',
            text: 'Password Anda Berhasil Diubah !',
            showConfirmButton: true
          });
        }
      }, (error) => {
        $.each(error.response.data.errors, function(index, value) {
          Swal.fire({
            icon: 'error',
            text: value,
            showConfirmButton: true
          });
        });
      });
    }
  </script>
    
  </body>
</html>