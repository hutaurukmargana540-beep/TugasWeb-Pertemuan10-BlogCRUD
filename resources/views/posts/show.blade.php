@extends('layouts.app')

@section('title', $post->title)

@section('content')
  <a href="{{ route('posts.index') }}" class="text-sm text-slate-400 hover:text-pink-400">&larr; Semua post</a>

  <article class="mt-4 max-w-3xl">
    @if ($post->image_url)
      <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="mb-6 max-h-96 w-full rounded-xl object-cover">
    @endif

    <h1 class="text-3xl font-extrabold leading-tight">{{ $post->title }}</h1>
    <p class="mt-2 text-sm text-slate-500">
      Diterbitkan {{ $post->created_at->translatedFormat('l, d F Y') }}
      @if ($post->updated_at->gt($post->created_at))
        · diperbarui {{ $post->updated_at->diffForHumans() }}
      @endif
    </p>

    {{-- {{ }} otomatis di-escape (anti XSS); nl2br + e() menjaga baris baru tetap aman --}}
    <div class="mt-6 leading-relaxed text-slate-300">{!! nl2br(e($post->content)) !!}</div>

    <div class="mt-10 flex gap-3 border-t border-slate-800 pt-6">
      <a href="{{ route('posts.edit', $post) }}"
         class="rounded-lg border border-slate-700 px-4 py-2 text-sm hover:border-lime-400">Edit</a>

      <form method="POST" action="{{ route('posts.destroy', $post) }}"
            onsubmit="return confirm('Pindahkan post ini ke tempat sampah?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-lg border border-red-500/50 px-4 py-2 text-sm text-red-300 hover:bg-red-500/10">
          Hapus
        </button>
      </form>
    </div>
  </article>
@endsection
