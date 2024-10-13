<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User Management</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
      <li class="breadcrumb-item">User Management</li>
      <li class="breadcrumb-item active" aria-current="page">User Table</li>
    </ol>
  </div>

  <div class="row">
    <div class="col-lg-12 mb-4">
      <!-- User Table -->
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">User Table</h6>
          <div>
            <a href="{{ url('adduser') }}" class="btn btn-sm btn-success">Add User</a>
            <!-- <a href="{{ url('restoreuser') }}" class="btn btn-sm btn-warning">Restore User</a>
            <a href="{{ url('redituser') }}" class="btn btn-sm btn-primary">Restore Edit User</a> -->
          </div>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th>Username</th>
                <!-- <th>Level</th>
                <th>Action</th> -->
              </tr>
            </thead>
            <tbody>
              @foreach ($darren as $user)
                <tr>
                  <td>{{ $user->username }}</td>
                
                  <td>
  <a href="{{ url('edituser/' . $user->id_user) }}">
    <button class="btn btn-sm btn-primary">Edit</button>
  </a>
  <a href="{{ url('deleteuser/' . $user->id_user) }}" onclick="return confirm('Are you sure you want to delete this user?')">
    <button class="btn btn-sm btn-danger">Delete</button>
  </a>
</td>

                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>
</div>