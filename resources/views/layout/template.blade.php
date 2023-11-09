<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Nur Residence</title>
  <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Bootstrap JS (including Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/search.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" type="text/css">


  {{--
  <link rel="stylesheet" href="{{ asset('css/all.min.css') }}"> --}}
</head>

<body>
  <nav class="sidebar">
    <h5 class="hide" style="display: flex; align-items: center; justify-content: center;" id="admin">
      <!-- Second icon -->
      ADMIN
      <!-- Text -->
    </h5>
    <div class="sidebar-top">
      <span class="shrink-btn">
        <i class='bi bi-chevron-left'></i>
      </span>
    </div>
    <hr class="my-2">
    <div class="sidebar-links">
      <ul>
        <div class="active-tab"></div>
        <li class="tooltip-element" data-tooltip="0">
          <a href="/dashboard" data-active="0">
            <div class="icon">
              <i class='bi bi-speedometer2'></i>
              <i class='bi bi-speedometer2'></i>
            </div>
            <span class="link hide">Dashboard</span>
          </a>
        </li>
        @if (auth()->user()->hasRole('admin'))
        <li class="tooltip-element" data-tooltip="1">
          <a href="/lokasi_kos" data-active="1">
            <div class="icon">
              <i class='bi bi-house-door'></i>
              <i class='bi bi-house-door'></i>
            </div>
            <span class="link hide">Data Lokasi</span>
          </a>
        </li>
        @endif

        <!-- Sidebar "Data Master" -->
        <li class="tooltip-element" data-tooltip="7">
          <a href="#" data-toggle="collapse" data-target="#dataMasterSubMenu" aria-expanded="false" data-active="7">
            <div class="icon">
              <i class='bi bi-database'></i>
              <i class='bi bi-database'></i>
            </div>
            <span class="link hide">Data Master</span>
          </a>
          <!-- Subbar "Data Fasilitas" -->
          <ul class="subbar collapse" id="dataMasterSubMenu">
            <li class="tooltip-element" data-tooltip="8">
              <a href="/data-fasilitas" data-active="8">
                <div class="icon">
                  <i class='bi bi-gear'></i>
                  <i class='bi bi-gear'></i>
                </div>
                <span class="link hide">Data Fasilitas</span>
              </a>
            </li>
            <!-- Subbar "Data Tipe" -->
            <li class="tooltip-element" data-tooltip="9">
              <a href="/data-tipe" data-active="9">
                <div class="icon">
                  <i class='bi bi-list'></i>
                  <i class='bi bi-list'></i>
                </div>
                <span class="link hide">Data Tipe</span>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="tooltip-element" data-tooltip="2">
          <a href="/kamar" data-active="2">
            <div class="icon">
              <i class='bi bi-door-closed'></i>
              <i class='bi bi-door-closed'></i>
            </div>
            <span class="link hide">Data Kamar</span>
          </a>
        </li>

        <li class="tooltip-element" data-tooltip="3">
          <a href="/penyewa" data-active="3">
            <div class="icon">
              <i class='bi bi-person'></i>
              <i class='bi bi-person'></i>
            </div>
            <span class="link hide" style="white-space: nowrap;">Data Penyewa</span>
          </a>
        </li>
        @if (auth()->user()->hasRole('admin'))
        <li class="tooltip-element" data-tooltip="4">
          <a href="/transaksi" data-active="4">
            <div class="icon">
              <i class='bi bi-file-earmark-text'></i>
              <i class='bi bi-file-earmark-text'></i>
            </div>
            <span class="link hide" style="white-space: nowrap;">Data Transaksi</span>
          </a>
        </li>
        @endif
        @if (auth()->user()->hasRole('admin'))
        <li class="tooltip-element" data-tooltip="5">
          <a href="/manage-users" data-active="5">
            <div class="icon">
              <i class='bi bi-person-plus'></i>
              <i class='bi bi-person-plus'></i>
            </div>
            <span class="link hide">Manage Users</span>
          </a>
        </li>
        @endif
        <li class="tooltip-element" data-tooltip="6">
          <a href="/logout" data-active="6">
            <div class="icon">
              <i class='bi bi-box-arrow-right'></i>
              <i class='bi bi-box-arrow-right'></i>
            </div>
            <span class="link hide">Log Out</span>
          </a>
        </li>
        <div class="tooltip">
          <span class="show">Dashboard</span>
          <span>Data Kamar</span>
          <span>Data Lokasi</span>
          <span>Data Penyewa</span>
          <span>Data Transaksi</span>
          <span>Data Data User</span>
          <span>Log Out</span>
        </div>
      </ul>
    </div>
  </nav>
  {{-- --}}
  <script src="{{ asset('javascript/sidebar.js') }}"></script>
  <script src="{{ asset('javascript/subMenuSidebar.js') }}"></script>

  <main>
    <div class="loading-overlay">
      <div class="loading-spinner"></div>
    </div>
    <div class="centered-content">
      @yield('content')
    </div>
  </main>



</body>

</html>
<script src="{{ asset('javascript/autoHarga.js') }}"></script>