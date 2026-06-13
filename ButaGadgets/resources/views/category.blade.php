<x-layout>

  <x-slot name="sidebar">
    @include('components.filters.category', [
        'brands'           => $brands,
        'filterAttributes' => $filterAttributes,
        'attrFilter'       => $attrFilter,
    ])
  </x-slot>

  <div class="w-full">

    <div class="text-sm mb-2">
      <a href="/" class="text-green-500">Головна</a>
      <span class="text-gray-400 mx-1">/</span>
      <span class="text-gray-600">{{ $category->name }}</span>
    </div>

    <h1 class="text-lg font-bold mb-4">
      {{ $category->name }}
      <span class="text-sm font-normal text-gray-400">({{ $products->total() }} товарів)</span>
    </h1>

    @if($products->isEmpty())
      <p class="text-gray-400">
        Товарів не знайдено.
        <a href="{{ route('category.show', $category->id) }}" class="text-green-500">Скинути фільтри</a>
      </p>
    @else
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($products as $product)
          @include('partials.product-card', ['product' => $product])
        @endforeach
      </div>
      <div class="mt-4">{{ $products->links() }}</div>
    @endif

  </div>

</x-layout>