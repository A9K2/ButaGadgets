<x-layout>
    <div class="w-full">
    
      <h1 class="text-lg font-bold mb-6">Кошик</h1>
    
      @if(session('success'))
        <div class="bg-green-50 text-green-700 border border-green-200 rounded-xl px-4 py-3 mb-4 text-sm">
          {{ session('success') }}
        </div>
      @endif
    
      @if($items->isEmpty())
        <div class="text-center py-16 text-gray-400">
          <p class="text-4xl mb-4">🛒</p>
          <p class="text-lg font-medium text-gray-500 mb-2">Кошик порожній</p>
          <a href="/" class="text-green-500 text-sm hover:underline">Перейти до покупок</a>
        </div>
      @else
    
        <div class="flex gap-6">
    
          {{-- СПИСОК ТОВАРІВ --}}
          <div class="flex-1">
            @foreach($items as $item)
              <div class="bg-white rounded-xl border border-gray-100 p-4 mb-3 flex items-center gap-4">
    
                {{-- Фото --}}
                <div class="w-20 h-20 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0">
                  @if($item->product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                         class="max-h-full max-w-full object-contain p-1"
                         alt="{{ $item->product->name }}">
                  @else
                    <svg width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#ccc">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  @endif
                </div>
    
                {{-- Назва --}}
                <div class="flex-1">
                  <a href="/products/{{ $item->product_id }}"
                     class="font-semibold text-sm text-gray-800 hover:text-green-500">
                    {{ $item->product->name }}
                  </a>
                  <p class="text-green-500 font-bold mt-1">
                    {{ number_format($item->product->price, 0) }} грн
                  </p>
                </div>
    
                {{-- Кількість --}}
                <form action="{{ route('cart.update', $item->id) }}" method="POST"
                      class="flex items-center gap-2">
                  @csrf @method('PATCH')
                  <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}"
                          class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:border-green-400 hover:text-green-500 text-sm font-bold">
                    −
                  </button>
                  <span class="w-8 text-center text-sm font-semibold">{{ $item->quantity }}</span>
                  <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                          class="w-7 h-7 rounded-full border border-gray-200 text-gray-500 hover:border-green-400 hover:text-green-500 text-sm font-bold">
                    +
                  </button>
                </form>
    
                {{-- Сума --}}
                <p class="w-24 text-right font-bold text-sm text-gray-700">
                  {{ number_format($item->product->price * $item->quantity, 0) }} грн
                </p>
    
                {{-- Видалити --}}
                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                  @csrf @method('DELETE')
                  <button type="submit"
                          class="text-gray-300 hover:text-red-400 transition text-lg leading-none"
                          title="Видалити">
                    ✕
                  </button>
                </form>
    
              </div>
            @endforeach
    
            {{-- Очистити кошик --}}
            <form action="{{ route('cart.clear') }}" method="POST" class="mt-2">
              @csrf @method('DELETE')
              <button type="submit" class="text-sm text-gray-400 hover:text-red-400">
                Очистити кошик
              </button>
            </form>
          </div>
    
          {{-- ПІДСУМОК --}}
          <div class="w-72 flex-shrink-0">
            <div class="bg-white rounded-xl border border-gray-100 p-5 sticky top-4">
              <h2 class="font-bold text-gray-800 mb-4">Підсумок</h2>
    
              <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Товарів</span>
                <span>{{ $items->sum('quantity') }} шт.</span>
              </div>
              <div class="flex justify-between font-bold text-gray-800 text-lg border-t pt-3 mt-3">
                <span>Разом</span>
                <span class="text-green-500">{{ number_format($total, 0) }} грн</span>
              </div>
    
              <a href="{{ route('checkout') }}"
                class="block w-full bg-green-500 text-white rounded-xl py-3 mt-4 font-semibold hover:bg-green-600 transition text-center">
                Оформити замовлення
              </a>
            </div>
          </div>
    
        </div>
      @endif
    
    </div>
    </x-layout>