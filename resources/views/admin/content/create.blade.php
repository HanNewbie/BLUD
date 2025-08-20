@extends('layouts.sidebar')

@section('content')
<main class="p-6 bg-gray-50 flex-1 overflow-y-auto">
    <div class="mb-6">
        <h3 class="text-2xl font-semibold mb-2">Tambah Tempat Wisata</h3>
    </div>

    <div class="bg-white p-5 rounded-lg shadow max-w-6xl mx-auto">
        <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nama Tempat --}}
            <div class="mb-4 flex items-center">
                <label for="name" class="w-1/4 font-medium">Nama Tempat</label>
                <input type="text" name="name" id="name" class="border px-4 py-2 rounded-lg w-3/4" value="{{ old('name') }}" required>
            </div>

            <div class="mb-4 flex items-center">
                <label for="medsos" class="w-1/4 font-medium">Sosial Media</label>
                <div class="flex gap-4 w-3/4">
                    <div class="flex flex-col w-1/2">
                        <label for="instagram" class="text-sm font-medium mb-1">Instagram</label>
                        <input type="text" name="instagram" id="instagram" 
                            class="border px-4 py-2 rounded-lg w-full" 
                            value="{{ old('instagram') }}" 
                            placeholder="https://instagram.com/username">
                    </div>
                    <div class="flex flex-col w-1/2">
                        <label for="whatsapp" class="text-sm font-medium mb-1">WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" 
                            class="border px-4 py-2 rounded-lg w-full" 
                            value="{{ old('whatsapp') }}" 
                            placeholder="https://wa.me/6281234567890">
                        </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4 flex items-start">
                <label for="description" class="w-1/4 font-medium pt-2">Deskripsi</label>
                <textarea name="description" id="description" rows="3" class="border px-4 py-2 rounded-lg w-3/4" required>{{ old('description') }}</textarea>
            </div>

            {{-- Harga Tiket --}}
            <div class="mb-4 flex items-center">
                <label class="w-1/4 font-medium">Harga Tiket</label>
                <div class="flex items-center gap-2 w-3/4">
                    <div class="w-full">
                        <label for="price_weekday" class="block font-medium mb-1">Weekday</label>
                        <input type="number" name="price_weekday" id="price_weekday"
                            class="border px-4 py-2 rounded-lg w-full" value="{{ old('price_weekday') }}" required>
                    </div>
                    <div class="text-xl font-semibold text-gray-600 pt-6">/</div>
                    <div class="w-full">
                        <label for="price_weekend" class="block font-medium mb-1">Weekend</label>
                        <input type="number" name="price_weekend" id="price_weekend"
                            class="border px-4 py-2 rounded-lg w-full" value="{{ old('price_weekend') }}" required>
                    </div>
                </div>
            </div>
            
            {{-- Jam Operasional --}}
            <div class="mb-4 flex items-center">
                <label class="w-1/4 font-medium">Jam Operasional</label>
                <div class="flex items-center gap-2 w-3/4">
                    <div class="w-full">
                        <label for="open_time" class="block font-medium mb-1">Jam Buka</label>
                        <input type="time" name="open_time" id="open_time" class="border px-4 py-2 rounded-lg w-full" value="{{ old('open_time') }}">
                    </div>
                    <div class="text-xl font-semibold text-gray-600 pt-6">-</div>
                    <div class="w-full">
                        <label for="close_time" class="block font-medium mb-1">Jam Tutup</label>
                        <input type="time" name="close_time" id="close_time" class="border px-4 py-2 rounded-lg w-full" value="{{ old('close_time') }}">
                    </div>
                </div>
            </div>

            {{-- Lokasi --}}
            <div class="mb-4 flex items-center">
                <label for="location" class="w-1/4 font-medium">Lokasi</label>
                <input type="text" name="location" id="location" class="border px-4 py-2 rounded-lg w-3/4" value="{{ old('location') }}" required>
            </div>

            <div class="mb-4 flex items-center">
                <label for="location_embed" class="w-1/4 font-medium">Lokasi GMAPS</label>
                <input type="textarea" placeholder='<iframe src="..."></iframe>' name="location_embed" id="location_embed" class="border px-4 py-2 rounded-lg w-3/4" value="{{ old('location_embed') }}" required>
            </div>

            {{-- Upload Gambar --}}
            <div class="mb-4 flex items-center">
                <label for="image" class="w-1/4 font-medium">Upload Gambar</label>
                <input type="file" name="image" id="image" accept="image/*" class="border px-4 py-2 rounded-lg w-3/4">
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">Simpan</button>
                <a href="{{ route('content.index') }}" class="bg-gray-300 hover:bg-gray-400 px-6 py-2 rounded-md">Kembali</a>
            </div>
        </form>
    </div>
</main>

@if(session('error'))
<script>
    Swal.fire({
        title: "Gagal!",
        text: "{{ session('error') }}",
        icon: "error",
        confirmButtonColor: "#d33"
    });
</script>
@endif
@endsection