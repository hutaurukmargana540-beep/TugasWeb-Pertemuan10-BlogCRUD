@extends('layouts.app')

@section('title', 'Tempat Sampah')

@section('content')
  <h1 class="text-3xl font-extrabold">Tempat Sampah</h1>
  <p class="mb-8 mt-1 text-sm text-slate-400">Post yang dihapus masih bisa dipulihkan dari sini.</p>

  <div class="space-y-3">
    @forelse ($posts as $post)
      <div class="flex flex-col gap-3 rounded-xl border border-slate-800 bg-slate-900/60 p-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <p class="font-semibold">{{ $post->title }}</p>
          <p class="text-xs text-slate-500">Dihapus {{ $post->deleted_at->diffForHumans() }}</p>
        </div>

        <div class="flex gap-3 text-sm">
          <form method="POST" action="{{ route('posts.restore', $post) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="text-lime-400 hover:underline">Pulihkan</button>
          </form>

          <form method="POST" action="{{ route('posts.force-delete', $post) }}"
                onsubmit="return confirm('Hapus permanen? Tindakan ini tidak bisa dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-400 hover:underline">Hapus permanen</button>
          </form>
        </div>
      </div>
    @empty
      <p class="rounded-xl border border-dashed border-slate-700 p-10 text-center text-slate-400">
        Tempat sampah kosong.
      </p>
    @endforelse
  </div>

  <div class="mt-8">{{ $posts->links() }}</div>
@endsection
