@extends('layouts.info')

@section('title', 'BLUD Pariwisata')
@section('meta_description', 'Website resmi BLUD Pariwisata Baturraden. Informasi wisata, jadwal acara, dan booking online di Banyumas.')

@section('content')
<section class="max-w-5xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold text-center mb-1">Harga Sewa Tempat</h2>
    <p class="text-center text-gray-600 mb-6">Pricelist Sewa Area {{ $content->name }}</p>

    <!-- Tabel Harga -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse border-spacing-y-2">
            <thead>
                <tr class="bg-primary text-white text-sm">
                    <th class="px-4 py-2 rounded-l-lg">BAGIAN</th>
                    <th class="px-4 py-2">LUAS</th>
                    <th class="px-4 py-2 rounded-r-lg">HARGA</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-800 border-b border-gray-400">
                @foreach ($facilities->where('type', 'price') as $item)
                <tr class="border-b border-gray-400">
                    <td class="px-4 py-2 font-medium">{{ $item->bagian }}</td>
                    <td class="px-4 py-2">{{ $item->luas }}</td>
                    <td class="px-4 py-2">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Fasilitas -->
    <div class="mt-10">
        <h3 class="text-lg font-bold text-center mb-4">Fasilitas</h3>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach ($facilities->where('type', 'facility') as $item)
            <div class="bg-blue-400 text-white px-4 py-4 rounded-lg text-sm text-center w-32">
                {{ $item->facility_name }}
            </div>
            @endforeach
        </div>
    </div>

    <div class="py-4">
            <div class="bg-secondary text-start p-4 rounded-lg flex justify-between">
                <div class="text-xs w-1/2 font-semibold">
                    <p>Tunggu Apalagi?</p>
                    <p>Ayo Ajukan Formulir Sewa Tempat Sekarang!</p>
                </div>
                <a href="{{route('submission')}}"
                    class="bg-primary text-white px-4 py-2 rounded-full text-xs flex items-center">
                    <p>Isi Formulir</p>
                </a>
            </div>
        </div>
</section>
@endsection
