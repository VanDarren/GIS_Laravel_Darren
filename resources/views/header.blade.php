<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ asset('img/' . htmlspecialchars($darren2->icontab)) }}" rel="icon">
    <title>{{ $darren2->namawebsite }}</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/ruang-admin.min.css') }}" rel="stylesheet">

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- OpenLayers CDN -->
    <script src="https://cdn.jsdelivr.net/npm/ol@v10.1.0/dist/ol.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v10.1.0/ol.css">

    <!-- Tambahkan Script untuk Auto Logout -->
    <script type="text/javascript">
        var idleTime = 0;
        var maxIdleTime = 5; // Waktu idle maksimal dalam menit sebelum logout otomatis

        // Fungsi untuk menginkrementasi waktu idle
        function timerIncrement() {
            idleTime++;
            if (idleTime >= maxIdleTime) { // Jika tidak ada aktivitas selama 5 menit
                alert("Anda telah otomatis logout karena tidak ada aktivitas selama 5 menit.");
                window.location.href = '{{ url("login") }}'; // Ganti dengan URL logout
            }
        }

        // Set interval untuk menginkrementasi idleTime setiap 1 menit (60000 ms)
        var idleInterval = setInterval(timerIncrement, 60000); // 1 menit

        // Fungsi untuk mereset timer idle saat ada aktivitas (mouse, keyboard, scroll)
        function resetTimer() {
            idleTime = 0;
        }

        // Event listener untuk aktivitas pengguna
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onkeypress = resetTimer;
        window.onscroll = resetTimer;
    </script>
</head>

