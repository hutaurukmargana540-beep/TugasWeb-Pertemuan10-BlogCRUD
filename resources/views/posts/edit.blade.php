@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
  <h1 class="mb-8 text-3xl font-extrabold">Edit Post</h1>

  {{-- REQ 7: @csrf + @method('PUT'). Route Model Binding: $post otomatis dari URL --}}
  <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" class="max-w-2xl">
    @csrf
    @method('PUT')
    @include('posts._form')
  </form>
@endsection
