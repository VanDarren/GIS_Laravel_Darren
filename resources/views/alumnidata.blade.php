<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">View Data Alumni</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Data Alumni</li>
        </ol>
    </div>

    <style>
        #modalMap {
            width: 100%;
            height: 400px;
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Alumni</h6>
                        <!-- Restore Alumni Button -->
                        <div>
                            <a href="{{ url('restorealumni') }}" class="btn btn-sm btn-warning">Restore Alumni</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama Alumni</th>
                                    <th>Jurusan</th>
                                    <th>NIS</th>
                                    <th>Tahun Lulus</th>
                                    <th>Pekerjaan</th>
                                    <th>Perusahaan</th>
                                    <th>Lokasi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($darren as $alumni)
                                    <tr>
                                        <td>{{ $alumni->nama_alumni }}</td>
                                        <td>{{ $alumni->jurusan }}</td>
                                        <td>{{ $alumni->NIS }}</td>
                                        <td>{{ $alumni->tahun_lulus }}</td>
                                        <td>{{ $alumni->pekerjaan }}</td>
                                        <td>{{ $alumni->perusahaan }}</td>
                                        <td>
                                            <button class='btn btn-sm btn-primary' onclick='openModal({{ $alumni->latitude }}, {{ $alumni->longitude }})'>Lihat Lokasi</button>
                                        </td>
                                        <td>
                                            <a href="{{ url('deletealumni/' . $alumni->id_alumni) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this alumni?');">Delete</a>
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

    <!-- Modal -->
    <div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="zoomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="zoomModalLabel">Lokasi Alumni</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modalMap"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://openlayers.org/en/latest/build/ol.js"></script>

    <!-- Script for OpenLayers Map -->
    <script>
        let modalMap;

        function initModalMap(latitude, longitude) {
            const location = ol.proj.fromLonLat([longitude, latitude]);
            modalMap = new ol.Map({
                target: 'modalMap',
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    })
                ],
                view: new ol.View({
                    center: location,
                    zoom: 15
                })
            });

            // Add a marker for the alumni location
            const marker = new ol.Feature({
                geometry: new ol.geom.Point(location)
            });

            const vectorSource = new ol.source.Vector({
                features: [marker]
            });

            const markerLayer = new ol.layer.Vector({
                source: vectorSource,
                style: new ol.style.Style({
                    image: new ol.style.Icon({
                        src: 'https://openlayers.org/en/latest/examples/data/icon.png', // Icon marker pointer
                        scale: 0.7 // Icon size
                    })
                })
            });

            modalMap.addLayer(markerLayer);
        }

        function openModal(latitude, longitude) {
            initModalMap(latitude, longitude);
            $('#zoomModal').modal('show');
        }

        function closeModal() {
            $('#zoomModal').modal('hide');
            if (modalMap) {
                modalMap.setTarget(null); // Remove the map from modal when closed
                modalMap = null; // Reset modalMap
            }
        }
    </script>
</div>
