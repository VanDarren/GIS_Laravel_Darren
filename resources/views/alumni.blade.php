
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Alumni</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">View Alumni</li>
    </ol>
  </div>
    <style>
        .container {
            display: flex;
            width: 100%;
        }

        #map {
            flex-grow: 2; /* Bigger map area */
            height: 600px; /* Increased height of the map */
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .card {
            flex-grow: 1;
            width: 25%; /* Width of card */
            max-width: 400px; /* Adjusted max width of card */
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 5px; /* Reduced padding */
            margin-left: 20px;
            font-size: 0.8em; /* Smaller font size */
        }

        table {
            width: 100%;
            font-size: 0.8em; /* Smaller font size */
        }

        th, td {
            padding: 3px; /* Reduced padding */
            text-align: left;
        }

        .btn-route {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0; /* Remove padding */
        }

        .btn-route i {
            font-size: 1.2em; /* Increase icon size */
            color: #007bff; /* Icon color */
        }

        /* New Styles for the filter */
        .filter-container {
            margin-bottom: 10px;
        }

        /* Styles for the select element */
        #jurusanFilter {
            width: 150px; /* Width of the select element */
            padding: 5px; /* Reduce padding */
            font-size: 0.8em; /* Smaller font size */
        }
    </style>
    <link rel="stylesheet" href="https://openlayers.org/en/latest/css/ol.css" />
    <script src="https://openlayers.org/en/latest/build/ol.js"></script>
</head>
<body>

<div class="container">
    <div id="map"></div>

    <div class="card">
        <h6 class="m-0 font-weight-bold text-primary">Data Alumni</h6>

        <div class="filter-container">
            <label for="jurusanFilter">Filter berdasarkan Jurusan:</label>
            <select id="jurusanFilter" class="select2-single form-control" onchange="filterJurusan()">
                <option value="all">Semua</option>
                <option value="RPL">RPL</option>
                <option value="BDP">BDP</option>
                <option value="AKL">AKL</option>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table align-items-center table-flush" id="alumniTable">
                <thead class="thead-light">
                    <tr>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($darren as $alumni): ?>
                    <tr class="alumni-row" data-jurusan="<?= $alumni->jurusan; ?>">
                        <td><?= $alumni->nama_alumni; ?></td>
                        <td><?= $alumni->jurusan; ?></td>
                        <td>
                            <button class="btn-route" onclick="toggleRoute(<?= $alumni->latitude ?>, <?= $alumni->longitude ?>, this)">
                                <i class="fas fa-route"></i> <!-- Font Awesome route icon -->
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Font Awesome Kit -->
<script>
let map;
let currentRouteLayer = null;
let currentButton = null;
let currentMarkersLayer = []; // Store the markers layers as an array

window.onload = function() {
    initMainMap(); // Initialize the main map on page load
}

function initMainMap() {
    // Cek apakah geolocation tersedia
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                // Ambil koordinat latitude dan longitude pengguna
                const userLatitude = position.coords.latitude;
                const userLongitude = position.coords.longitude;

                // Inisialisasi peta dengan lokasi pengguna
                map = new ol.Map({
                    target: 'map',
                    layers: [
                        new ol.layer.Tile({
                            source: new ol.source.OSM()
                        })
                    ],
                    view: new ol.View({
                        center: ol.proj.fromLonLat([userLongitude, userLatitude]),
                        zoom: 15 // Zoom sesuai dengan level yang diinginkan
                    })
                });
            },
            function(error) {
                console.error("Unable to retrieve your location. Using default location:", error.message);
                // Jika gagal mendapatkan lokasi, gunakan lokasi default
                setDefaultMap();
            },
            {
                enableHighAccuracy: true, // Aktifkan akurasi tinggi
                timeout: 5000, // Timeout 5 detik
                maximumAge: 0 // Jangan simpan cache lokasi lama
            }
        );
    } else {
        // Jika geolocation tidak didukung, gunakan lokasi default
        console.error("Geolocation is not supported by this browser. Using default location.");
        setDefaultMap();
    }
}

function setDefaultMap() {
    // Inisialisasi peta dengan lokasi default jika geolocation gagal atau tidak didukung
    map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([104.01554411098573, 1.1234132597282334]), // Koordinat default
            zoom: 15
        })
    });
}


function showRoute(start, end, mapToUse) {
    const apiKey = '5b3ce3597851110001cf62483e5780a48c424b1bb6c12069d04a7205'; // Ganti dengan API key Anda
    const url = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${start[1]},${start[0]}&end=${end[1]},${end[0]}`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.features && data.features.length > 0) {
                const routeCoords = data.features[0].geometry.coordinates.map(coord => ol.proj.fromLonLat([coord[0], coord[1]]));

                const routeFeature = new ol.Feature({
                    geometry: new ol.geom.LineString(routeCoords)
                });

                const routeSource = new ol.source.Vector({
                    features: [routeFeature]
                });

                // Hapus layer rute sebelumnya jika ada
                if (currentRouteLayer) {
                    mapToUse.removeLayer(currentRouteLayer);
                }

                currentRouteLayer = new ol.layer.Vector({
                    source: routeSource,
                    style: new ol.style.Style({
                        stroke: new ol.style.Stroke({
                            color: 'red',
                            width: 4
                        })
                    })
                });

                mapToUse.addLayer(currentRouteLayer);

                const userMarkerCoords = ol.proj.fromLonLat([start[1], start[0]]);
                const alumniMarkerCoords = ol.proj.fromLonLat([end[1], end[0]]);
                
                // Hapus marker sebelumnya
                if (currentMarkersLayer.length > 0) {
                    currentMarkersLayer.forEach(layer => mapToUse.removeLayer(layer));
                    currentMarkersLayer = [];
                }

                // Tambahkan marker baru
                addMarker(userMarkerCoords, mapToUse, 'green'); // Marker lokasi pengguna
                addMarker(alumniMarkerCoords, mapToUse, 'blue'); // Marker lokasi alumni

                const userExtent = ol.extent.boundingExtent([userMarkerCoords]);
                const alumniExtent = ol.extent.boundingExtent([alumniMarkerCoords]);
                const routeExtent = routeSource.getExtent();

                const combinedExtent = ol.extent.extend(userExtent, alumniExtent);
                const finalExtent = ol.extent.extend(combinedExtent, routeExtent);

                mapToUse.getView().fit(finalExtent, { padding: [50, 50, 50, 50] });
            } else {
                console.error('No route found');
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

function addMarker(coords, mapToUse, color) {
    const marker = new ol.Feature({
        geometry: new ol.geom.Point(coords)
    });

    const markerStyle = new ol.style.Style({
        image: new ol.style.Circle({
            radius: 5,
            fill: new ol.style.Fill({ color: color }),
            stroke: new ol.style.Stroke({ color: 'white', width: 1 })
        })
    });

    marker.setStyle(markerStyle);

    const vectorSource = new ol.source.Vector({
        features: [marker]
    });

    const vectorLayer = new ol.layer.Vector({
        source: vectorSource
    });

    mapToUse.addLayer(vectorLayer);

    // Simpan layer marker ke array
    currentMarkersLayer.push(vectorLayer);
}

function toggleRoute(lat, lon, button) {
    if (!currentButton) {
        currentButton = button;
        navigator.geolocation.getCurrentPosition((position) => {
            const userLatitude = position.coords.latitude;
            const userLongitude = position.coords.longitude;
            const userLocation = [userLatitude, userLongitude];
            showRoute(userLocation, [lat, lon], map);
        });
    } else {
        if (currentButton === button) {
            if (currentRouteLayer) {
                map.removeLayer(currentRouteLayer);
                currentRouteLayer = null;
            }
            if (currentMarkersLayer.length > 0) {
                currentMarkersLayer.forEach(layer => map.removeLayer(layer));
                currentMarkersLayer = [];
            }
            currentButton = null;
        } else {
            if (currentRouteLayer) {
                map.removeLayer(currentRouteLayer);
                currentRouteLayer = null;
            }
            if (currentMarkersLayer.length > 0) {
                currentMarkersLayer.forEach(layer => map.removeLayer(layer));
                currentMarkersLayer = [];
            }
            currentButton = button;
            navigator.geolocation.getCurrentPosition((position) => {
                const userLocation = [position.coords.latitude, position.coords.longitude];
                showRoute(userLocation, [lat, lon], map);
            });
        }
    }
}
</script>

</body>

