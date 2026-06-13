<x-layout>
    <div class="w-full">
    
      <h1 class="text-lg font-bold mb-6">Мої замовлення</h1>
    
      @if($orders->isEmpty())
        <div class="text-center py-16 text-gray-400">
          <p class="text-4xl mb-4">📦</p>
          <p class="text-lg font-medium text-gray-500 mb-2">Замовлень ще немає</p>
          <a href="/" class="text-green-500 text-sm">Перейти до покупок</a>
        </div>
      @else
        @foreach($orders as $order)
          <a href="{{ route('orders.show', $order->id) }}"
             class="block bg-white rounded-xl border border-gray-100 p-4 mb-3 hover:border-green-300 transition">
            <div class="flex items-center justify-between">
              <div>
                <p class="font-semibold text-sm">Замовлення #{{ $order->id }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $order->created_at->format('d.m.Y H:i') }}</p>
              </div>
              <div class="text-right">
                <p class="font-bold text-green-500">{{ number_format($order->total_price, 0) }} грн</p>
                <span class="text-xs px-2 py-1 rounded-full mt-1 inline-block
                  {{ $order->status === 'pending' ? 'bg-yellow-50 text-yellow-600' : '' }}
                  {{ $order->status === 'completed' ? 'bg-green-50 text-green-600' : '' }}
                  {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-400' : '' }}">
                  {{ match($order->status) {
                    'pending'   => 'Очікує',
                    'completed' => 'Виконано',
                    'cancelled' => 'Скасовано',
                    default     => $order->status
                  } }}
                </span>
              </div>
            </div>
          </a>
        @endforeach
      @endif
    
    </div>
    </x-layout>