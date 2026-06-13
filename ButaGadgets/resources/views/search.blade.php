<x-layout>
    <div class="w-full">
    
      <div class="text-sm mb-4">
        <a href="/" class="text-green-500">Головна</a>
        <span class="text-gray-400 mx-1">/</span>
        <span class="text-gray-600">Пошук: "{{ $query }}"</span>
      </div>
    
      <h1 class="text-lg font-bold mb-4">
        Результати пошуку
        <span class="text-sm font-normal text-gray-400">({{ $products->total() }} товарів)</span>
      </h1>
    
      @if($products->isEmpty())
        <div class="text-center py-16 text-gray-400">
          <p class="text-4xl mb-4">🔍</p>
          <p class="text-lg font-medium text-gray-500 mb-2">Нічого не знайдено</p>
          <p class="text-sm mb-4">Спробуйте інший запит</p>
          <a href="/" class="text-green-500 text-sm hover:underline">На головну</a>
        </div>
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