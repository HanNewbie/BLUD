@extends('layouts.info')

@section('title', 'BLUD Pariwisata')
@section('meta_description', 'Website resmi BLUD Pariwisata Baturraden. Informasi wisata, jadwal acara, dan booking online di Banyumas.')

@section('content')
<section class="py-10 px-6">
    <h1 class="bg-primary mx-auto w-max text-center px-8 py-2 rounded-2xl uppercase text-white font-bold text-lg mb-8">
        Jadwal Booking
    </h1> 
      <h2 class="text-center font-semibold text-xl">{{ ucfirst($bulan) }}</h2>
        <div class="max-w-5xl mx-auto">
            @forelse($events as $ev)
                <div class="mt-12 border rounded-lg p-6 relative">
                    <div class="absolute left-[-1px] top-[-30px] font-bold text-sm bg-primary w-max py-4 px-8 text-white rounded-lg">
                        {{ \Carbon\Carbon::parse($ev->start_date)->translatedFormat('d') }} -
                        {{ \Carbon\Carbon::parse($ev->end_date)->translatedFormat('d F Y') }}
                    </div>

                    <h3 class="font-semibold text-lg mt-6">
                        {{ $ev->name_event }}
                    </h3>

                    <p class="text-gray-700 mt-2">
                        {{ $ev->vendor}}
                    </p>

                    {{-- Rundown jika ada --}}
                    @if($ev->file)
                        <div class="flex items-center gap-2 mt-4">
                            <img src="{{ asset('assets/svg/pdf.svg') }}" alt="PDF" class="w-6 h-6">
                            <a href="{{ asset('storage/' . $ev->actv_letter) }}" 
                               target="_blank" 
                               class="text-red-600 font-semibold hover:underline">
                                Lihat Rundown
                            </a>
                        </div>
                        @else
                            <p class="text-sm italic text-gray-500">Rundown tidak tersedia.</p>
                    @endif
                </div>
            @empty
                <p class="mt-4 text-gray-500 text-center">
                    Tidak ada event di bulan ini.
                </p>
            @endforelse
        </div>
    </section>
@endsection
