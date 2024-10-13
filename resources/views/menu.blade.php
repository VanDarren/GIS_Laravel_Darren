<style>
/* Sidebar */
#accordionSidebar {
    position: fixed; /* Membuat sidebar tetap */
    top: 0;
    left: 0;
    height: 100vh; /* Mengatur tinggi sidebar agar sesuai dengan tinggi viewport */
    width: 250px; /* Sesuaikan lebar sesuai kebutuhan */
    overflow-y: auto; /* Menambahkan scroll jika diperlukan */
    z-index: 1000; /* Pastikan sidebar berada di atas konten */
}

/* Konten Wrapper */
#content-wrapper {
  
    margin-left: 224px; /* Sesuaikan margin dengan lebar sidebar */
}

</style>
<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
    <div class="sidebar-brand-icon">
    <img src="{{ asset('img/' . htmlspecialchars($darren2->iconmenu)) }}" alt="IconMenu" class="logo-dashboard">
    </div>
  </a>
  <hr class="sidebar-divider my-0">

  <!-- Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="dashboard">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <hr class="sidebar-divider">

  <!-- Alumni Menu -->
  <li class="nav-item">
    <a class="nav-link" href="addalumni">
      <i class="fas fa-fw fa-user-plus"></i>
      <span>Input Alumni</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="alumni">
      <i class="fas fa-fw fa-users"></i>
      <span>View Alumni</span>
    </a>
  </li>

  <!-- Teacher Menu -->
  <li class="nav-item">
    <a class="nav-link" href="alumnidata">
      <i class="fas fa-fw fa-user-tie"></i>
      <span>View Alumni Data</span>
    </a>
  </li>


   <li class="nav-item">
        <a class="nav-link" href="user">
            <i class="fas fa-fw fa-user"></i>
            <span>User</span>
        </a>
    </li>



    <li class="nav-item">
        <a class="nav-link" href="log">
            <i class="fas fa-fw fa-list"></i>
            <span>Log Activity</span>
        </a>
    </li>

    <!-- New Settings Menu -->
    <li class="nav-item">
        <a class="nav-link" href="setting">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span>
        </a>
    </li>


 
  <hr class="sidebar-divider">
  <div class="version" id="version-ruangadmin"></div>
</ul>
<!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
             
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
         
               
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-warning badge-counter">2</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
               
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-tasks fa-fw"></i>
                <span class="badge badge-success badge-counter">3</span>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
               
              
                <a class="dropdown-item text-center small text-gray-500" href="#">View All Taks</a>
              </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="{{ asset('img/boy.png') }}" style="max-width: 60px">

                <span class="ml-2 d-none d-lg-inline text-white small"><?= session()->get('username') ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
                
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          

        

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="{{ url('logout') }}" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

        </div>
     
      </div>