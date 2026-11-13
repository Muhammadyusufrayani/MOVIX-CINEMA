<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Movix Cinema - Your Movie, Your Moment')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626', // Primary Movix Red
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                            dark: '#850000',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #dc2626;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #991b1b;
        }

        /* Print styles for E-ticket */
        @media print {
            body * {
                visibility: hidden;
            }
            #printable-ticket, #printable-ticket * {
                visibility: visible;
            }
            #printable-ticket {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F8F9FA] text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Header / Navbar matching exact reference design -->
    <header class="bg-white sticky top-0 z-50 border-b border-gray-100 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-11 h-11 bg-brand-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-brand-600/30 group-hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-clapperboard text-xl"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-2xl tracking-wider text-brand-600 leading-none">MOVIX</span>
                            <span class="text-xs font-bold text-gray-700 tracking-[0.25em] leading-tight">CINEMA</span>
                        </div>
                    </a>

                    <!-- Navigation Links -->
                    <nav class="hidden md:flex items-center gap-1.5 text-sm font-semibold">
                        <a href="{{ route('home') }}" 
                           class="px-5 py-2 rounded-full transition-all duration-200 {{ request()->routeIs('home') && !request('search') ? 'bg-brand-600 text-white shadow-sm shadow-brand-600/30' : 'text-gray-600 hover:text-brand-600 hover:bg-gray-100' }}">
                            Beranda
                        </a>
                        <a href="{{ route('home') }}#sedang-tayang" 
                           class="px-4 py-2 rounded-full text-gray-600 hover:text-brand-600 hover:bg-gray-100 transition-all duration-200">
                            Film
                        </a>
                        <a href="{{ route('home') }}#segera-hadir" 
                           class="px-4 py-2 rounded-full text-gray-600 hover:text-brand-600 hover:bg-gray-100 transition-all duration-200">
                            Jadwal
                        </a>
                        <a href="{{ route('home') }}#promo" 
                           class="px-4 py-2 rounded-full text-gray-600 hover:text-brand-600 hover:bg-gray-100 transition-all duration-200">
                            Promo
                        </a>
                        <a href="#footer" 
                           class="px-4 py-2 rounded-full text-gray-600 hover:text-brand-600 hover:bg-gray-100 transition-all duration-200">
                            Tentang
                        </a>
                    </nav>
                </div>

                <!-- Right Side: Search & Auth Buttons -->
                <div class="flex items-center gap-3">
                    <!-- Search Input Form -->
                    <form action="{{ route('home') }}" method="GET" class="relative hidden sm:block w-64 lg:w-80">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari film, genre, atau judul..." 
                               class="w-full pl-10 pr-4 py-2 bg-gray-100 border border-transparent rounded-full text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all duration-200">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        @if(request('search'))
                            <a href="{{ route('home') }}" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </a>
                        @endif
                    </form>

                    <!-- Auth Action Buttons (UI reference) -->
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                onclick="alert('Fitur masuk member Movix Cinema segera hadir!')"
                                class="px-4 py-2 text-sm font-semibold text-brand-600 border border-brand-600 rounded-lg hover:bg-brand-50 transition-colors duration-200">
                            Masuk
                        </button>
                        <button type="button" 
                                onclick="alert('Pendaftaran akun Movix Cinema segera hadir! Anda tetap dapat memesan tiket tanpa akun.')"
                                class="px-4 py-2 text-sm font-semibold text-white bg-brand-600 rounded-lg hover:bg-brand-700 shadow-sm shadow-brand-600/30 transition-all duration-200">
                            Daftar
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Mobile Search Row -->
        <div class="sm:hidden px-4 pb-3">
            <form action="{{ route('home') }}" method="GET" class="relative w-full">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari film, genre, atau judul..." 
                       class="w-full pl-10 pr-4 py-2 bg-gray-100 border border-transparent rounded-full text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-brand-500">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
            </form>
        </div>
    </header>

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl shadow-sm" role="alert">
                <div class="flex items-center gap-2 font-semibold text-sm mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                    <span>Terdapat kesalahan pengisian:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer" class="bg-gray-900 text-gray-300 pt-16 pb-12 mt-20 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <!-- Col 1: Brand Info -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white shadow-md">
                            <i class="fa-solid fa-clapperboard text-lg"></i>
                        </div>
                        <div>
                            <span class="font-extrabold text-2xl tracking-wider text-white">MOVIX</span>
                            <span class="text-xs font-bold text-brand-500 tracking-[0.25em] block leading-none">CINEMA</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        Your Movie, Your Moment. Nikmati pengalaman menonton film bioskop terbaik dengan kualitas audio visual terdepan dan pemesanan tiket online instan tanpa antre.
                    </p>
                    <div class="flex items-center gap-3 text-gray-400">
                        <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-brand-600 hover:text-white flex items-center justify-center transition-colors">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 tracking-wide">Navigasi Bioskop</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda Utama</a></li>
                        <li><a href="{{ route('home') }}#sedang-tayang" class="hover:text-white transition-colors">Sedang Tayang (Now Showing)</a></li>
                        <li><a href="{{ route('home') }}#segera-hadir" class="hover:text-white transition-colors">Segera Hadir (Upcoming)</a></li>
                        <li><a href="{{ route('home') }}#promo" class="hover:text-white transition-colors">Promo & Diskon Tiket</a></li>
                    </ul>
                </div>

                <!-- Col 3: Studio & Layanan -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 tracking-wide">Studio & Pengalaman</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li class="flex items-center gap-2"><i class="fa-solid fa-film text-brand-500 text-xs"></i> Regular 2D Cinema</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-vr-cardboard text-brand-500 text-xs"></i> IMAX 3D with Laser</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-couch text-brand-500 text-xs"></i> Premiere Velvet Class</li>
                        <li class="flex items-center gap-2"><i class="fa-solid fa-volume-high text-brand-500 text-xs"></i> Dolby Atmos Sound</li>
                    </ul>
                </div>

                <!-- Col 4: Layanan Pelanggan -->
                <div>
                    <h3 class="text-white font-bold text-base mb-4 tracking-wide">Bantuan & Kontak</h3>
                    <p class="text-gray-400 text-sm mb-3">Butuh bantuan terkait pemesanan e-ticket atau informasi jadwal?</p>
                    <div class="space-y-2 text-sm text-gray-300">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                            <span>+62 812-3456-7890 (CS 24 Jam)</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-regular fa-envelope text-brand-400"></i>
                            <span>support@movixcinema.id</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-location-dot text-amber-400"></i>
                            <span>Grand Movix Mall Lt. 3, Jakarta</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} Movix Cinema Indonesia. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-gray-400 transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-gray-400 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-gray-400 transition-colors">FAQ</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

