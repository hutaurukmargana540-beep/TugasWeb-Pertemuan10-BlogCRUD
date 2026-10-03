{{-- REQ 4: komponen #2 — <x-card :title="..." :href="..." :image="...">isi</x-card> --}}
@props(['title', 'href' => null, 'image' => null])

<article {{ $attributes->class(['flex flex-col overflow-hidden rounded-xl border border-slate-800 bg-slate-900/60']) }}>
  @if ($image)
    <img src="{{ $image }}" alt="{{ $title }}" class="h-40 w-full object-cover">
  @endif

  <div class="flex flex-1 flex-col p-5">
    <h2 class="mb-2 text-lg font-bold leading-snug">
      @if ($href)
        <a href="{{ $href }}" class="hover:text-pink-400">{{ $title }}</a>
      @else
        {{ $title }}
      @endif
    </h2>

    {{ $slot }}
  </div>
</article>
