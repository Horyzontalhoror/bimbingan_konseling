<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMP Negeri 1 Solor Barat - Beranda</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom CSS for better background image handling and overlays */
        #hero-background {
            background-image: url('{{ asset('bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Overlay gelap yang lebih halus */
        #hero-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 50%, rgba(0, 0, 0, 0.7) 100%);
        }

        /* Custom styles for the map iframe to make it truly responsive */
        #map-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            /* Tambahkan shadow pada peta */
        }

        #map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Ensure dark mode text visibility for all elements */
        .dark .text-gray-800 {
            color: #e2e8f0;
            /* Light gray for dark mode headings */
        }

        .dark .text-gray-900 {
            color: #f8fafc;
            /* White for dark mode main text */
        }

        .dark .text-gray-700 {
            color: #cbd5e0;
            /* Lighter gray for dark mode paragraphs */
        }

        /* Hero text animation delays */
        .animate-fade-in-up-1 {
            animation-delay: 0.2s;
        }

        .animate-fade-in-up-2 {
            animation-delay: 0.4s;
        }

        .animate-fade-in-up-3 {
            animation-delay: 0.6s;
        }
    </style>
</head>

<body
    class="antialiased font-sans bg-gray-50 dark:bg-darkGray text-gray-900 dark:text-gray-100 min-h-screen flex flex-col">

    <header class="bg-white dark:bg-zinc-800 shadow-lg py-4 sticky top-0 z-50 transition-all duration-300 ease-in-out">
        <div class="container mx-auto px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('favicon/favicon.svg') }}" alt="Logo SMPN 1 Solor Barat"
                    class="h-14 w-auto mr-3 animate-fade-in">
                <span class="text-2xl font-extrabold text-gray-800 dark:text-white">SMPN 1 Solor Barat</span>
            </div>
            @if (Route::has('login'))
                <nav class="hidden md:block">
                    <livewire:welcome.navigation />
                </nav>
                <div class="md:hidden">
                    <button class="text-gray-600 dark:text-gray-300 hover:text-primary focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </header>

    <section
        class="relative h-screen flex items-center justify-center text-center text-white overflow-hidden flex-grow">
        <div id="hero-background"></div>
        <div class="relative z-10 p-8 max-w-5xl mx-auto bg-black bg-opacity-50 rounded-xl shadow-2xl backdrop-blur-sm">
            <h1 class="text-6xl md:text-7xl font-extrabold leading-tight mb-6 animate-fade-in-up animate-fade-in-up-1">
                Selamat Datang di <span class="text-primary">SMP Negeri 1 Solor Barat</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 font-light animate-fade-in-up animate-fade-in-up-2">
                Membangun Generasi Unggul dan Berkarakter dengan Pendidikan Berkualitas Sejak 1977.
            </p>
            <a href="#informasi"
                class="inline-flex items-center justify-center bg-primary hover:bg-red-700 text-white font-bold py-4 px-10 rounded-full text-xl transition-all duration-300 transform hover:scale-105 shadow-lg animate-fade-in-up animate-fade-in-up-3">
                Pelajari Lebih Lanjut
                <svg class="ml-3 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>
    </section>

    <main id="informasi" class="container mx-auto px-6 lg:px-8 py-20 flex-grow">
        <h2 class="text-5xl font-extrabold text-center mb-16 text-gray-800 dark:text-white animate-fade-in">
            Informasi Penting Sekolah Kami
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            <a href="https://dapo.dikdasmen.go.id/sekolah/1AA631A9DB29977F885E" target="_blank"
                rel="noopener noreferrer"
                class="group flex flex-col items-start gap-6 rounded-xl bg-white p-8 shadow-xl ring-1 ring-gray-100 transition-all duration-300 hover:scale-[1.03] hover:shadow-2xl focus:outline-none focus-visible:ring-primary dark:bg-zinc-800 dark:ring-zinc-700 dark:hover:ring-zinc-600 dark:hover:bg-zinc-700">
                <div id="map-container" class="w-full mb-4">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.6440696817413!2d122.97694781134288!3d-8.436569385191516!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dac853fc411b9f7%3A0x8cf636e5ebc80d58!2sSMPN%201%20Solor%20Barat!5e0!3m2!1sid!2sid!4v1752047070108!5m2!1sid!2sid"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="flex items-center gap-4">
                    <div
                        class="flex size-16 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary transition-colors duration-300 group-hover:bg-primary/20">
                        <svg class="size-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M23 4a1 1 0 0 0-1.447-.894L12.224 7.77a.5.5 0 0 1-.448 0L2.447 3.106A1 1 0 0 0 1 4v13.382a1.99 1.99 0 0 0 1.105 1.79l9.448 4.728c.14.065.293.1.447.1.154-.005.306-.04.447-.105l9.453-4.724a1.99 1.99 0 0 0 1.1-1.789V4ZM3 6.023a.25.25 0 0 1 .362-.223l7.5 3.75a.251.251 0 0 1 .138.223v11.2a.25.25 0 0 1-.362.224l-7.5-3.75a.25.25 0 0 1-.138-.22V6.023Zm18 11.2a.25.25 0 0 1-.138.224l-7.5 3.75a.249.249 0 0 1-.329-.099.249.249 0 0 1-.033-.12V9.772a.251.251 0 0 1 .138-.224l7.5-3.75a.25.25 0 0 1 .362.224v11.2Z" />
                            <path fill="currentColor"
                                d="m3.55 1.893 8 4.048a1.008 1.008 0 0 0 .9 0l8-4.048a1 1 0 0 0-.9-1.785l-7.322 3.706a.506.506 0 0 1-.452 0L4.454.108a1 1 0 0 0-.9 1.785H3.55Z" />
                        </svg>
                    </div>
                    <div>
                        <h3
                            class="text-3xl font-extrabold text-gray-800 dark:text-white transition-colors duration-300 group-hover:text-primary">
                            Data Pokok Pendidikan (DAPODIK)</h3>
                    </div>
                </div>
                <p class="mt-4 text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                    SMP Negeri 1 Solor Barat adalah sekolah negeri yang telah berdiri sejak 1977, memiliki akreditasi B,
                    dan melayani sekitar 200 siswa dengan fasilitas cukup lengkap di bawah Kurikulum Merdeka. Data
                    terakhir sinkron per 4 Februari 2025.
                </p>
                <div class="mt-auto self-end text-primary group-hover:text-red-700 transition-colors duration-300">
                    <svg class="size-7 shrink-0 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>
                </div>
            </a>

            <a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/a0f3713a-033c-e111-8140-914a1c370974"
                target="_blank" rel="noopener noreferrer"
                class="group flex flex-col items-start gap-6 rounded-xl bg-white p-8 shadow-xl ring-1 ring-gray-100 transition-all duration-300 hover:scale-[1.03] hover:shadow-2xl focus:outline-none focus-visible:ring-primary dark:bg-zinc-800 dark:ring-zinc-700 dark:hover:ring-zinc-600 dark:hover:bg-zinc-700">
                <div class="flex items-center gap-4">
                    <div
                        class="flex size-16 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary transition-colors duration-300 group-hover:bg-primary/20">
                        <svg class="size-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <g fill="currentColor">
                                <path
                                    d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                                <path
                                    d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
                                <path
                                    d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h3
                            class="text-3xl font-extrabold text-gray-800 dark:text-white transition-colors duration-300 group-hover:text-primary">
                            Data Sekolah Kita</h3>
                    </div>
                </div>
                <p class="mt-4 text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                    SMP Negeri 1 Solor Barat (NPSN 50301871) adalah sekolah negeri yang berlokasi di Desa Lewonama,
                    Solor Barat, Flores Timur, NTT. Berdiri sejak 1977, sekolah ini berstatus akreditasi B dan memiliki
                    sekitar 160 siswa serta didukung oleh ±18 tenaga pendidik dan kependidikan. Dengan luas lahan 16.423
                    m², sekolah dilengkapi fasilitas dasar seperti listrik PLN dan akses internet, serta aktif melakukan
                    sinkronisasi data Dapodik terakhir pada Mei 2025.
                </p>
                <div class="mt-auto self-end text-primary group-hover:text-red-700 transition-colors duration-300">
                    <svg class="size-7 shrink-0 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>
                </div>
            </a>

            <div
                class="group flex flex-col items-start gap-6 rounded-xl bg-white p-8 shadow-xl ring-1 ring-gray-100 transition-all duration-300 hover:scale-[1.03] hover:shadow-2xl focus:outline-none focus-visible:ring-primary dark:bg-zinc-800 dark:ring-zinc-700 dark:hover:ring-zinc-600 dark:hover:bg-zinc-700">
                <div class="flex items-center gap-4">
                    <div
                        class="flex size-16 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary transition-colors duration-300 group-hover:bg-primary/20">
                        <svg class="size-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <g fill="currentColor">
                                <path
                                    d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                    clip-rule="evenodd" />
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h3
                            class="text-3xl font-extrabold text-gray-800 dark:text-white transition-colors duration-300 group-hover:text-primary">
                            Galeri Kegiatan</h3>
                    </div>
                </div>
                <div id="gallery-container"
                    class="w-full flex justify-center items-center overflow-hidden rounded-lg shadow-md aspect-video">
                    <img id="random-img" src="" alt="Galeri Kegiatan"
                        class="w-full h-full object-cover transition-opacity duration-500 ease-in-out">
                </div>
                <p class="mt-4 text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                    Lihat berbagai kegiatan dan momen berharga dari siswa-siswi dan guru-guru kami di SMP Negeri 1 Solor
                    Barat.
                </p>
            </div>

        </div>
    </main>

    <footer
        class="py-12 text-center text-sm text-gray-600 dark:text-gray-400 border-t border-gray-200 dark:border-zinc-700 mt-auto">
        <p class="mb-1">&copy; {{ date('Y') }} SMP Negeri 1 Solor Barat. Hak Cipta Dilindungi.</p>
        <p>Didukung oleh Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
    </footer>

    <script>
        const imgElement = document.getElementById('random-img');
        const images = [
            '{{ asset('img/galeri/1.jpg') }}',
            '{{ asset('img/galeri/2.jpg') }}',
            '{{ asset('img/galeri/3.jpg') }}',
            '{{ asset('img/galeri/4.jpg') }}',
            '{{ asset('img/galeri/5.jpg') }}'
        ];

        let currentImageIndex = 0;

        function showNextImage() {
            imgElement.style.opacity = 0; // Fade out
            setTimeout(() => {
                imgElement.src = images[currentImageIndex];
                currentImageIndex = (currentImageIndex + 1) % images.length;
                imgElement.style.opacity = 1; // Fade in
            }, 300); // Waktu yang sama dengan transition-opacity duration
        }

        // Display the first image immediately
        showNextImage();

        // Change image every 5 seconds (5000 ms)
        setInterval(showNextImage, 5000);

        // Smooth scroll for hero button
        document.querySelector('a[href="#informasi"]').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });

        // Add a simple animation to header on scroll (optional)
        const header = document.querySelector('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('shadow-xl', 'bg-opacity-95');
                header.classList.remove('shadow-lg', 'bg-opacity-100');
            } else {
                header.classList.remove('shadow-xl', 'bg-opacity-95');
                header.classList.add('shadow-lg', 'bg-opacity-100');
            }
        });
    </script>
</body>

</html>
