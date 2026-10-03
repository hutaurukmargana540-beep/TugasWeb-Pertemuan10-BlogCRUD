<!doctype html>
{{-- ==================================================================
     REQ 3: Blade layout master — halaman lain memakai @extends('layouts.app')
            dan mengisi @section('content').
     Styling: Tailwind CDN (tanpa build step), sama seperti TR 9.
     ================================================================== --}}
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Blog CRUD') · Blog CRUD</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
  <nav class="border-b border-slate-800 bg-slate-900/60">
    <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
      <a href="{{ route('posts.index') }}" class="font-bold text-lg tracking-tight">
        Blog<span class="text-lime-400">CRUD</span>
      </a>
      <div class="flex items-center gap-5 text-sm font-medium">
        <a href="{{ route('posts.index') }}"
           class="hover:text-pink-400 {{ request()->routeIs('posts.index') ? 'text-pink-400' : 'text-slate-300' }}">Semua Post</a>
        <a href="{{ route('posts.trash') }}"
           class="hover:text-pink-400 {{ request()->routeIs('posts.trash') ? 'text-pink-400' : 'text-slate-300' }}">Tempat Sampah</a>
        <a href="{{ route('posts.create') }}"
           class="rounded-lg bg-pink-500 px-4 py-2 text-white hover:bg-pink-400">Tulis Post</a>
      </div>
    </div>
  </nav>

  <main class="max-w-5xl mx-auto px-6 py-10">
    {{-- REQ 6: flash message sukses / gagal, ditampilkan lewat komponen <x-alert> --}}
    @if (session('success'))
      <x-alert type="success">{{ session('success') }}</x-alert>
    @endif
    @if (session('error'))
      <x-alert type="error">{{ session('error') }}</x-alert>
    @endif
    @if ($errors->any())
      <x-alert type="error">Periksa kembali isian form — ada {{ $errors->count() }} kesalahan.</x-alert>
    @endif

    @yield('content')
  </main>

  <footer class="max-w-5xl mx-auto px-6 py-8 text-center text-xs text-slate-500">
    Tugas Rutin 10 — Blog CRUD Laravel · Pemrograman Web · Hardiman G. Hutauruk
  </footer>
</body>
</html>
