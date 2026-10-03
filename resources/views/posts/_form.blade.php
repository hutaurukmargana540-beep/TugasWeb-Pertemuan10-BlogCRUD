{{-- Field form yang dipakai bersama oleh create & edit.
     REQ 5: pesan error per field (@error) + old input (old()). --}}
@php($editing = isset($post))

<div class="mb-5">
  <label for="title" class="mb-1 block text-sm font-medium">Judul</label>
  <input type="text" id="title" name="title" value="{{ old('title', $post->title ?? '') }}"
         class="w-full rounded-lg border bg-slate-900 px-3 py-2 focus:outline-none focus:border-pink-500
                @error('title') border-red-500 @else border-slate-700 @enderror">
  @error('title')
    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
  @enderror
</div>

<div class="mb-5">
  <label for="content" class="mb-1 block text-sm font-medium">Isi post</label>
  <textarea id="content" name="content" rows="8"
            class="w-full rounded-lg border bg-slate-900 px-3 py-2 focus:outline-none focus:border-pink-500
                   @error('content') border-red-500 @else border-slate-700 @enderror">{{ old('content', $post->content ?? '') }}</textarea>
  @error('content')
    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
  @enderror
</div>

<div class="mb-8">
  <label for="image" class="mb-1 block text-sm font-medium">
    Gambar <span class="font-normal text-slate-500">(opsional, maks. 2 MB)</span>
  </label>

  @if ($editing && $post->image_url)
    <img src="{{ $post->image_url }}" alt="Gambar saat ini" class="mb-3 h-32 rounded-lg object-cover">
    <p class="mb-2 text-xs text-slate-500">Pilih file baru untuk mengganti gambar di atas.</p>
  @endif

  <input type="file" id="image" name="image" accept="image/*"
         class="block w-full text-sm text-slate-300 file:mr-4 file:rounded-lg file:border-0 file:bg-slate-800 file:px-4 file:py-2 file:text-slate-100">
  @error('image')
    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
  @enderror
</div>

<div class="flex gap-3">
  <button type="submit" class="rounded-lg bg-pink-500 px-5 py-2 font-medium text-white hover:bg-pink-400">
    {{ $editing ? 'Simpan perubahan' : 'Terbitkan post' }}
  </button>
  <a href="{{ $editing ? route('posts.show', $post) : route('posts.index') }}"
     class="rounded-lg border border-slate-700 px-5 py-2 hover:border-slate-500">Batal</a>
</div>
