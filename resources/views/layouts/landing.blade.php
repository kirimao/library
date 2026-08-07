<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Perpustakaan YPA Yayasan Peduli Anak — Temukan ribuan buku pilihan untuk menumbuhkan semangat belajar dan kecintaan membaca anak-anak.">
        <meta name="robots" content="index, follow">
        <title>Perpustakaan YPA — Yayasan Peduli Anak</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logoypa.png') }}">

        {{-- Fonts: Bricolage Grotesque (display/headline) + Inter (body) --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,700;12..96,800;12..96,900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .font-display { font-family: 'Bricolage Grotesque', 'Inter', sans-serif; }

            /* Smooth fade-up transition without hiding elements */
            .animate-section {
                opacity: 1;
                transition: transform 0.4s ease-out, opacity 0.4s ease-out;
            }

        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const animateObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            animateObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.08 });

                document.querySelectorAll('.animate-section').forEach(function (el) {
                    animateObserver.observe(el);
                });

                // Count-up numbers animation when visible
                function animateCountUp(el, target, duration = 1200) {
                    let start = 0;
                    let startTime = null;
                    function step(timestamp) {
                        if (!startTime) startTime = timestamp;
                        let progress = Math.min((timestamp - startTime) / duration, 1);
                        let easeOut = 1 - Math.pow(1 - progress, 3);
                        let current = Math.floor(easeOut * target);
                        el.textContent = current.toLocaleString('id-ID');
                        if (progress < 1) {
                            requestAnimationFrame(step);
                        } else {
                            el.textContent = target.toLocaleString('id-ID');
                        }
                    }
                    requestAnimationFrame(step);
                }

                const countObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            const target = parseInt(entry.target.getAttribute('data-target') || '0', 10);
                            animateCountUp(entry.target, target);
                            countObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.2 });

                document.querySelectorAll('.stat-count').forEach(function (el) {
                    countObserver.observe(el);
                });
            });
        </script>


    </head>
    <body class="antialiased bg-slate-50" style="font-family: 'Inter', sans-serif;">
        {{ $slot }}
        @livewireScripts
    </body>
</html>
