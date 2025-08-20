<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daftar - BLUD Pariwisata</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/svg/logo.svg') }}">

</head>
<body class="min-h-screen bg-cover bg-center bg-no-repeat flex items-center justify-center px-4" style="background-image: url('{{ asset('assets/img/menara.jpg') }}');">

  <div class="bg-white/90 backdrop-blur-md p-6 md:p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Daftar Akun</h2>

    @if ($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5 text-sm">
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}" class="flex flex-col gap-4">
    @csrf

    {{-- Nama Lengkap --}}
    <div>
        <label class="block text-sm text-gray-600 mb-1" for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" required value="{{ old('name') }}"
            class="w-full px-4 py-2 rounded-lg border 
            @error('name') border-red-500 @else border-gray-300 @enderror 
            focus:ring-2 focus:ring-blue-400 focus:outline-none">
        @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nomor HP --}}
    <div>
        <label class="block text-sm text-gray-600 mb-1" for="phone">Nomor HP</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
            class="w-full px-4 py-2 rounded-lg border 
            @error('phone') border-red-500 @else border-gray-300 @enderror 
            focus:ring-2 focus:ring-blue-400 focus:outline-none">
        @error('phone')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm text-gray-600 mb-1" for="email">Email</label>
        <input type="email" id="email" name="email" required value="{{ old('email') }}"
            class="w-full px-4 py-2 rounded-lg border 
            @error('email') border-red-500 @else border-gray-300 @enderror 
            focus:ring-2 focus:ring-blue-400 focus:outline-none">
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-600 mb-1" for="password">Password</label>
        <input type="password" id="password" name="password" required
            class="w-full px-4 py-2 rounded-lg border 
            @error('password') border-red-500 @else border-gray-300 @enderror 
            focus:ring-2 focus:ring-blue-400 focus:outline-none">
        @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm text-gray-600 mb-1" for="password_confirmation">Konfirmasi Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required
            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none">
    </div>

    <button type="submit"
        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
        Daftar
    </button>
</form>


      <div class="my-4 relative">
      <div class="absolute inset-0 flex items-center">
      <div class="w-full border-t border-gray-300"></div>
      </div>
      <div class="relative flex justify-center text-sm">
      <span class="bg-white px-2 text-gray-500">atau daftar dengan</span>
      </div>
      </div>

      <a href="{{ route('google.login') }}" 
         class="flex items-center justify-center gap-3 border border-gray-300 bg-white text-gray-700 hover:bg-gray-100 hover:shadow-md font-semibold py-2 px-4 rounded-lg transition duration-200">
      <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
      <span class="text-sm">Daftar dengan Google</span>
      </a>

      <p class="text-sm text-center text-gray-600 mt-4">
         Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:underline">Masuk</a>
      </p>
      </div>

</body>
</html>
