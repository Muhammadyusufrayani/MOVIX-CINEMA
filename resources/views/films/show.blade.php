@extends('layouts.app')

@section('title', $film->title . ' - Detail Film Movix Cinema')

@section('content')
<div class="space-y-8 pb-16">

    <!-- Top Cinematic Backdrop Banner -->
    <div class="relative w-full h-72 sm:h-96 bg-gray-900 overflow-hidden">
        <img src="{{ $film->banner_url }}" 
             alt="{{ $film->title }} Backdrop" 
             class="w-full h-full object-cover opacity-35 filter blur-xs scale-105">
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-[#F8F9FA] via-gray-950/60 to-gray-950/80"></div>

        <!-- Breadcrumb on top of banner -->
        <div class="absolute top-6 left-0 right-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-xs font-semibold text-gray-300">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-500"></i>
                    <a href="{{ route('home') }}#sedang-tayang" class="hover:text-white transition-colors">Film</a>
                    <i class="fa-solid fa-chevron-right text-[10px] text-gray-500"></i>
                    <span class="text-white truncate max-w-xs">{{ $film->title }}</span>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Content Container (Overlapping Backdrop) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-40 sm:-mt-52 relative z-20">
        
        <!-- Film Detail Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <!-- Poster Column -->
            <div class="md:col-span-4 lg:col-span-3 flex flex-col items-center">
                <div class="w-56 sm:w-64 md:w-full aspect-[2/3] rounded-2xl overflow-hidden shadow-2xl border-4 border-white bg-gray-100 relative group">
                    <img src="{{ $film->poster_url }}" 
                         alt="{{ $film->title }}" 
                         class="w-full h-full object-cover">
                    
                    <!-- Age Rating Ribbon -->
                    <div class="absolute top-3 right-3 px-2.5 py-1 rounded-md bg-brand-600 text-white font-extrabold text-xs shadow-md">
                        {{ $film->age_rating }}
                    </div>

                    <!-- Trailer Button Overlay (if exists) -->
                    @if($film->trailer_url)
                        <a href="{{ $film->trailer_url }}" 
                           target="_blank" 
                           class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white gap-2 backdrop-blur-xs">
                            <span class="w-14 h-14 rounded-full bg-brand-600/90 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-play text-xl ml-1"></i>
                            </span>
                            <span class="text-xs font-bold tracking-wider uppercase">Tonton Trailer</span>
                        </a>
                    @endif
                </div>

                <!-- Status Badge -->
                <div class="mt-4 w-full">
                    @if($film->status === 'now_showing')
                        <div class="py-2 px-4 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 text-center text-xs font-extrabold flex items-center justify-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            SEDANG TAYANG DI BIOSKOP
                        </div>
                    @else
                        <div class="py-2 px-4 rounded-xl bg-amber-50 text-amber-700 border border-amber-200 text-center text-xs font-extrabold flex items-center justify-center gap-2">
                            <i class="fa-regular fa-clock"></i>
                            SEGERA HADIR (COMING SOON)
                        </div>
                    @endif
                </div>
            </div>

            <!-- Film Info Column -->
            <div class="md:col-span-8 lg:col-span-9 space-y-6">
                
                <!-- Title & Genre -->
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        @foreach(explode(',', $film->genre) as $g)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                {{ trim($g) }}
                            </span>
                        @endforeach
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                        {{ $film->title }}
                    </h1>
                </div>

                <!-- Meta Pills Row: Rating, Duration, Release -->
                <div class="flex flex-wrap items-center gap-4 py-3 border-y border-gray-100 text-sm">
                    <!-- Rating -->
                    <div class="flex items-center gap-2 bg-amber-50 text-amber-800 px-3.5 py-1.5 rounded-xl font-bold border border-amber-200">
                        <i class="fa-solid fa-star text-amber-500"></i>
                        <span>{{ number_format($film->rating, 1) }}</span>
                        <span class="text-xs font-normal text-amber-700">/ 10</span>
                    </div>

                    <!-- Duration -->
                    <div class="flex items-center gap-2 text-gray-700 font-medium">
                        <i class="fa-regular fa-clock text-brand-600"></i>
                        <span>{{ $film->formatted_duration }}</span>
                    </div>

                    <!-- Age Rating -->
                    <div class="flex items-center gap-2 text-gray-700 font-medium">
                        <i class="fa-solid fa-user-shield text-brand-600"></i>
                        <span>Klasifikasi Usia: <strong class="text-gray-900">{{ $film->age_rating }}</strong></span>
                    </div>

                    <!-- Release Date -->
                    @if($film->release_date)
                        <div class="flex items-center gap-2 text-gray-700 font-medium">
                            <i class="fa-regular fa-calendar-check text-brand-600"></i>
                            <span>Rilis: {{ $film->release_date->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Cast & Crew -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm bg-gray-50/70 p-4 rounded-2xl border border-gray-100">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Sutradara</span>
                        <span class="font-semibold text-gray-800 mt-0.5 block">{{ $film->director ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Pemeran Utama</span>
                        <span class="font-semibold text-gray-800 mt-0.5 block line-clamp-2">{{ $film->cast ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Synopsis -->
                <div class="space-y-2">
                    <h3 class="text-base font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-brand-600"></i>
                        Sinopsis Film
                    </h3>
                    <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                        {{ $film->synopsis }}
                    </p>
                </div>

                <!-- Quick anchor to schedule -->
                @if($film->status === 'now_showing' && $film->schedules->count() > 0)
                    <div class="pt-2">
                        <a href="#jadwal-tayang" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-2xl shadow-md shadow-brand-600/30 transition-all duration-200">
                            <i class="fa-solid fa-ticket"></i>
                            <span>Pilih Jadwal & Kursi Bioskop</span>
                            <i class="fa-solid fa-arrow-down text-xs"></i>
                        </a>
                    </div>
                @endif

            </div>

        </div>

        <!-- SECTION: Jadwal Tayang per Studio + Harga -->
        <div id="jadwal-tayang" class="mt-12 scroll-mt-24 space-y-6">
            
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                        <span class="w-9 h-9 rounded-xl bg-brand-600 text-white flex items-center justify-center text-sm shadow-sm">
                            <i class="fa-solid fa-calendar-day"></i>
                        </span>
                        Jadwal Tayang & Harga Tiket
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Pilih tanggal dan jam tayang studio untuk melanjutkan pemilihan kursi interaktif.</p>
                </div>
            </div>

            @if($film->status === 'upcoming')
                <!-- Upcoming State Notice -->
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center text-amber-900">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-3 text-amber-600 text-2xl">
                        <i class="fa-solid fa-ticket-simple"></i>
                    </div>
                    <h3 class="text-lg font-bold">Penjualan Tiket Belum Dibuka</h3>
                    <p class="text-sm text-amber-700 max-w-md mx-auto mt-1">
                        Film ini berstatus <strong>Segera Hadir</strong>. Penjualan tiket pre-sale dan jadwal resmi akan dibuka beberapa hari sebelum tanggal rilis resmi.
                    </p>
                    <a href="{{ route('home') }}" class="inline-block mt-4 px-5 py-2.5 bg-amber-600 text-white font-bold rounded-xl text-xs hover:bg-amber-700 transition-colors">
                        Kembali ke Katalog Film
                    </a>
                </div>
            @elseif($film->schedules->isEmpty())
                <!-- No schedules found -->
                <div class="bg-white rounded-2xl p-8 text-center border border-gray-100 text-gray-500">
                    <i class="fa-regular fa-calendar-xmark text-4xl text-gray-300 mb-2"></i>
                    <p class="font-medium">Belum ada jadwal tayang aktif untuk film ini.</p>
                </div>
            @else
                <!-- Interactive Date Tabs & Studio Listings (Alpine.js) -->
                <div x-data="{ 
                        selectedDate: '{{ $schedulesByDate->keys()->first() }}' 
                     }" 
                     class="space-y-6">
                    
                    <!-- Date Selector Tabs -->
                    <div class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none">
                        @foreach($schedulesByDate as $dateKey => $schedulesOnDate)
                            @php
                                $cDate = \Carbon\Carbon::parse($dateKey);
                                $isToday = $cDate->isToday();
                                $isTomorrow = $cDate->isTomorrow();
                                $label = $isToday ? 'Hari Ini' : ($isTomorrow ? 'Besok' : $cDate->locale('id')->isoFormat('dddd'));
                            @endphp
                            <button @click="selectedDate = '{{ $dateKey }}'" 
                                    :class="selectedDate === '{{ $dateKey }}' 
                                        ? 'bg-brand-600 text-white shadow-md shadow-brand-600/30 border-brand-600' 
                                        : 'bg-white text-gray-700 hover:border-brand-300 border-gray-200'"
                                    class="flex flex-col items-center justify-center px-6 py-3 rounded-2xl border transition-all duration-200 min-w-[130px] flex-shrink-0">
                                <span class="text-xs font-bold uppercase tracking-wider" 
                                      :class="selectedDate === '{{ $dateKey }}' ? 'text-white/80' : 'text-gray-400'">
                                    {{ $label }}
                                </span>
                                <span class="text-base font-extrabold mt-0.5">
                                    {{ $cDate->locale('id')->isoFormat('D MMM Y') }}
                                </span>
                            </button>
                        @endforeach
                    </div>

                    <!-- Studio Cards for Selected Date -->
                    @foreach($schedulesByDate as $dateKey => $schedulesOnDate)
                        <div x-show="selectedDate === '{{ $dateKey }}'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="space-y-4">
                            
                            @php
                                // Group schedules by studio name
                                $byStudio = $schedulesOnDate->groupBy('studio_name');
                            @endphp

                            @foreach($byStudio as $studioName => $studioSchedules)
                                @php
                                    $firstSchedule = $studioSchedules->first();
                                    $isImax = str_contains($studioName, 'IMAX');
                                    $isVelvet = str_contains($studioName, 'Velvet') || str_contains($studioName, 'Premiere');
                                @endphp

                                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-100 shadow-sm space-y-4">
                                    <!-- Studio Info Header -->
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-100 gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg {{ $isVelvet ? 'bg-amber-100 text-amber-700' : ($isImax ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-brand-600') }}">
                                                @if($isVelvet)
                                                    <i class="fa-solid fa-couch"></i>
                                                @elseif($isImax)
                                                    <i class="fa-solid fa-vr-cardboard"></i>
                                                @else
                                                    <i class="fa-solid fa-film"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="font-extrabold text-gray-900 text-lg flex items-center gap-2">
                                                    {{ $studioName }}
                                                    @if($isVelvet)
                                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-amber-100 text-amber-800 uppercase">VIP Class</span>
                                                    @elseif($isImax)
                                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-blue-100 text-blue-800 uppercase">3D Laser</span>
                                                    @else
                                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-gray-100 text-gray-600 uppercase">Dolby 7.1</span>
                                                    @endif
                                                </h3>
                                                <span class="text-xs text-gray-400">Total Kapasitas: 48 Kursi</span>
                                            </div>
                                        </div>

                                        <!-- Price Badge -->
                                        <div class="text-right">
                                            <span class="text-xs text-gray-400 block font-medium">Harga per Tiket</span>
                                            <span class="text-xl font-black text-brand-600">{{ $firstSchedule->formatted_price }}</span>
                                        </div>
                                    </div>

                                    <!-- Showtime Buttons Grid -->
                                    <div>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Pilih Jam Tayang:</span>
                                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                            @foreach($studioSchedules as $sched)
                                                @php
                                                    $bookedCount = is_array($sched->booked_seats ?? null) ? count($sched->booked_seats) : 0;
                                                    $availableCount = $sched->total_seats - $bookedCount;
                                                    $isFull = $availableCount <= 0;
                                                @endphp

                                                <a href="{{ $isFull ? 'javascript:void(0)' : route('booking.create', $sched->id) }}" 
                                                   class="{{ $isFull ? 'bg-gray-100 opacity-60 cursor-not-allowed border-gray-200' : 'bg-gray-50 hover:bg-brand-600 hover:text-white border-gray-200 hover:border-brand-600 hover:shadow-md hover:scale-[1.02]' }} rounded-2xl p-3 border text-center transition-all duration-200 group flex flex-col items-center justify-between">
                                                    <div class="text-lg font-black group-hover:text-white transition-colors">
                                                        {{ $sched->time }}
                                                    </div>
                                                    <div class="mt-1 flex items-center gap-1 text-[11px] {{ $isFull ? 'text-rose-500 font-bold' : 'text-gray-500 group-hover:text-white/90' }}">
                                                        @if($isFull)
                                                            <span>Habis</span>
                                                        @else
                                                            <i class="fa-solid fa-chair text-[10px]"></i>
                                                            <span>{{ $availableCount }} Kursi</span>
                                                        @endif
                                                    </div>
                                                    
                                                    @if(!$isFull)
                                                        <span class="mt-2 text-[10px] font-bold text-brand-600 group-hover:text-white underline">
                                                            Pesan Kursi &rarr;
                                                        </span>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @endforeach

                </div>
            @endif

        </div>

        <!-- SECTION: Film Rekomendasi Lainnya -->
        @if($otherFilms->count() > 0)
            <div class="mt-16 pt-10 border-t border-gray-200 space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2">
                        <i class="fa-solid fa-fire text-brand-600"></i>
                        Film Sedang Tayang Lainnya
                    </h2>
                    <a href="{{ route('home') }}" class="text-xs font-bold text-brand-600 hover:underline">
                        Lihat Semua Film &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-5">
                    @foreach($otherFilms as $other)
                        <a href="{{ route('film.show', $other->id) }}" class="bg-white rounded-2xl p-2.5 shadow-sm hover:shadow-md border border-gray-100 block transition-all group">
                            <div class="aspect-[2/3] rounded-xl overflow-hidden mb-2 bg-gray-100 relative">
                                <img src="{{ $other->poster_url }}" alt="{{ $other->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <span class="absolute top-2 left-2 px-1.5 py-0.5 rounded bg-black/70 text-white text-[10px] font-bold">
                                    ⭐ {{ number_format($other->rating, 1) }}
                                </span>
                            </div>
                            <h4 class="font-bold text-gray-900 text-xs line-clamp-1 group-hover:text-brand-600">
                                {{ $other->title }}
                            </h4>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $other->genre }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</div>
@endsection

