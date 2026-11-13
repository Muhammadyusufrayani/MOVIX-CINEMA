@extends('layouts.app')

@section('title', 'E-Ticket ' . $booking->booking_code . ' - Movix Cinema')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8"
     x-data="{
        copied: false,
        copyCode() {
            navigator.clipboard.writeText('{{ $booking->booking_code }}');
            this.copied = true;
            setTimeout(() => { this.copied = false }, 2500);
        }
     }">

    <!-- Top Action Row (Hidden on Print) -->
    <div class="no-print flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-gray-900 text-base sm:text-lg">Pemesanan Tiket Bioskop Berhasil!</h1>
                <p class="text-xs text-gray-500">E-Ticket resmi Anda telah terbit dan siap digunakan.</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Print Button -->
            <button type="button" 
                    onclick="window.print()" 
                    class="px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-xl shadow-md shadow-brand-600/30 flex items-center gap-2 transition-all">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Tiket</span>
            </button>

            <!-- Back to Home -->
            <a href="{{ route('home') }}" 
               class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl flex items-center gap-1.5 transition-colors">
                <i class="fa-solid fa-house text-xs"></i>
                <span>Beranda</span>
            </a>
        </div>
    </div>

    <!-- PRINTABLE E-TICKET CARD -->
    <div id="printable-ticket" class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden relative">
        
        <!-- Ticket Header Band -->
        <div class="bg-gradient-to-r from-[#850000] via-[#B91C1C] to-[#E50914] text-white p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-brand-600 shadow-lg">
                    <i class="fa-solid fa-clapperboard text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-extrabold tracking-[0.25em] text-white/80 block">OFFICIAL E-TICKET</span>
                    <span class="text-2xl font-black tracking-wider text-white">MOVIX CINEMA</span>
                </div>
            </div>

            <!-- Booking Status & Code Badge -->
            <div class="flex flex-col sm:items-end">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500 text-white text-xs font-bold shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span>LUNAS &bull; CONFIRMED</span>
                </div>
                <div class="mt-2 flex items-center gap-2">
                    <span class="font-mono text-base sm:text-lg font-black tracking-widest text-amber-300 bg-black/30 px-3 py-1 rounded-lg border border-white/20">
                        {{ $booking->booking_code }}
                    </span>
                    <button type="button" 
                            @click="copyCode()" 
                            class="no-print text-white/80 hover:text-white text-xs" 
                            title="Salin Kode Booking">
                        <i :class="copied ? 'fa-solid fa-check text-emerald-400' : 'fa-regular fa-copy'"></i>
                    </button>
                </div>
                <span x-show="copied" x-cloak class="no-print text-[10px] text-emerald-300 font-semibold mt-0.5">Kode berhasil disalin!</span>
            </div>
        </div>

        <!-- Ticket Body: Left (Movie & Seats) & Right (QR & Gate check-in) -->
        <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
            
            <!-- Left Info Section (7 Cols) -->
            <div class="md:col-span-7 space-y-6">
                
                <!-- Film & Studio Row -->
                <div class="flex items-start gap-4">
                    <img src="{{ $booking->schedule->film->poster_url }}" 
                         alt="{{ $booking->schedule->film->title }}" 
                         class="w-20 h-28 object-cover rounded-2xl shadow-md border-2 border-white flex-shrink-0">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded bg-brand-50 text-brand-700 text-[10px] font-extrabold uppercase">
                                {{ $booking->schedule->studio_name }}
                            </span>
                            <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 text-[10px] font-bold">
                                {{ $booking->schedule->film->age_rating }}
                            </span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight">
                            {{ $booking->schedule->film->title }}
                        </h2>
                        <p class="text-xs text-gray-500 font-medium">
                            {{ $booking->schedule->film->genre }} &bull; {{ $booking->schedule->film->formatted_duration }}
                        </p>
                    </div>
                </div>

                <!-- Schedule & Seat Highlight Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-100 text-sm">
                    <!-- Date -->
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Tanggal</span>
                        <span class="font-extrabold text-gray-900 text-xs sm:text-sm mt-0.5 block">
                            {{ $booking->schedule->formatted_date }}
                        </span>
                    </div>

                    <!-- Time -->
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Jam Tayang</span>
                        <span class="font-extrabold text-brand-600 text-xs sm:text-sm mt-0.5 block">
                            {{ $booking->schedule->time }} WIB
                        </span>
                    </div>

                    <!-- Seats -->
                    <div class="col-span-2 sm:col-span-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Nomor Kursi</span>
                        <div class="flex flex-wrap gap-1 mt-0.5">
                            @foreach($booking->bookingSeats as $bSeat)
                                <span class="px-2 py-0.5 rounded-md bg-brand-600 text-white font-black text-xs shadow-xs">
                                    {{ $bSeat->seat_number }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Customer & Payment Details -->
                <div class="space-y-2 text-xs border-t border-gray-100 pt-4">
                    <div class="flex justify-between py-1">
                        <span class="text-gray-500">Nama Pemesan:</span>
                        <span class="font-bold text-gray-800">{{ $booking->customer_name }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-gray-500">Email Pemesan:</span>
                        <span class="font-bold text-gray-800">{{ $booking->customer_email }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-gray-500">Nomor WhatsApp:</span>
                        <span class="font-bold text-gray-800">{{ $booking->customer_phone }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-t border-gray-100 pt-2">
                        <span class="text-gray-500">Jumlah Tiket:</span>
                        <span class="font-bold text-gray-800">{{ $booking->total_seats }} Kursi ({{ $booking->seat_numbers_string }})</span>
                    </div>
                    <div class="flex justify-between py-1 items-baseline">
                        <span class="font-bold text-gray-900 text-sm">Total Pembayaran:</span>
                        <span class="font-black text-lg text-brand-600">{{ $booking->formatted_total_price }}</span>
                    </div>
                </div>

            </div>

            <!-- Right QR & Barcode Section (5 Cols) -->
            <div class="md:col-span-5 flex flex-col items-center justify-center p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-300 text-center relative">
                
                <!-- Ticket Notch Circles on borders (Visual perforated effect) -->
                <div class="hidden md:block absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-white rounded-full border border-gray-200"></div>

                <span class="text-[10px] font-extrabold uppercase tracking-widest text-brand-600 mb-3">
                    SCAN UNTUK MASUK STUDIO
                </span>

                <!-- QR Code representation -->
                <div class="p-3 bg-white rounded-2xl shadow-md border border-gray-200 mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(route('booking.ticket', $booking->booking_code)) }}&color=111827" 
                         alt="QR Code Tiket {{ $booking->booking_code }}" 
                         class="w-40 h-40 object-contain mx-auto">
                </div>

                <!-- Booking code under QR -->
                <span class="font-mono text-xs font-black tracking-wider text-gray-800 block">
                    {{ $booking->booking_code }}
                </span>

                <!-- Barcode visual simulation -->
                <div class="mt-3 flex items-center justify-center gap-1 opacity-70">
                    <div class="w-0.5 h-7 bg-gray-900"></div>
                    <div class="w-1.5 h-7 bg-gray-900"></div>
                    <div class="w-0.5 h-7 bg-gray-900"></div>
                    <div class="w-1 h-7 bg-gray-900"></div>
                    <div class="w-2 h-7 bg-gray-900"></div>
                    <div class="w-0.5 h-7 bg-gray-900"></div>
                    <div class="w-1.5 h-7 bg-gray-900"></div>
                    <div class="w-1 h-7 bg-gray-900"></div>
                    <div class="w-0.5 h-7 bg-gray-900"></div>
                    <div class="w-2 h-7 bg-gray-900"></div>
                    <div class="w-1 h-7 bg-gray-900"></div>
                    <div class="w-0.5 h-7 bg-gray-900"></div>
                </div>

                <p class="text-[10px] text-gray-500 mt-3 leading-tight max-w-[220px]">
                    Tunjukkan QR code ini ke petugas bioskop Movix di pintu masuk studio atau cetak tiket di kiosk mandiri.
                </p>
            </div>

        </div>

        <!-- Ticket Footer Notice -->
        <div class="bg-gray-50 px-6 sm:px-8 py-3 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-[11px] text-gray-500 gap-2">
            <span>Waktu Cetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</span>
            <span>Grand Movix Mall Jakarta &bull; www.movixcinema.id</span>
        </div>

    </div>

    <!-- Bottom Action Links (No Print) -->
    <div class="no-print flex flex-wrap items-center justify-center gap-4 pt-4">
        <a href="{{ route('home') }}" 
           class="px-6 py-3 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs shadow-md shadow-brand-600/30 flex items-center gap-2 transition-all">
            <i class="fa-solid fa-film"></i>
            <span>Pesan Tiket Film Lain</span>
        </a>

        <button type="button" 
                onclick="window.print()" 
                class="px-6 py-3 rounded-full bg-white hover:bg-gray-50 text-gray-700 font-extrabold text-xs border border-gray-200 shadow-sm flex items-center gap-2 transition-colors">
            <i class="fa-solid fa-file-pdf text-rose-500"></i>
            <span>Simpan / Cetak PDF</span>
        </button>
    </div>

</div>
@endsection

