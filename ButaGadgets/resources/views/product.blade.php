<x-layout>
    <div class="w-full">
    
      {{-- ХЛІБНІ КРИХТИ --}}
      <div class="text-sm mb-4">
        <a href="/" class="text-green-500">Головна</a>
        <span class="text-gray-400 mx-1">/</span>
        <a href="{{ route('category.show', $product->category_id) }}" class="text-green-500">{{ $product->category->name }}</a>
        <span class="text-gray-400 mx-1">/</span>
        <span class="text-gray-600">{{ $product->name }}</span>
      </div>
    
      {{-- ОСНОВНИЙ БЛОК --}}
      <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6 flex gap-8">
    
        {{-- ГАЛЕРЕЯ --}}
        <div class="w-96 flex-shrink-0">
          {{-- Головне фото --}}
          <div class="bg-gray-50 rounded-xl flex items-center justify-center mb-3" style="height:320px">
            @if($product->images->isNotEmpty())
              <img id="main-image"
                   src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                   class="max-h-full max-w-full object-contain p-4"
                   alt="{{ $product->name }}">
            @else
              <svg width="80" height="80" fill="none" viewBox="0 0 24 24" stroke="#ccc">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            @endif
          </div>
    
          {{-- Мініатюри --}}
          @if($product->images->count() > 1)
            <div class="flex gap-2 flex-wrap">
              @foreach($product->images as $img)
                <div class="w-16 h-16 bg-gray-50 rounded-lg border-2 border-transparent hover:border-green-400 cursor-pointer flex items-center justify-center overflow-hidden"
                     onclick="document.getElementById('main-image').src='{{ asset('storage/' . $img->image_path) }}'">
                  <img src="{{ asset('storage/' . $img->image_path) }}"
                       class="max-h-full max-w-full object-contain p-1"
                       alt="{{ $product->name }}">
                </div>
              @endforeach
            </div>
          @endif
        </div>
    
        {{-- ІНФО --}}
        <div class="flex-1">
          <p class="text-sm text-gray-400 mb-1">{{ $product->brand->name ?? '' }}</p>
          <h1 class="text-xl font-bold text-gray-800 mb-3">{{ $product->name }}</h1>
    
          {{-- ЦІНА --}}
          <div class="mb-4">
            @if($product->old_price)
              <p class="text-sm text-gray-400 line-through">{{ number_format($product->old_price, 0) }} грн</p>
            @endif
            <p class="text-3xl font-bold text-green-500">{{ number_format($product->price, 0) }} грн</p>
          </div>
    
          {{-- НАЯВНІСТЬ --}}
          <p class="text-sm mb-4">
            @if($product->quantity > 0)
              <span class="text-green-500 font-medium">✓ В наявності</span>
              <span class="text-gray-400">({{ $product->quantity }} шт.)</span>
            @else
              <span class="text-red-400 font-medium">✗ Немає в наявності</span>
            @endif
          </p>
    
          {{-- КНОПКИ --}}
          <div class="flex gap-3 mb-6">
            @auth
              <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit"
                        class="bg-green-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-green-600 transition">
                  Купити
                </button>
              </form>

              <form action="{{ route('favorites.toggle', $product->id) }}" method="POST">
                @csrf
                @php $isFav = \App\Models\Favorite::where('user_id', auth()->id())->where('product_id', $product->id)->exists() @endphp
                <button type="submit"
                        class="border border-gray-200 px-4 py-3 rounded-xl hover:border-green-400 transition text-gray-500">
                  {{ $isFav ? '❤️' : '🤍' }} Обране
                </button>
              </form>
            @else
              <a href="{{ route('login') }}"
                class="bg-green-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-green-600 transition">
                Купити
              </a>
              <a href="{{ route('login') }}"
                class="border border-gray-200 px-4 py-3 rounded-xl hover:border-green-400 transition text-gray-500">
                🤍 Обране
              </a>
            @endauth
          </div>
    
          {{-- ХАРАКТЕРИСТИКИ --}}
          @if($product->attributeValues->isNotEmpty())
            <div class="border-t border-gray-100 pt-4">
              <h3 class="font-semibold text-gray-700 mb-3">Характеристики</h3>
              <table class="w-full text-sm">
                @foreach($product->attributeValues as $av)
                  <tr class="border-b border-gray-50">
                    <td class="py-2 text-gray-400 w-1/2">{{ $av->attribute->name }}</td>
                    <td class="py-2 text-gray-700 font-medium">{{ $av->value->value }}</td>
                  </tr>
                @endforeach
              </table>
            </div>
          @endif
        </div>
    
      </div>
    
      {{-- ОПИС --}}
      @if($product->description)
        <div class="bg-white rounded-xl border border-gray-100 p-6 mb-6">
          <h2 class="font-bold text-gray-800 mb-3">Опис</h2>
          <p class="text-sm text-gray-600 leading-relaxed">{{ $product->description }}</p>
        </div>
      @endif
    
      {{-- СХОЖІ ТОВАРИ --}}
      @if($related->isNotEmpty())
        <div>
          <h2 class="font-bold text-gray-800 mb-4">Схожі товари</h2>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($related as $product)
              @include('partials.product-card', ['product' => $product])
            @endforeach
          </div>
        </div>
      @endif
    
    </div>
    </x-layout>