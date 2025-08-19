@extends('layouts.info')

@section('title', 'BLUD Pariwisata')
@section('meta_description', 'Website resmi BLUD Pariwisata Baturraden. Informasi wisata, jadwal acara, dan booking online di Banyumas.')

@section('content')
<div class="relative w-full h-[400px]">
    <img 
        src="{{ asset('assets/img/bg-hero.png') }}" 
        alt="hero" 
        class="w-full h-full object-cover brightness-75" 
    />
    <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="text-white text-center text-xl md:text-3xl font-bold px-4">
            Selamat Datang,<br />
            <span class="font-extrabold">
                Bersama BLUD Pariwisata, Eksplorasi Banyumas Lebih Dekat!
            </span>
        </h1>
    </div>
</div>

<div class="bg-white rounded-xl p-6 shadow text-justify text-sm md:w-[80%] md:mx-auto">
    <p class="mb-4">
        <strong>Badan Layanan Umum Daerah (BLUD) Lokawisata Baturraden</strong><br />
        BLUD UPT Lokawisata Baturraden merupakan Unit Pelaksana Teknis (UPT) di bawah 
        Dinas Pemuda, Olahraga, Kebudayaan, dan Pariwisata Kabupaten Banyumas. UPT ini 
        menerapkan sistem pengelolaan keuangan Badan Layanan Umum Daerah (BLUD) dan aset daerah, 
        yang memberikan fleksibilitas pengelolaan keuangan untuk mendukung pelayanan publik 
        yang lebih efisien dan profesional.
    </p>

    <p class="mb-4">
        BLUD ini dibentuk pada tahun 2022 berdasarkan 
        <em>Peraturan Bupati Banyumas Nomor 78 Tahun 2021</em>. 
        Tujuannya adalah untuk mempercepat dan mengoptimalkan mekanisme pembiayaan serta 
        penanganan pengelolaan destinasi wisata di Kabupaten Banyumas.
    </p>

    <p class="mb-4">
        Unit ini mengelola sejumlah objek wisata strategis yang menjadi aset daerah, yaitu:
    </p>

    <ul class="list-disc list-inside space-y-1">
         @foreach($contents as $content)
        <li>{{ $content->name }}</li>
    @endforeach
    </ul>
    
    <div class="mt-6 overflow-x-auto whitespace-nowrap">
      <div class="inline-flex gap-4 px-2">
        @forelse ($contents as $item)
          <img 
            src="{{ asset('storage/' . $item->image) }}" 
            alt="{{ $item->name }}" 
            class="h-36 w-44 object-cover rounded-lg shadow-md"
          />
        @empty
          <p class="text-gray-500 italic">Belum ada gambar tersedia.</p>
        @endforelse
      </div>
    </div>
</div>

<section class="py-6 px-4 sm:px-6 lg:px-8">
  <div>
    <h1 class="bg-primary mx-auto w-max text-center px-8 py-2 rounded-2xl uppercase text-white font-bold text-base">
      Kabar Banyumas
    </h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
      @forelse ($news as $item)
        <a 
          href="{{ $item->source }}" 
          target="_blank"
          class="border rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300 bg-white flex flex-col"
        >
          <img 
            class="w-full h-48 md:h-40 object-cover" 
            src="{{ asset('storage/' . $item->image) }}" 
            alt="{{ $item->title }}" 
          />
          <div class="p-4 flex flex-col gap-2 flex-grow">
            <h2 class="font-bold text-base md:text-lg">{{ $item->title }}</h2>
            <h3 class="text-sm text-gray-500">
              {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('l, d F Y H:i') }} WIB
            </h3>
            <p class="text-justify text-sm text-gray-700">
              {{ $item->content }}
            </p>
          </div>
        </a>
      @empty
        <p class="text-center text-gray-500 mt-6 w-full col-span-full">Belum ada berita tersedia.</p>
      @endforelse
    </div>
  </div>
</section>


@endsection
