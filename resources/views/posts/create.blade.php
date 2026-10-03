@extends('layouts.app')

@section('title', 'Tulis Post')

@section('content')
  <h1 class="mb-8 text-3xl font-extrabold">Tulis Post Baru</h1>

  {{-- REQ 7: @csrf wajib di semua form; enctype untuk upload gambar --}}
  <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="max-w-2xl">
    @csrf
    @include('posts._form')
  </form>
@endsection
