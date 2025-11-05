<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Redirecting...</title>
    <script>
        window.onload = function() {
            var intentUrl = "{{ $intent }}";
            // Coba buka aplikasi
            window.location.href = intentUrl;

            // Opsional: fallback ke Play Store kalau gagal (setelah beberapa detik)
            setTimeout(function() {
                window.location.href = "https://play.google.com/store/apps/details?id=com.bsndev.quranqita";
            }, 2000);
        };
    </script>
</head>

<body>
    <p>Membuka aplikasi Quran Qita...</p>
</body>

</html>
