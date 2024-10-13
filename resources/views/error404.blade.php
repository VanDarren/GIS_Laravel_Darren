<div class="container-fluid" id="container-wrapper" style="height: 100vh;">
  <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
    <div class="text-center">
      <img src="{{ asset('img/error.svg') }}" style="max-height: 100px;" class="mb-3">
      <h3 class="text-gray-800 font-weight-bold">Oopss!</h3>
      <p class="lead text-gray-800 mx-auto">404 Page Not Found</p>
      <a href="{{ url('dashboard') }}">&larr; Back to Dashboard</a> <!-- Pastikan Anda memiliki route dashboard -->
    </div>
  </div>
</div>