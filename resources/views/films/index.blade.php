@extends('layouts.app')

@section('title', 'Movix Cinema - Beranda & Katalog Film')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-12">

    <!-- Search Notice Bar if search is active -->
    @if($search)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-brand-600"></i>
                    Hasil Pencarian untuk: <span class="text-brand-600 font-extrabold">"{{ $search }}"</span>
                </h2>
                <p class="text-sm text-gray-500 mt-1">Ditemukan {{ $searchResults->count() }} judul film yang cocok dengan kata kunci Anda.</p>
            </div>
            <a href="{{ route('home') }}" class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-full text-sm flex items-center gap-2 transition-colors">
                <i class="fa-solid fa-rotate-left text-xs"></i>
                Reset Pencarian
            </a>
        </div>
    @endif

    <!-- Hero Banner Carousel matching reference UI -->
    @if(!$search)
        <div x-data="{
                activeSlide: 0,
                slides: [
                    {
                        title: 'GLADIATOR II',
                        tagline: 'Kembalinya Kejayaan Colosseum Roma.',
                        description: 'Saksikan pertarungan kolosal Lucius dan intrik tahta kekaisaran dalam format IMAX 3D dengan audio Dolby Atmos.',
                        ctaText: 'Pesan Tiket Gladiator II',
                        ctaLink: '{{ route('film.show', $featuredFilms->first()->id ?? 1) }}',
                        badge: 'Sedang Tayang di Bioskop'
                    },
                    {
                        title: 'WICKED',
                        tagline: 'Kisah Tak Terungkap Para Penyihir Oz.',
                        description: 'Kolaborasi magis Cynthia Erivo dan Ariana Grande dalam mahakarya musikal fantasi spektakuler tahun ini.',
                        ctaText: 'Pesan Tiket Wicked',
                        ctaLink: '{{ route('film.show', $featuredFilms->skip(1)->first()->id ?? 2) }}',
                        badge: 'Box Office Dunia'
                    },
                    {
                        title: 'BILA ESOK IBU TIADA',
                        tagline: 'Keluarga Adalah Tempat Pulang.',
                        description: 'Film drama keluarga karya Rudi Soedjarwo yang menyentuh hati jutaan penonton di seluruh bioskop Indonesia.',
                        ctaText: 'Pesan Tiket Bioskop',
                        ctaLink: '{{ route('film.show', $featuredFilms->skip(2)->first()->id ?? 3) }}',
                        badge: 'Film Indonesia Terpopuler'
                    }
                ],
                next() {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                },
                prev() {
                    this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
                },
                init() {
                    setInterval(() => { this.next() }, 6000);
                }
            }" 
            class="relative rounded-3xl overflow-hidden shadow-2xl bg-gradient-to-r from-[#850000] via-[#B91C1C] to-[#E50914] text-white">

            <!-- Background Film Reels & Lighting Ornaments -->
            <div class="absolute inset-0 opacity-15 pointer-events-none overflow-hidden">
                <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full border-8 border-dashed border-white/30 animate-[spin_60s_linear_infinite]"></div>
                <div class="absolute left-10 -bottom-20 w-80 h-80 rounded-full border-4 border-white/20"></div>
                <!-- Film strip silhouette pattern -->
                <div class="absolute inset-0 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px] opacity-20"></div>
            </div>

            <!-- Carousel Slide Content -->
            <div class="relative z-10 px-8 sm:px-14 py-12 sm:py-16 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center min-h-[380px] lg:min-h-[420px]">
                
                <!-- Left Column: Typography & Action -->
                <div class="lg:col-span-7 space-y-4">
                    <span x-text="slides[activeSlide].badge" class="inline-block px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur-md border border-white/30 text-white"></span>
                    
                    <h1 x-text="slides[activeSlide].title" 
                        class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight drop-shadow-md">
                    </h1>

                    <p x-text="slides[activeSlide].tagline" 
                       class="text-xl sm:text-2xl font-serif italic text-amber-200 font-medium">
                    </p>

                    <p x-text="slides[activeSlide].description" 
                       class="text-sm sm:text-base text-white/90 max-w-xl font-normal leading-relaxed">
                    </p>

                    <div class="pt-3">
                        <a :href="slides[activeSlide].ctaLink" 
                           class="inline-flex items-center gap-3 px-7 py-3 rounded-full text-sm font-bold bg-white/20 hover:bg-white text-white hover:text-brand-700 border-2 border-white backdrop-blur-md shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <i class="fa-solid fa-ticket text-amber-300"></i>
                            <span x-text="slides[activeSlide].ctaText"></span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Right Column: 3D Popcorn, Soda, & Clapper Visual Mockup -->
                <div class="lg:col-span-5 flex justify-center items-center relative">
                    <div class="relative w-72 sm:w-80 h-72 flex items-center justify-center">
                        
                        <!-- Popcorn Bucket Graphic container -->
                        <div class="relative z-20 transform hover:scale-105 transition-transform duration-300">
                            <!-- Popcorn Tub -->
                            <div class="w-48 h-56 bg-gradient-to-b from-white via-red-50 to-red-100 rounded-b-3xl rounded-t-lg shadow-2xl border-4 border-white flex flex-col items-center justify-between p-3 relative overflow-hidden">
                                <!-- Striped Pattern -->
                                <div class="absolute inset-0 opacity-20 bg-[repeating-linear-gradient(45deg,#dc2626,#dc2626_10px,#ffffff_10px,#ffffff_20px)]"></div>
                                
                                <!-- Overflowing Popcorn Kernels Top -->
                                <div class="absolute -top-7 left-1/2 -translate-x-1/2 flex items-center justify-center gap-1">
                                    <span class="w-8 h-8 rounded-full bg-amber-200 border-2 border-amber-300 shadow-sm inline-block"></span>
                                    <span class="w-10 h-10 rounded-full bg-amber-300 border-2 border-amber-400 shadow inline-block -mt-3"></span>
                                    <span class="w-9 h-9 rounded-full bg-amber-200 border-2 border-amber-300 shadow-sm inline-block"></span>
                                    <span class="w-7 h-7 rounded-full bg-amber-100 border border-amber-300 shadow-sm inline-block"></span>
                                </div>

                                <div class="relative z-10 text-center my-auto">
                                    <div class="w-24 h-16 bg-white/95 rounded-xl shadow-md border border-brand-200 flex flex-col items-center justify-center mx-auto px-2">
                                        <i class="fa-solid fa-film text-brand-600 text-sm"></i>
                                        <span class="text-xs font-black tracking-widest text-brand-600">MOVIX</span>
                                        <span class="text-[9px] font-bold text-gray-700 tracking-wider">CINEMA</span>
                                    </div>
                                </div>

                                <span class="text-[10px] text-gray-500 font-semibold tracking-wider relative z-10">POPCORN CRISPY</span>
                            </div>
                        </div>

                        <!-- Soda Cup graphic floating right -->
                        <div class="absolute -right-2 top-8 z-10 transform rotate-12 scale-90">
                            <div class="w-28 h-44 bg-gradient-to-b from-red-600 to-red-800 rounded-b-2xl rounded-t-md shadow-xl border-2 border-white/80 p-2 flex flex-col items-center justify-center text-white relative">
                                <!-- Straw -->
                                <div class="absolute -top-10 right-8 w-3 h-14 bg-red-400 rounded-full border border-white transform -rotate-12"></div>
                                <div class="w-8 h-8 rounded-full bg-white text-brand-600 flex items-center justify-center mb-1">
                                    <i class="fa-solid fa-play text-xs"></i>
                                </div>
                                <span class="text-[10px] font-bold tracking-widest uppercase">MOVIX</span>
                                <span class="text-[8px] opacity-80">COLD SODA</span>
                            </div>
                        </div>

                        <!-- Clapperboard bottom right -->
                        <div class="absolute -bottom-2 -left-2 z-30 transform -rotate-6">
                            <div class="w-36 h-28 bg-gray-950 text-white rounded-lg shadow-2xl border-2 border-white/60 p-2 text-center flex flex-col justify-between">
                                <div class="flex h-5 border-b border-white/40 overflow-hidden rounded-t">
                                    <div class="flex-1 bg-white"></div>
                                    <div class="flex-1 bg-gray-900"></div>
                                    <div class="flex-1 bg-white"></div>
                                    <div class="flex-1 bg-gray-900"></div>
                                    <div class="flex-1 bg-white"></div>
                                </div>
                                <div class="py-1">
                                    <span class="text-[11px] font-bold text-amber-400 block tracking-wider">SCENE: 01</span>
                                    <span class="text-[9px] text-gray-300 tracking-widest">TAKE: NOW SHOWING</span>
                                </div>
                                <div class="text-[8px] text-gray-400 border-t border-gray-800 pt-1 font-mono">DIR: MOVIX</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Navigation Controls: Left & Right Arrows -->
            <button @click="prev()" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/30 hover:bg-white text-white hover:text-brand-700 flex items-center justify-center backdrop-blur-md transition-all duration-200 z-20">
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button @click="next()" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white/30 hover:bg-white text-white hover:text-brand-700 flex items-center justify-center backdrop-blur-md transition-all duration-200 z-20">
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <!-- Pagination Dots -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-20">
                <template x-for="(slide, idx) in slides" :key="idx">
                    <button @click="activeSlide = idx" 
                            :class="activeSlide === idx ? 'w-6 bg-white' : 'w-2 bg-white/40 hover:bg-white/70'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                </template>
            </div>
        </div>
    @endif

    <!-- SECTION 1: Sedang Tayang (Now Showing) -->
    <section id="sedang-tayang" class="scroll-mt-24 space-y-6">
        
        <!-- Section Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                    <i class="fa-solid fa-clapperboard text-lg"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Sedang Tayang</h2>
            </div>
            <a href="#sedang-tayang" class="text-sm font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1 group">
                <span>Lihat Semua</span>
                <i class="fa-solid fa-arrow-right text-xs transform group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Horizontal Poster Grid / Scrollable List -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @forelse($nowShowing as $film)
                <div class="bg-white rounded-2xl p-2.5 shadow-sm hover:shadow-xl border border-gray-100 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 group">
                    <div>
                        <!-- Poster Image Container -->
                        <div class="relative aspect-[2/3] rounded-xl overflow-hidden mb-3 bg-gray-200">
                            <img src="{{ $film->poster_url }}" 
                                 alt="{{ $film->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                            
                            <!-- Rating Badge Overlay -->
                            <div class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-md bg-gray-950/80 backdrop-blur-md text-white text-[11px] font-bold flex items-center gap-1 border border-white/20">
                                <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
                                <span>{{ number_format($film->rating, 1) }}</span>
                            </div>

                            <!-- Age Rating Badge -->
                            <div class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-md bg-brand-600/90 text-white text-[10px] font-bold uppercase tracking-wider">
                                {{ $film->age_rating }}
                            </div>

                            <!-- Hover Overlay with Quick Info -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-3 text-white">
                                <span class="text-xs font-medium">{{ $film->formatted_duration }}</span>
                            </div>
                        </div>

                        <!-- Film Meta -->
                        <h3 class="font-bold text-gray-900 text-sm leading-snug line-clamp-1 group-hover:text-brand-600 transition-colors">
                            {{ $film->title }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">
                            {{ $film->genre }}
                        </p>

                        <!-- Rating score bar -->
                        <div class="flex items-center gap-1.5 mt-2">
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                            <span class="text-xs font-bold text-gray-800">{{ number_format($film->rating, 1) }}</span>
                            <span class="text-[10px] text-gray-400">/ 10</span>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <div class="mt-3">
                        <a href="{{ route('film.show', $film->id) }}" 
                           class="w-full block text-center py-2 px-3 bg-brand-600 hover:bg-brand-700 active:bg-brand-800 text-white text-xs font-bold rounded-xl shadow-sm shadow-brand-600/30 transition-all duration-200">
                            Pesan Tiket
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-gray-100">
                    <i class="fa-solid fa-film text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-500 font-medium">Tidak ada film yang sedang tayang dengan kriteria ini.</p>
                </div>
            @endforelse

            <!-- Promo Spesial Card (Matching reference UI rightmost card) -->
            <div id="promo" class="col-span-2 sm:col-span-3 md:col-span-2 lg:col-span-2 bg-gradient-to-br from-brand-600 via-brand-700 to-brand-800 rounded-2xl p-5 text-white shadow-md flex flex-col justify-between relative overflow-hidden group">
                <!-- Voucher graphics & waves -->
                <div class="absolute -right-8 -bottom-8 w-36 h-36 rounded-full bg-white/10 blur-xl"></div>
                <div class="absolute top-2 right-2 text-white/10 text-7xl font-black select-none pointer-events-none">%</div>

                <div>
                    <!-- Promo Header -->
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center text-white text-xs">
                            <i class="fa-solid fa-ticket-simple"></i>
                        </span>
                        <span class="text-xs font-bold tracking-wider uppercase text-white/90">Promo Spesial</span>
                    </div>

                    <!-- Inner Voucher Card shape -->
                    <div class="bg-white rounded-xl p-4 text-gray-900 shadow-lg relative my-2">
                        <!-- Perforation dots on side -->
                        <div class="absolute -left-2.5 top-1/2 -translate-y-1/2 w-5 h-5 bg-brand-700 rounded-full"></div>
                        <div class="absolute -right-2.5 top-1/2 -translate-y-1/2 w-5 h-5 bg-brand-700 rounded-full"></div>

                        <div class="text-center pl-2 pr-2">
                            <span class="text-[11px] font-bold text-brand-600 uppercase tracking-widest block">VOUCHER HEMAT</span>
                            <div class="text-3xl font-black text-gray-900 tracking-tight my-1">
                                Diskon <span class="text-brand-600">20%</span>
                            </div>
                            <p class="text-xs text-gray-500 leading-tight">
                                Untuk pembelian tiket pertama di Movix Cinema
                            </p>
                            <div class="mt-2 pt-2 border-t border-dashed border-gray-200">
                                <span class="font-mono text-xs font-extrabold bg-gray-100 text-brand-600 px-3 py-1 rounded-md tracking-wider">
                                    MOVIXPERDANA
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="button" 
                            onclick="alert('Gunakan kode promo: MOVIXPERDANA saat memesan tiket di halaman booking!')"
                            class="w-full py-2 bg-white/20 hover:bg-white text-white hover:text-brand-700 font-bold text-xs rounded-xl border border-white/40 transition-colors">
                        Klaim Voucher Sekarang
                    </button>
                </div>
            </div>

        </div>
    </section>

    <!-- SECTION 2: Segera Hadir (Upcoming) -->
    <section id="segera-hadir" class="scroll-mt-24 space-y-6">
        
        <!-- Section Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-50 text-brand-600 flex items-center justify-center">
                    <i class="fa-regular fa-calendar-days text-lg"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Segera Hadir</h2>
            </div>
            <a href="#segera-hadir" class="text-sm font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1 group">
                <span>Lihat Semua</span>
                <i class="fa-solid fa-arrow-right text-xs transform group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Poster Grid for Upcoming Films -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @forelse($upcoming as $film)
                <div class="bg-white rounded-2xl p-2.5 shadow-sm hover:shadow-xl border border-gray-100 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1.5 group">
                    <div>
                        <!-- Poster Image -->
                        <div class="relative aspect-[2/3] rounded-xl overflow-hidden mb-3 bg-gray-200">
                            <img src="{{ $film->poster_url }}" 
                                 alt="{{ $film->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 filter grayscale-[20%] group-hover:grayscale-0"
                                 loading="lazy">
                            
                            <!-- Upcoming Tag -->
                            <div class="absolute top-2.5 left-2.5 px-2.5 py-1 rounded-md bg-amber-500 text-white text-[10px] font-extrabold uppercase tracking-wider shadow">
                                Segera Hadir
                            </div>

                            <div class="absolute top-2.5 right-2.5 px-2 py-0.5 rounded-md bg-gray-950/80 text-white text-[10px] font-bold">
                                {{ $film->age_rating }}
                            </div>
                        </div>

                        <!-- Film Meta -->
                        <h3 class="font-bold text-gray-900 text-sm leading-snug line-clamp-1 group-hover:text-brand-600 transition-colors">
                            {{ $film->title }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">
                            {{ $film->genre }}
                        </p>

                        <div class="flex items-center gap-1 mt-2 text-xs text-gray-600">
                            <i class="fa-regular fa-calendar text-brand-500 text-[11px]"></i>
                            <span>Rilis: {{ $film->release_date ? $film->release_date->format('M Y') : 'Coming Soon' }}</span>
                        </div>
                    </div>

                    <!-- Upcoming Info Button -->
                    <div class="mt-3">
                        <a href="{{ route('film.show', $film->id) }}" 
                           class="w-full block text-center py-2 px-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-colors">
                            Sinopsis & Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-gray-100">
                    <p class="text-gray-500">Belum ada daftar film segera hadir.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Cinema Experience / Feature Highlights Section -->
    <section class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">Kenapa Memilih Movix</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">Pengalaman Sinematik Terbaik</h2>
            <p class="text-sm text-gray-500 mt-2">Didesain khusus untuk menghadirkan kenyamanan dan kejelasan audio visual tanpa kompromi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 rounded-2xl bg-gray-50 hover:bg-red-50/50 transition-colors border border-gray-100 text-center">
                <div class="w-14 h-14 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm">
                    <i class="fa-solid fa-chair"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-1">Pilih Kursi Real-Time</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Pilih kursi favorit secara interaktif langsung dari peta studio tanpa perlu antre di loket tiket.</p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 hover:bg-red-50/50 transition-colors border border-gray-100 text-center">
                <div class="w-14 h-14 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-1">E-Ticket Instan & QR Code</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Setelah pemesanan sukses, e-tiket lengkap dengan QR Code dapat langsung diunduh, dicetak, atau discan di pintu masuk.</p>
            </div>

            <div class="p-6 rounded-2xl bg-gray-50 hover:bg-red-50/50 transition-colors border border-gray-100 text-center">
                <div class="w-14 h-14 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-1">Aman & Terpercaya</h3>
                <p class="text-xs text-gray-500 leading-relaxed">Sistem validasi data pemesan dan penguncian kursi real-time mencegah terjadinya tiket ganda.</p>
            </div>
        </div>
    </section>

</div>
@endsection

