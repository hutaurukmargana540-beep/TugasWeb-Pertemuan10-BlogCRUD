{{-- REQ 4: komponen #1 — <x-alert type="success|error">Pesan</x-alert> --}}
@props(['type' => 'success'])

@php
  $styles = [
    'success' => 'border-lime-500/40 bg-lime-500/10 text-lime-200',
    'error'   => 'border-red-500/40 bg-red-500/10 text-red-200',
  ];
@endphp

<div role="alert" {{ $attributes->class(['mb-6 rounded-lg border px-4 py-3 text-sm', $styles[$type] ?? $styles['success']]) }}>
  {{ $slot }}
</div>
