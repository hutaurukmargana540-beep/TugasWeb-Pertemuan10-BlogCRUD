@extends('layouts.app')

@section('title', 'Semua Post')

@section('content')
  <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
      <h1 class="text-3xl font-extrabold">Semua Post</h1>
      <p class="mt-1 text-sm text-slate-400">{{ $posts->total() }} post ditemukan</p>
    </div>

    {{-- BONUS: pencarian (GET, jadi tidak perlu @csrf) --}}
    <form method="GET" action="{{ route('posts.index') }}" class="flex gap-2">
      <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul atau isi…"
             class="w-64 rounded-lg border border-slate-700 bg-slate-900 px-3 py-2 text-sm focus:border-pink-500 focus:outline-none">
      <button class="rounded-lg border border-slate-700 px-4 py-2 text-sm hover:border-pink-500">Cari</button>
    </form>
  </div>

  <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @forelse ($posts as $post)
      <x-card :title="$post->title" :href="route('posts.show', $post)" :image="$post->image_url">
        <p class="mb-4 flex-1 text-sm text-slate-400">{{ $post->excerpt }}</p>

        <div class="flex items-center justify-between text-xs text-slate-500">
          <span>{{ $post->created_at->translatedFormat('d M Y') }}</span>
          <div class="flex items-center gap-3">
            <a href="{{ route('posts.edit', $post) }}" class="text-lime-400 hover:underline">Edit</a>

            {{-- REQ 7: @csrf + @method('DELETE') --}}
            <form method="POST" action="{{ route('posts.destroy', $post) }}"
                  onsubmit="return confirm('Pindahkan post ini ke tempat sampah?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-400 hover:underline">Hapus</button>
            </form>
          </div>
        </div>
      </x-card>
    @empty
      <p class="col-span-full rounded-xl border border-dashed border-slate-700 p-10 text-center text-slate-400">
        Belum ada post{{ request('q') ? ' yang cocok dengan "'.e(request('q')).'"' : '' }}.
        <a href="{{ route('posts.create') }}" class="text-pink-400 underline">Tulis post pertama</a>.
      </p>
    @endforelse
  </div>

  {{-- REQ 8: pagination --}}
  <div class="mt-8">
    {{ $posts->links() }}
  </div>
@endsection
