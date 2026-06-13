<x-layout>
    <div class="w-full">
    
      <h1 class="text-lg font-bold mb-6">Обране</h1>
    
      @if($products->isEmpty())
        <div class="text-center py-16 text-gray-400">
          <p class="text-4xl mb-4">🤍</p>
          <p class="text-lg font-medium text-gray-500 mb-2">Список обраного порожній</p>
          <a href="/" class="text-green-500 text-sm hover:underline">Перейти до покупок</a>
        </div>
      @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          @foreach($products as $product)
            @include('partials.product-card', ['product' => $product])
          @endforeach
        </div>
      @endif
    
    </div>
    </x-layout>