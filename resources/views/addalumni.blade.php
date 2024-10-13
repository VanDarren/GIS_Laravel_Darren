<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Input Data Alumni</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Input Alumni</li>
    </ol>
  </div>
    <style>
        #map { 
            height: 400px; 
            position: relative; 
        }
        #search-container {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            width: 300px;
        }
        #search {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        #search-result {
            background: white;
            width: 100%;
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
        }
        .search-item {
            padding: 10px;
            cursor: pointer;
        }
        .search-item:hover {
            background-color: #f1f1f1;
        }
    </style>
    <script src="https://openlayers.org/en/v6.14.1/build/ol.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Input Data Alumni</h6>
            </div>
            <div class="card-body">
                <form action="{{ url('aksiaddalumni') }}" method="post">
                @csrf 
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Jurusan:</label>
                        <select class="form-control" name="jurusan" id="jurusan" required>
                            <option value="RPL">RPL</option>
                            <option value="BDP">BDP</option>
                            <option value="AKL">AKL</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nis">NIS:</label>
                        <input type="text" class="form-control" name="nis" id="nis" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun_lulus">Tahun Lulus:</label>
                        <select class="form-control" name="tahun" id="tahun_lulus" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan:</label>
                        <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" required>
                    </div>
                    <div class="form-group">
                        <label for="perusahaan">Perusahaan:</label>
                        <input type="text" class="form-control" name="perusahaan" id="perusahaan" required>
                    </div>
                    
                    <!-- Map Container with Search Bar Overlay -->
                    <div id="map">
                        <div id="search-container">
                            <input type="text" id="search" placeholder="Masukkan nama lokasi atau alamat" oninput="searchLocation()">
                            <div id="search-result"></div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="lokasi">Lokasi:</label>
                        <input type="text" class="form-control" name="lokasi" id="lokasi" readonly required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="latitude">Latitude:</label>
                            <input type="text" class="form-control" name="latitude" id="latitude" readonly required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="longitude">Longitude:</label>
                            <input type="text" class="form-control" name="longitude" id="longitude" readonly required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([104.0242, -1.1342]), // Default center to Batam
                zoom: 13
            })
        });

        var markerLayer = new ol.layer.Vector({
            source: new ol.source.Vector()
        });
        map.addLayer(markerLayer);

        var currentMarker; // Variable to store the current marker

        // Check if geolocation is supported
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;

                // Set map view to user's location
                var userLocation = ol.proj.fromLonLat([lng, lat]);
                map.getView().setCenter(userLocation);
                map.getView().setZoom(16);

                // Add marker at user's location
                currentMarker = new ol.Feature({
                    geometry: new ol.geom.Point(userLocation)
                });

                markerLayer.getSource().addFeature(currentMarker);

                // Set coordinates to hidden input
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                document.getElementById('lokasi').value = lat + ", " + lng; // Set location name if needed
            }, function() {
                // Handle location access denied or other errors
                alert("Tidak dapat mendeteksi lokasi. Menampilkan peta Batam tanpa marker.");
            });
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }

        // Add click event to the map
        map.on('click', function(event) {
            // If a marker already exists, remove the old marker
            if (currentMarker) {
                markerLayer.getSource().removeFeature(currentMarker);
            }

            // Add new marker
            currentMarker = new ol.Feature({
                geometry: new ol.geom.Point(event.coordinate)
            });
            markerLayer.getSource().addFeature(currentMarker);

            // Set coordinates to hidden input
            var coord = ol.proj.toLonLat(event.coordinate);
            document.getElementById('latitude').value = coord[1];
            document.getElementById('longitude').value = coord[0];
            document.getElementById('lokasi').value = coord[1] + ", " + coord[0]; // Set only coordinates without 'LatLng'
        });

        // Function to search for a location with preview results
        function searchLocation() {
            var query = document.getElementById('search').value;
            if (!query) {
                document.getElementById('search-result').innerHTML = '';
                return;
            }

            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    var resultContainer = document.getElementById('search-result');
                    resultContainer.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(function(location) {
                            var item = document.createElement('div');
                            item.className = 'search-item';
                            item.textContent = location.display_name;
                            item.onclick = function() {
                                selectLocation(location);
                            };
                            resultContainer.appendChild(item);
                        });
                    } else {
                        resultContainer.innerHTML = '<div class="search-item">Lokasi tidak ditemukan.</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Terjadi kesalahan saat mencari lokasi.");
                });
        }

        // Function to select a location from the search results
        function selectLocation(location) {
            var lat = parseFloat(location.lat);
            var lon = parseFloat(location.lon);

            // Update the map view
            var selectedLocation = ol.proj.fromLonLat([lon, lat]);
            map.getView().setCenter(selectedLocation);
            map.getView().setZoom(16);

            // If a marker already exists, remove the old marker
            if (currentMarker) {
                markerLayer.getSource().removeFeature(currentMarker);
            }

            // Add new marker
            currentMarker = new ol.Feature({
                geometry: new ol.geom.Point(selectedLocation)
            });
            markerLayer.getSource().addFeature(currentMarker);

            // Set coordinates to hidden input
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;
            document.getElementById('lokasi').value = location.display_name; // Set location name

            // Clear search results
            document.getElementById('search-result').innerHTML = '';
        }

        // Populate year options and set default to current year
        document.addEventListener('DOMContentLoaded', function() {
            var yearSelect = document.getElementById('tahun_lulus');
            var currentYear = new Date().getFullYear();
            
            for (var year = 2000; year <= currentYear; year++) {
                var option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                if (year === currentYear) {
                    option.selected = true;
                }
                yearSelect.appendChild(option);
            }
        });
    </script>
</body>
</html>
