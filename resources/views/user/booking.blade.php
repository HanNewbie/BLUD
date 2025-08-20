@extends('layouts.info')

@section('title', 'BLUD Pariwisata')
@section('meta_description', 'Website resmi BLUD Pariwisata Baturraden. Informasi wisata, jadwal acara, dan booking online di Banyumas.')

@section('content')
<section class="py-8 px-4 sm:py-10 sm:px-6">
    <h1 class="bg-primary mx-auto w-max text-center px-6 sm:px-8 py-2 rounded-2xl uppercase text-white font-bold text-base sm:text-lg mb-6 sm:mb-8">
        Jadwal Booking
    </h1> 

    <div class="max-w-5xl mx-auto">
        @forelse($events as $bulan => $items)
            <a href="{{ route('booking.detail', ['slug' => $slug, 'bulan' => strtolower($bulan)]) }}" 
               class="block mt-6 sm:mt-8 border rounded-lg p-3 sm:p-4 relative hover:shadow-md transition duration-200 bg-white">

                {{-- Label Bulan --}}
                <div class="absolute -top-3 left-3 sm:-top-4 sm:left-4 bg-primary text-white font-bold text-xs sm:text-sm px-3 sm:px-4 py-1 sm:py-2 rounded-lg pointer-events-none shadow">
                    {{ $bulan }}
                </div>

                {{-- List Event --}}
                @foreach($items as $ev)
                    <div class="flex flex-col sm:flex-row mt-6 sm:mt-8">
                        <div class="flex flex-col sm:flex-col sm:gap-4">
                            <span class="bg-gray-100 text-xs sm:text-sm px-3 py-1 rounded-full font-semibold text-center">
                                {{ \Carbon\Carbon::parse($ev->start_date)->translatedFormat('d F') }}
                                -
                                {{ \Carbon\Carbon::parse($ev->end_date)->translatedFormat('d F Y') }}
                            </span>
                            <span class="font-semibold text-sm sm:text-base mt-2 sm:mt-0">{{ $ev->name_event }}</span>
                        </div>
                    </div>
                @endforeach

                {{-- Panah Next --}}
                <div class="flex justify-end mt-4">
                    <img src="{{ asset('assets/svg/arrow-next.svg') }}" alt="Next" class="w-4 sm:w-5">
                </div>
            </a>
        @empty
            <p class="mt-4 text-gray-500 text-center text-sm sm:text-base">Belum ada event yang terjadwal.</p>
        @endforelse
    </div>
</section>
@endsection
