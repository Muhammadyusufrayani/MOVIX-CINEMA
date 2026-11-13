@extends('layouts.app')

@section('title', 'Pilih Kursi - ' . $schedule->film->title . ' - Movix Cinema')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
     x-data="{
        price: {{ $schedule->price }},
        bookedSeats: {{ json_encode($bookedSeats) }},
        selectedSeats: @json(old('seats_array', [])),
        maxSeats: 8,
        
        toggleSeat(seat) {
            if (this.isBooked(seat)) return;
            
            const index = this.selectedSeats.indexOf(seat);
            if (index > -1) {
                this.selectedSeats.splice(index, 1);
            } else {
                if (this.selectedSeats.length >= this.maxSeats) {
                    alert('Maksimal pemesanan adalah ' + this.maxSeats + ' kursi per transaksi.');
                    return;
                }
                this.selectedSeats.push(seat);
            }
        },

        isSelected(seat) {
            return this.selectedSeats.includes(seat);
        },

        isBooked(seat) {
            return this.bookedSeats.includes(seat);
        },

        get subtotal() {
            return this.selectedSeats.length * this.price;
        },

        get total() {
            return this.subtotal;
        },

        formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        },

        validateBeforeSubmit(e) {
            if (this.selectedSeats.length === 0) {
                e.preventDefault();
                alert('Silakan pilih minimal 1 kursi pada denah bioskop terlebih dahulu!');
                return false;
            }
            return true;
        }
     }">

    <!-- Breadcrumb & Top Bar -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
            <a href="{{ route('film.show', $schedule->film->id) }}" class="hover:text-brand-600 transition-colors">{{ $schedule->film->title }}</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
            <span class="text-gray-900 font-bold">Pilih Kursi & Pemesanan</span>
        </nav>

        <a href="{{ route('film.show', $schedule->film->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 hover:text-brand-600">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Ganti Jadwal / Studio</span>
        </a>
    </div>

    <!-- Booking Grid: Left (Seat Map) & Right (Form + Summary) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT COLUMN: Interactive Seat Map (8 Cols) -->
        <div class="lg:col-span-7 xl:col-span-8 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 space-y-8">
            
            <!-- Movie & Schedule Quick Header -->
            <div class="flex items-center gap-4 pb-6 border-b border-gray-100">
                <img src="{{ $schedule->film->poster_url }}" 
                     alt="{{ $schedule->film->title }}" 
                     class="w-14 h-20 object-cover rounded-xl shadow-md flex-shrink-0">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-brand-50 text-brand-600 uppercase tracking-wider">
                        {{ $schedule->studio_name }}
                    </span>
                    <h1 class="text-xl font-extrabold text-gray-900 mt-1">{{ $schedule->film->title }}</h1>
                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mt-1 font-medium">
                        <span><i class="fa-regular fa-calendar text-brand-500 mr-1"></i> {{ $schedule->formatted_date }}</span>
                        <span>&bull;</span>
                        <span><i class="fa-regular fa-clock text-brand-500 mr-1"></i> {{ $schedule->time }} WIB</span>
                        <span>&bull;</span>
                        <span><i class="fa-solid fa-tag text-brand-500 mr-1"></i> {{ $schedule->formatted_price }} / tiket</span>
                    </div>
                </div>
            </div>

            <!-- Cinema Screen Visualization -->
            <div class="relative py-4 text-center">
                <div class="relative mx-auto max-w-lg">
                    <!-- Curved glow effect for cinema screen -->
                    <div class="h-3 bg-gradient-to-r from-transparent via-brand-500 to-transparent rounded-t-full shadow-[0_-8px_25px_rgba(220,38,38,0.35)]"></div>
                    <div class="h-1 bg-gradient-to-r from-gray-200 via-gray-400 to-gray-200 rounded-full mt-1"></div>
                    <span class="text-[11px] font-extrabold uppercase tracking-[0.3em] text-gray-400 block mt-2">
                        LAYAR BIOSKOP (SCREEN)
                    </span>
                </div>
            </div>

            <!-- Seat Map Layout -->
            <div class="overflow-x-auto pb-4">
                <div class="min-w-[480px] max-w-xl mx-auto space-y-3">
                    
                    @foreach($rows as $row)
                        <div class="flex items-center justify-center gap-2 sm:gap-3">
                            
                            <!-- Left Row Label -->
                            <span class="w-6 text-center text-xs font-black text-gray-400">{{ $row }}</span>

                            <!-- Left Block: Seats 1 to 4 -->
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                @foreach([1, 2, 3, 4] as $col)
                                    @php $seatId = $row . $col; @endphp
                                    <button type="button" 
                                            @click="toggleSeat('{{ $seatId }}')"
                                            :disabled="isBooked('{{ $seatId }}')"
                                            :title="isBooked('{{ $seatId }}') ? 'Kursi {{ $seatId }} sudah dipesan' : 'Kursi {{ $seatId }}'"
                                            :class="{
                                                'bg-gray-200 text-gray-400 border-gray-300 cursor-not-allowed opacity-70': isBooked('{{ $seatId }}'),
                                                'bg-brand-600 text-white border-brand-600 shadow-md shadow-brand-600/40 scale-105': isSelected('{{ $seatId }}'),
                                                'bg-white text-gray-700 border-gray-300 hover:border-brand-500 hover:bg-brand-50': !isBooked('{{ $seatId }}') && !isSelected('{{ $seatId }}')
                                            }"
                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl border text-xs sm:text-sm font-bold flex items-center justify-center transition-all duration-150 transform active:scale-95">
                                        <template x-if="isBooked('{{ $seatId }}')">
                                            <i class="fa-solid fa-xmark text-[10px]"></i>
                                        </template>
                                        <template x-if="isSelected('{{ $seatId }}')">
                                            <i class="fa-solid fa-check text-[11px]"></i>
                                        </template>
                                        <template x-if="!isBooked('{{ $seatId }}') && !isSelected('{{ $seatId }}')">
                                            <span>{{ $seatId }}</span>
                                        </template>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Cinema Center Aisle (Gang Tengah Bioskop) -->
                            <div class="w-6 sm:w-8 text-center">
                                <span class="text-[9px] text-gray-300 font-bold uppercase tracking-widest block">&bull;</span>
                            </div>

                            <!-- Right Block: Seats 5 to 8 -->
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                @foreach([5, 6, 7, 8] as $col)
                                    @php $seatId = $row . $col; @endphp
                                    <button type="button" 
                                            @click="toggleSeat('{{ $seatId }}')"
                                            :disabled="isBooked('{{ $seatId }}')"
                                            :title="isBooked('{{ $seatId }}') ? 'Kursi {{ $seatId }} sudah dipesan' : 'Kursi {{ $seatId }}'"
                                            :class="{
                                                'bg-gray-200 text-gray-400 border-gray-300 cursor-not-allowed opacity-70': isBooked('{{ $seatId }}'),
                                                'bg-brand-600 text-white border-brand-600 shadow-md shadow-brand-600/40 scale-105': isSelected('{{ $seatId }}'),
                                                'bg-white text-gray-700 border-gray-300 hover:border-brand-500 hover:bg-brand-50': !isBooked('{{ $seatId }}') && !isSelected('{{ $seatId }}')
                                            }"
                                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl border text-xs sm:text-sm font-bold flex items-center justify-center transition-all duration-150 transform active:scale-95">
                                        <template x-if="isBooked('{{ $seatId }}')">
                                            <i class="fa-solid fa-xmark text-[10px]"></i>
                                        </template>
                                        <template x-if="isSelected('{{ $seatId }}')">
                                            <i class="fa-solid fa-check text-[11px]"></i>
                                        </template>
                                        <template x-if="!isBooked('{{ $seatId }}') && !isSelected('{{ $seatId }}')">
                                            <span>{{ $seatId }}</span>
                                        </template>
                                    </button>
                                @endforeach
                            </div>

                            <!-- Right Row Label -->
                            <span class="w-6 text-center text-xs font-black text-gray-400">{{ $row }}</span>

                        </div>
                    @endforeach

                </div>
            </div>

            <!-- Seat Status Legend -->
            <div class="pt-4 border-t border-gray-100 flex flex-wrap items-center justify-center gap-6 text-xs font-semibold text-gray-600">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-white border border-gray-300"></span>
                    <span>Tersedia</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-brand-600 text-white flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </span>
                    <span>Dipilih Anda</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-gray-200 border border-gray-300 text-gray-400 flex items-center justify-center">
                        <i class="fa-solid fa-xmark text-[10px]"></i>
                    </span>
                    <span>Terisi (Sudah Dipesan)</span>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: Customer Details Form & Live Summary (4-5 Cols) -->
        <div class="lg:col-span-5 xl:col-span-4 space-y-6 lg:sticky lg:top-24">
            
            <form action="{{ route('booking.store', $schedule->id) }}" 
                  method="POST" 
                  @submit="return validateBeforeSubmit($event)"
                  class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-gray-100 space-y-6">
                @csrf

                <!-- Hidden Input with Selected Seats CSV -->
                <input type="hidden" name="selected_seats" :value="selectedSeats.join(',')">

                <div>
                    <h2 class="text-lg font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-user text-brand-600 text-base"></i>
                        Data Pemesan Tiket
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">E-Ticket dan kode booking akan dikirimkan ke kontak ini.</p>
                </div>

                <!-- Input Fields -->
                <div class="space-y-4 text-sm">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="customer_name" class="block font-bold text-gray-700 mb-1 text-xs uppercase tracking-wider">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               id="customer_name" 
                               name="customer_name" 
                               value="{{ old('customer_name') }}"
                               required
                               placeholder="Contoh: Budi Pratama" 
                               class="w-full px-4 py-2.5 rounded-xl border @error('customer_name') border-rose-500 bg-rose-50/50 @else border-gray-200 @enderror text-gray-900 text-sm focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all">
                        @error('customer_name')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="customer_email" class="block font-bold text-gray-700 mb-1 text-xs uppercase tracking-wider">
                            Alamat Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" 
                               id="customer_email" 
                               name="customer_email" 
                               value="{{ old('customer_email') }}"
                               required
                               placeholder="Contoh: budi@gmail.com" 
                               class="w-full px-4 py-2.5 rounded-xl border @error('customer_email') border-rose-500 bg-rose-50/50 @else border-gray-200 @enderror text-gray-900 text-sm focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all">
                        @error('customer_email')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor HP / WA -->
                    <div>
                        <label for="customer_phone" class="block font-bold text-gray-700 mb-1 text-xs uppercase tracking-wider">
                            Nomor WhatsApp / HP <span class="text-rose-500">*</span>
                        </label>
                        <input type="tel" 
                               id="customer_phone" 
                               name="customer_phone" 
                               value="{{ old('customer_phone') }}"
                               required
                               placeholder="Contoh: 081234567890" 
                               class="w-full px-4 py-2.5 rounded-xl border @error('customer_phone') border-rose-500 bg-rose-50/50 @else border-gray-200 @enderror text-gray-900 text-sm focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all">
                        @error('customer_phone')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- REAL-TIME ORDER SUMMARY (No Reload) -->
                <div class="pt-5 border-t border-gray-100 space-y-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ringkasan Pesanan Real-Time</h3>

                    <!-- Kursi Dipilih Badges -->
                    <div class="bg-gray-50 p-3.5 rounded-2xl border border-gray-100">
                        <span class="text-xs text-gray-500 block mb-1.5 font-medium">Kursi yang Dipilih:</span>
                        
                        <template x-if="selectedSeats.length > 0">
                            <div class="flex flex-wrap gap-1.5">
                                <template x-for="seat in selectedSeats" :key="seat">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-brand-600 text-white text-xs font-extrabold shadow-sm">
                                        <span x-text="seat"></span>
                                        <button type="button" @click="toggleSeat(seat)" class="text-white/80 hover:text-white">
                                            <i class="fa-solid fa-xmark text-[10px]"></i>
                                        </button>
                                    </span>
                                </template>
                            </div>
                        </template>

                        <template x-if="selectedSeats.length === 0">
                            <span class="text-xs italic text-gray-400 flex items-center gap-1.5">
                                <i class="fa-solid fa-hand-pointer text-brand-500"></i>
                                Klik kursi pada denah bioskop untuk memilih
                            </span>
                        </template>
                    </div>

                    <!-- Breakdown Table -->
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between text-gray-600">
                            <span>Jumlah Tiket:</span>
                            <span class="font-bold text-gray-900" x-text="selectedSeats.length + ' Kursi'"></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Harga Satuan:</span>
                            <span class="font-bold text-gray-900">{{ $schedule->formatted_price }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Layanan Bioskop:</span>
                            <span class="font-bold text-emerald-600">GRATIS (Rp 0)</span>
                        </div>
                        <div class="pt-2 border-t border-gray-200 flex justify-between items-baseline text-sm">
                            <span class="font-extrabold text-gray-900">Total Pembayaran:</span>
                            <span class="text-xl font-black text-brand-600" x-text="formatRupiah(total)"></span>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            :disabled="selectedSeats.length === 0"
                            :class="selectedSeats.length === 0 ? 'bg-gray-300 cursor-not-allowed opacity-70' : 'bg-brand-600 hover:bg-brand-700 active:scale-[0.98] shadow-lg shadow-brand-600/30'"
                            class="w-full py-3.5 px-4 rounded-2xl text-white font-extrabold text-sm transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>Konfirmasi & Pesan Tiket</span>
                        <template x-if="selectedSeats.length > 0">
                            <span x-text="'(' + selectedSeats.length + ' Kursi)'" class="text-white/80 font-normal text-xs"></span>
                        </template>
                    </button>
                    <p class="text-[11px] text-gray-400 text-center mt-2">
                        <i class="fa-solid fa-lock text-[10px] mr-1"></i> Transaksi dienkripsi secara aman & instan
                    </p>
                </div>

            </form>

        </div>

    </div>

</div>
@endsection

