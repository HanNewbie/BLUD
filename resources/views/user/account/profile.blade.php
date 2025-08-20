@extends('layouts.info')

@section('content')
<div x-data="{ open: false }" class="max-w-3xl mx-auto py-16 px-6">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-400 p-6 text-white text-center relative">
            <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-white">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                     alt="Avatar" class="w-full h-full object-cover">
            </div>
            <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>

            <button @click="open = true"
                class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-blue-600 p-2.5 rounded-full shadow-md 
                    hover:bg-blue-600 hover:text-white transition duration-200 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.651 1.651a2.121 2.121 0 010 3l-7.07 7.071-4.243.707.707-4.243 
                            7.07-7.071a2.121 2.121 0 013 0z" />
                </svg>
            </button>
        </div>

        <div class="p-8 grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">
            <div>
                <p class="text-sm font-medium text-gray-500">Username</p>
                <p class="text-lg font-semibold">{{ Auth::user()->username }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Email</p>
                <p class="text-lg font-semibold">{{ Auth::user()->email }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                <p class="text-lg font-semibold">{{ Auth::user()->name }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Nomor HP</p>
                <p class="text-lg font-semibold">{{ Auth::user()->phone ?? 'Belum diisi' }}</p>
            </div>
        </div>
    </div>

    <div x-show="open" x-cloak
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
         x-transition>
        <div class="bg-white rounded-xl shadow-lg max-w-lg w-full p-6">
            <h3 class="text-xl font-bold mb-4">Edit Profil</h3>

<form action="{{ route('profile.update') }}" method="POST" class="space-y-4" onsubmit="return validateForm()">
    @csrf

    <div>
        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
               class="w-full border px-4 py-2 rounded">
        <p id="error-name" class="text-sm text-red-600 mt-1"></p>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
               class="w-full border px-4 py-2 rounded">
        <p id="error-email" class="text-sm text-red-600 mt-1"></p>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
        <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
               class="w-full border px-4 py-2 rounded">
        <p id="error-phone" class="text-sm text-red-600 mt-1"></p>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Ganti Password (opsional)</label>
        <input type="password" name="password" placeholder="Masukkan password baru"
               class="w-full border px-4 py-2 rounded">
        <p class="text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah password.</p>
        <p id="error-password" class="text-sm text-red-600 mt-1"></p>
    </div>

    <div class="flex justify-end space-x-2 pt-4">
        <button type="button" @click="open = false"
                class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
    </div>
</form>

        </div>
    </div>
</div>

@push('scripts')

<script>
     window.addEventListener('pageshow', function (event) {
            if (event.persisted || window.performance.getEntriesByType("navigation")[0]?.type === "back_forward") {
                return;
            }
            @if(session('error'))
            Swal.fire({
                title: "Gagal!",
                text: @json(session('error')),
                icon: "error",
                confirmButtonColor: "#d33"
            });
            @endif

            @if(session('success'))
            Swal.fire({
                title: "Berhasil!",
                text: @json(session('success')),
                icon: "success",
                confirmButtonColor: "#3085d6"
            });
            @endif
        });

function validateForm() {
    // reset error
    document.getElementById("error-name").textContent = "";
    document.getElementById("error-email").textContent = "";
    document.getElementById("error-phone").textContent = "";
    document.getElementById("error-password").textContent = "";

    const name = document.querySelector('input[name="name"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const phone = document.querySelector('input[name="phone"]').value.trim();
    const password = document.querySelector('input[name="password"]').value;

    let valid = true;

    // Validasi Nama
    if (name.length < 3) {
        document.getElementById("error-name").textContent = "Nama minimal 3 karakter.";
        valid = false;
    }

    // Validasi Email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById("error-email").textContent = "Format email tidak valid.";
        valid = false;
    }

    // Validasi Nomor HP (opsional, jika diisi)
    const phoneRegex = /^(08|628)[0-9]{8,18}$/;
    if (phone && !phoneRegex.test(phone)) {
        document.getElementById("error-phone").textContent = "Nomor HP harus diawali 08 atau 628 dan minimal 10 digit.";
        valid = false;
    }

    // Validasi Password (opsional)
    if (password && password.length < 8) {
        document.getElementById("error-password").textContent = "Password minimal 8 karakter.";
        valid = false;
    }

    return valid;
}

</script>

<script src="https://unpkg.com/alpinejs" defer></script>
@endpush
@endsection
