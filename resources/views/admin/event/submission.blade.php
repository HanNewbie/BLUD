@extends('layouts.sidebar')

@section('content')
<main class="p-6 bg-gray-50 flex-1">
    <div class="mb-6">
        <h3 class="text-2xl font-semibold mb-2">Edit Data Submission</h3>
    </div>

    <div class="bg-white p-5 rounded-lg shadow max-w-6xl mx-auto">
        <form action="{{ route('submission.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama PIC --}}
            <div class="mb-4 flex items-center">
                <label for="namePIC" class="w-1/4 font-medium">Nama PIC</label>
                <input type="text" name="namePIC" id="namePIC" 
                    value="{{ old('namePIC', $submission->namePIC) }}"
                    class="w-3/4 border px-4 py-2 rounded-lg focus:outline-none focus:ring focus:ring-blue-300 bg-gray-100"
                    placeholder="Nama PIC" 
                    required
                    readonly>
            </div>


            {{-- No HP --}}
            <div class="mb-4 flex items-center">
                <label for="no_hp" class="w-1/4 font-medium">No. HP</label>
                <input type="text" name="no_hp" id="no_hp" 
                    value="{{ old('no_hp', $submission->no_hp) }}"
                    class="w-3/4 border px-4 py-2 rounded-lg focus:outline-none focus:ring focus:ring-blue-300 bg-gray-100"
                    placeholder="Nomor HP" required readonly>
            </div>

            {{-- Alamat --}}
            <div class="mb-4 flex items-center">
                <label for="address" class="w-1/4 font-medium">Alamat Instansi</label>
                <input type="text" name="address" id="address" 
                    value="{{ old('address', $submission->address) }}"
                    class="w-3/4 border px-4 py-2 rounded-lg focus:outline-none focus:ring focus:ring-blue-300 bg-gray-100"
                    placeholder="Alamat lengkap" required readonly>
            </div>

            {{-- Vendor --}}
            <div class="mb-4 flex items-center">
                <label for="vendor" class="w-1/4 font-medium">Vendor / Instansi</label>
                <input type="text" name="vendor" id="vendor" 
                    value="{{ old('vendor', $submission->vendor) }}"
                    class="w-3/4 border px-4 py-2 rounded-lg focus:outline-none focus:ring focus:ring-blue-300 bg-gray-100"
                    placeholder="Vendor / Instansi" required readonly>
            </div>

            {{-- Lokasi --}}
            <div class="mb-4 flex items-center">
    <label for="location" class="w-1/4 font-medium">Lokasi</label>
    
    <!-- Select readonly -->
    <select id="location" disabled
        class="w-3/4 border px-4 py-2 rounded-lg bg-gray-100">
        @foreach($contents as $ctn)
            <option value="{{ $ctn->name }}" {{ $submission->location == $ctn->name ? 'selected' : '' }}>
                {{ $ctn->name }}
            </option>
        @endforeach
    </select>

    <!-- Hidden input agar tetap dikirim saat submit -->
    <input type="hidden" name="location" value="{{ $submission->location }}">
</div>


            {{-- Tanggal --}}
            <div class="mb-4 flex items-center">
                <label class="w-1/4 font-medium">Tanggal</label>
                <div class="w-3/4 flex gap-2">
                    <input type="date" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($submission->start_date)->format('Y-m-d')) }}"
                        class="w-1/2 border px-4 py-2 rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
                    <input type="date" name="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($submission->end_date)->format('Y-m-d')) }}"
                        class="w-1/2 border px-4 py-2 rounded-lg focus:outline-none focus:ring focus:ring-blue-300" required>
                </div>
            </div>

            {{-- Nama Event --}}
            <div class="mb-4 flex items-center">
                <label for="name_event" class="w-1/4 font-medium">Nama Event</label>
                <input type="text" name="name_event" id="name_event" value="{{ old('name_event', $submission->name_event) }}"
                    class="w-3/4 border px-4 py-2 rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
                    placeholder="Nama Event" required>
            </div>

            {{-- Upload File --}}
            @php
                $files = [
                    'file' => 'Proposal (PDF)',
                    'ktp' => 'KTP (PDF)',
                    'appl_letter' => 'Surat Pengajuan (PDF)',
                    'actv_letter' => 'Surat Kegiatan/Rundown (PDF)',
                ];
            @endphp

            @foreach($files as $field => $label)
            <div class="mb-4 flex items-center">
                <label for="{{ $field }}" class="w-1/4 font-medium">Upload {{ $label }}</label>
                <div class="w-3/4 flex items-center gap-4">
                    <input type="file" name="{{ $field }}" id="{{ $field }}" accept="application/pdf"
                        class="flex-1 border px-4 py-2 rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
                    @if($submission->$field)
                        <a href="{{ asset('storage/' . $submission->$field) }}" target="_blank" class="text-blue-500 hover:underline">
                            Lihat {{ $label }}
                        </a>
                    @endif
                </div>
            </div>
            @endforeach

            {{-- Tombol --}}
            <div class="mt-6 flex justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-6 py-2 rounded-md">
                    Simpan Perubahan
                </button>
                <a href="{{ route('event.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium px-6 py-2 rounded-md">
                    Kembali
                </a>
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
