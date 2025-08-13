<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  {{-- <link href="assets/css/output.css" rel="stylesheet" /> --}}
  <link rel="stylesheet" href="{{ asset('assets/css/input.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/output.css') }}" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('assets/js/index.js') }}"></script>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/svg/logo.svg') }}">
</head>

<body class="min-h-screen flex flex-col pt-20">
  <!-- Section Header -->
  <header class="bg-white fixed top-0 left-0 right-0 z-20 shadow-sm">
  <nav class="w-full max-w-7xl mx-auto px-5 py-2 flex items-center justify-between">
    
    <!-- Logo -->
    <div>
      <img width="100" src="{{ asset('assets/img/logo blud.png') }}" alt="BLUD" />
    </div>

    <!-- Hamburger & Menu -->
    <div class="relative">
      <!-- Hamburger Button -->
      <button id="hamburger" name="hamburger" type="button" class="block lg:hidden">
        <span class="hamburger-line origin-top-left transition duration-300 ease-in-out"></span>
        <span class="hamburger-line transition duration-300 ease-in-out"></span>
        <span class="hamburger-line origin-bottom-left transition duration-300 ease-in-out"></span>
      </button>

      <!-- Main Navigation -->
      <div id="nav-menu"
           class="absolute right-4 top-full hidden w-full max-w-[250px] rounded-lg bg-white py-5 shadow-lg 
                  lg:static lg:block lg:max-w-full lg:rounded-none lg:bg-transparent lg:shadow-none">
        <ul class="block lg:flex lg:items-center">
          <li class="group">
            <a href="{{ route('home') }}"
               class="mx-4 flex py-2 text-base {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-800' }} hover:text-primary">
              Home
            </a>
          </li>

          <li class="group">
            <a href="{{ route('event') }}"
               class="mx-4 flex py-2 text-base {{ request()->routeIs('event') ? 'text-primary' : 'text-gray-800' }} hover:text-primary">
              Jadwal
            </a>
          </li>

          <li class="group">
            <a href="{{ route('wisata') }}"
               class="mx-4 flex py-2 text-base {{ request()->routeIs('wisata') ? 'text-primary' : 'text-gray-800' }} hover:text-primary">
              Objek Wisata
            </a>
          </li>

          <li class="group">
            <a href="{{ route('submission') }}"
               class="mx-4 flex py-2 text-base {{ request()->routeIs('submission') ? 'text-primary' : 'text-gray-800' }} hover:text-primary">
               Booking 
            </a>
          </li>

          @guest
          <li class="group">
            <a href="{{ route('login') }}"
              class="mx-4 flex items-center justify-center py-2 px-4 text-base font-bold text-blue-400 border border-blue-400 rounded-md hover:bg-blue-400 hover:text-white transition">
              Masuk/Daftar
            </a>
          </li>
          @endguest


          @auth
          <li class="group">
            <a href="{{ route('user.history') }}"
               class="mx-4 flex py-2 text-base {{ request()->routeIs('user.history') ? 'text-primary' : 'text-gray-800' }} hover:text-primary">
               Riwayat Pengajuan
            </a>
          </li>

          <li class="relative">
            <button id="userMenuButton"
                    class="flex items-center gap-2 py-2 px-4 font-bold text-gray-800 hover:text-blue-500 focus:outline-none">
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                   alt="Profile" class="w-8 h-8 rounded-full border" />
            </button>

            <div id="userDropdown"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-md py-2 z-50 hidden">
              <a href="{{ route('profile') }}"
                 class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                  Logout
                </button>
              </form>
            </div>
          </li>
          @endauth
        </ul>
      </div>

      <!-- Sidebar (Mobile) -->
      <div id="sidebar"
           class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300">
        <div class="p-4 border-b flex justify-between items-center">
          <span class="text-lg font-bold">Menu</span>
          <button id="closeBtn" class="text-gray-700 text-xl">&times;</button>
        </div>
        <ul class="p-4 space-y-2">
          <li>
            <a href="{{ route('home') }}" class="block p-2 {{ request()->routeIs('home') ? 'bg-blue-200' : 'hover:bg-gray-100' }} rounded">Home</a>
          </li>
          <li>
            <a href="{{ route('wisata') }}" class="block p-2 {{ request()->routeIs('wisata') ? 'bg-blue-200' : 'hover:bg-gray-100' }} rounded">Objek Wisata</a>
          </li>
          <li>
            <a href="{{ route('event') }}" class="block p-2 {{ request()->routeIs('event') ? 'bg-blue-200' : 'hover:bg-gray-100' }} rounded">Jadwal</a>
          </li>
          <li>
            <a href="{{ route('submission') }}" class="block p-2 {{ request()->routeIs('submission') ? 'bg-blue-200' : 'hover:bg-gray-100' }} rounded">Booking</a>
          </li>
          @guest
          <li class="group">
            <a href="{{ route('login') }}"
              class="mx-4 flex items-center justify-center py-2 px-4 text-base font-bold text-blue-400 border border-blue-400 rounded-md hover:bg-blue-400 hover:text-white transition">
              Masuk/Daftar
            </a>
          </li>
          @endguest

          @auth
          <li class="group">
            <a href="{{ route('user.history') }}"
               class="block p-2 {{ request()->routeIs('user.history') ? 'bg-blue-200' : 'hover:bg-gray-100' }} rounded">
               Riwayat Pengajuan
            </a>
          </li>

          <li class="relative">
            <a href="{{ route('profile') }}"
               class="block p-2 {{ request()->routeIs('profile') ? 'bg-blue-200' : 'hover:bg-gray-100' }} rounded">
               Profile
            </a>
          </li>

          <li class="relative">
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" id="btn-logout"
                        class="block p-2 text-red-600 hover:bg-gray-100">
                        Logout
                </button>
              </form>
          </li>

          @endauth
        </ul>
      </div>
    </div>
  </nav>
</header>


   <main class="flex-1">
            @yield('content')
    </main>

<footer>
    <div class="bg-slate-100 py-4 px-8 lg:flex lg:justify-around">
      <div class="flex items-center space-x-4">
        <img src="{{ asset('assets/img/logo blud.png') }}" alt="BLUD" class="h-14 sm:h-20 object-contain">
        <img src="{{ asset('assets/img/telu.png') }}" alt="Telkom" class="h-14 sm:h-20 object-contain">
      </div>
      <div class="text-primary py-4 flex justify-between flex-wrap gap-4 lg:gap-10">
        <div class="flex flex-col gap-2">
          <h2 class="font-bold text-xl">Link Terkait</h2>
          <p class="font-semibold text-base"><a href="">Home</a></p>
          <p class="font-semibold text-base">
            <a href="objek_wisata.html">Objek Wisata</a>
          </p>
          <p class="font-semibold text-base"><a href="">Jadwal</a></p>
        </div>
        <div class="flex flex-col gap-2">
          <h2 class="font-bold text-xl">Alamat</h2>
          <div class="flex items-start gap-2">
            <img class="text-primary" src="{{ asset('assets/svg/location.svg') }}" alt="Location" />
            <a
              href="https://www.google.com/maps?q=Kantor+BLUD+Pariwisata+Baturraden+Glempang,+Bancarkembar,+Purwokerto+Utara,+Banyumas,+53121"
              target="_blank"
              class="font-semibold text-xs text-justify max-w-[150px] text-primary hover:underline"
            >
              Kantor BLUD Pariwisata Baturraden Glempang, Bancarkembar,
              Purwokerto Utara, Banyumas, 53121
            </a>
          </div>
        </div>
        <div class="flex flex-col gap-2">
          <h2 class="font-bold text-xl">Social Media</h2>
          <div class="flex items-center gap-2">
            <img class="text-primary" src="{{ asset('assets/svg/wa.svg') }}" alt="WhatsApp" />
            <a href="https://wa.me/6281228289422" target="_blank" class="font-semibold text-xs text-primary hover:underline">
              0812-2828-9422
            </a>
          </div>
          <div class="flex items-center gap-2">
            <img class="text-primary" src="{{ asset('assets/svg/instagram.svg') }}" alt="Instagram" />
            <a href="https://instagram.com/bludpariwisata" target="_blank" class="font-semibold text-xs text-primary hover:underline">
              BLUD Pariwisata
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="bg-primary p-4 text-center">
      <p class="text-white font-semibold">
        Copyright© BLUDPariwisata, All rights reserved.
      </p>
    </div>
  </footer>

  <script src="{{ asset('assets/js/index.js') }}"></script>
</body>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
    const userMenuButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');

    if (userMenuButton && userDropdown) {
      userMenuButton.addEventListener('click', function (e) {
        e.stopPropagation();
        userDropdown.classList.toggle('hidden');
      });

      document.addEventListener('click', function (event) {
        if (
          !userDropdown.contains(event.target) &&
          !userMenuButton.contains(event.target)
        ) {
          userDropdown.classList.add('hidden');
        }
      });
    }
  });

  document.getElementById('btn-logout').addEventListener('click', function () {
          Swal.fire({
            title: 'Keluar dari sesi?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, logout',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            confirmButtonColor: '#ef4444' // opsional
          }).then((result) => {
            if (result.isConfirmed) {
              document.getElementById('logout-form').submit();
            }
          });
        });
</script>



</html>