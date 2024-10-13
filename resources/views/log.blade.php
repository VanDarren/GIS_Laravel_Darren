<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Log Activity</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./">Home</a></li>
      <li class="breadcrumb-item">Logs</li>
      <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
    </ol>
  </div>

  <div class="row">
    <div class="col-lg-12 mb-4">
      <!-- Log Table -->
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Activity Log</h6>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th>User</th>
                <th>Activity</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($logs as $log) : ?>
                <tr>
                  <td><?= $log->username ?></td>
                  <td><?= $log->activity ?></td>
                  <td><?= date('Y-m-d H:i:s', strtotime($log->time)) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>
</div>
