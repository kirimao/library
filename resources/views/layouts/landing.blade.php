<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Perpustakaan YPA Yayasan Peduli Anak — Temukan ribuan buku untuk menumbuhkan semangat belajar anak-anak.">
        <title>Perpustakaan YPA — Yayasan Peduli Anak</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logoypa.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased" style="font-family: 'Inter', sans-serif;">
        {{ $slot }}
    </body>
</html>
