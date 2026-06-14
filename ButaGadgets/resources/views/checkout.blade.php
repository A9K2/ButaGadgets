<x-layout>
    <div class="w-full max-w-2xl mx-auto">
    
      <h1 class="text-lg font-bold mb-6">Оформлення замовлення</h1>
    
      @if($items->isEmpty())
        <p class="text-gray-400">Кошик порожній. <a href="/" class="text-green-500">На головну</a></p>
      @else
    
        <div class="flex gap-6">
    
          <div class="flex-1">
            <form action="{{ route('checkout.store') }}" method="POST">
              @csrf
    
              <div class="bg-white rounded-xl border border-gray-100 p-5 mb-4">
                <h2 class="font-semibold text-gray-700 mb-4">Дані отримувача</h2>
    
                <div class="mb-3">
                  <label class="block text-sm text-gray-600 mb-1">Ім'я та прізвище</label>
                  <input type="text" name="recipient_name"
                         value="{{ old('recipient_name', auth()->user()->name ?? '') }}"
                         class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-400"
                         placeholder="Іван Петренко">
                  @error('recipient_name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                  @enderror
                </div>
    
                <div class="mb-3">
                  <label class="block text-sm text-gray-600 mb-1">Телефон</label>
                  <input type="text" name="phone"
                         value="{{ old('phone') }}"
                         class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-400"
                         placeholder="+380991234567">
                  @error('phone')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                  @enderror
                </div>
    
                <div class="mb-3">
                  <label class="block text-sm text-gray-600 mb-1">Адреса доставки</label>
                  <textarea name="shipping_address" rows="3"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-green-400"
                            placeholder="Місто, відділення Нової Пошти або адреса">{{ old('shipping_address') }}</textarea>
                  @error('shipping_address')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                  @enderror
                </div>
              </div>
    
              <button type="submit"
                      class="w-full bg-green-500 text-white rounded-xl py-3 font-semibold hover:bg-green-600 transition">
                Підтвердити замовлення
              </button>
            </form>
          </div>

          <div class="w-64 flex-shrink-0">
            <div class="bg-white rounded-xl border border-gray-100 p-5">
              <h2 class="font-semibold text-gray-700 mb-4">Ваше замовлення</h2>
    
              @foreach($items as $item)
                <div class="flex justify-between text-sm mb-2">
                  <span class="text-gray-600 truncate flex-1 mr-2">{{ $item->product->name }}</span>
                  <span class="text-gray-700 whitespace-nowrap">× {{ $item->quantity }}</span>
                </div>
              @endforeach
    
              <div class="border-t pt-3 mt-3 flex justify-between font-bold">
                <span>Разом</span>
                <span class="text-green-500">{{ number_format($total, 0) }} грн</span>
              </div>
            </div>
          </div>
    
        </div>
      @endif
    
    </div>
    </x-layout>