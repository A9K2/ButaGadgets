<x-layout>
    <div class="w-full max-w-2xl mx-auto">
    
      @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
          ✓ {{ session('success') }}
        </div>
      @endif
    
      <div class="bg-white rounded-xl border border-gray-100 p-6 mb-4">
        <div class="flex items-center justify-between mb-4">
          <h1 class="text-lg font-bold">Замовлення #{{ $order->id }}</h1>
          <span class="text-xs px-3 py-1 rounded-full
            {{ $order->status === 'pending' ? 'bg-yellow-50 text-yellow-600' : '' }}
            {{ $order->status === 'completed' ? 'bg-green-50 text-green-600' : '' }}
            {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-400' : '' }}">
            {{ match($order->status) {
              'pending'   => 'Очікує обробки',
              'completed' => 'Виконано',
              'cancelled' => 'Скасовано',
              default     => $order->status
            } }}
          </span>
        </div>
    
        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
          <div>
            <p class="text-gray-400 mb-1">Отримувач</p>
            <p class="font-medium">{{ $order->recipient_name }}</p>
          </div>
          <div>
            <p class="text-gray-400 mb-1">Телефон</p>
            <p class="font-medium">{{ $order->phone }}</p>
          </div>
          <div class="col-span-2">
            <p class="text-gray-400 mb-1">Адреса доставки</p>
            <p class="font-medium">{{ $order->shipping_address }}</p>
          </div>
        </div>
    
        <div class="border-t pt-4">
          <h3 class="font-semibold text-sm mb-3">Товари</h3>
          @foreach($order->items as $item)
            <div class="flex items-center gap-3 mb-3">
              <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center flex-shrink-0">
                @if($item->product->images->isNotEmpty())
                  <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                       class="max-h-full max-w-full object-contain p-1">
                @endif
              </div>
              <div class="flex-1">
                <p class="text-sm font-medium">{{ $item->product->name }}</p>
                <p class="text-xs text-gray-400">{{ number_format($item->price, 0) }} грн × {{ $item->quantity }}</p>
              </div>
              <p class="text-sm font-bold text-green-500">
                {{ number_format($item->price * $item->quantity, 0) }} грн
              </p>
            </div>
          @endforeach
    
          <div class="border-t pt-3 flex justify-between font-bold">
            <span>Разом</span>
            <span class="text-green-500">{{ number_format($order->total_price, 0) }} грн</span>
          </div>
        </div>
      </div>
    
      <div class="flex gap-3">
        <a href="{{ route('orders') }}"
           class="flex-1 text-center border border-gray-200 rounded-xl py-2 text-sm text-gray-600 hover:border-green-400 transition">
          Мої замовлення
        </a>
        <a href="/"
           class="flex-1 text-center bg-green-500 text-white rounded-xl py-2 text-sm font-semibold hover:bg-green-600 transition">
          Продовжити покупки
        </a>
      </div>
    
    </div>
    </x-layout>