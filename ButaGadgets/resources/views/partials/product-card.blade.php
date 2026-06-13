{{-- partials/product-card.blade.php --}}
<div style="background:#fff;border-radius:12px;border:1px solid #eee;display:flex;flex-direction:column;transition:box-shadow .15s"
     onmouseover="this.style.boxShadow='0 2px 12px rgba(0,0,0,.08)'"
     onmouseout="this.style.boxShadow='none'">

  {{-- ЗОБРАЖЕННЯ --}}
  <a href="/products/{{ $product->id }}" style="text-decoration:none">
    <div style="height:140px;background:#f8f8f8;display:flex;align-items:center;justify-content:center;padding:8px;border-radius:12px 12px 0 0">
      @php $img = $product->images->first() @endphp
      @if($img)
        <img src="{{ asset('storage/' . $img->image_path) }}"
             style="max-height:120px;max-width:100%;object-fit:contain"
             alt="{{ $product->name }}">
      @else
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#ccc">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
      @endif
    </div>
  </a>

  {{-- ІНФО --}}
  <div style="padding:10px 12px;display:flex;flex-direction:column;gap:6px;flex:1">

    <a href="/products/{{ $product->id }}" style="text-decoration:none">
      <p style="font-size:12px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#222">
        {{ $product->name }}
      </p>
    </a>

    <div style="display:flex;align-items:center;justify-content:space-between">
      <div>
        @if(isset($showOldPrice) && $showOldPrice && $product->old_price)
          <p style="font-size:11px;color:#aaa;text-decoration:line-through;margin-bottom:1px">
            {{ number_format($product->old_price, 0) }} грн
          </p>
        @endif
        <p style="font-size:13px;color:#2ECC71;font-weight:700">
          {{ number_format($product->price, 0) }} грн
        </p>
      </div>

      @auth
        @php $isFav = \App\Models\Favorite::where('user_id', auth()->id())->where('product_id', $product->id)->exists() @endphp
        <form action="{{ route('favorites.toggle', $product->id) }}" method="POST">
          @csrf
          <button type="submit" style="background:none;border:none;cursor:pointer;font-size:16px;padding:2px;line-height:1">
            {{ $isFav ? '❤️' : '🤍' }}
          </button>
        </form>
      @endauth
    </div>

    @auth
      <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <button type="submit"
                style="border:1.5px solid #2ECC71;color:#2ECC71;border-radius:8px;padding:6px;font-size:12px;background:transparent;cursor:pointer;width:100%;font-weight:500"
                onmouseover="this.style.background='#2ECC71';this.style.color='#fff'"
                onmouseout="this.style.background='transparent';this.style.color='#2ECC71'">
          Купити
        </button>
      </form>
    @else
      <a href="{{ route('login') }}"
         style="display:block;text-align:center;border:1.5px solid #2ECC71;color:#2ECC71;border-radius:8px;padding:6px;font-size:12px;text-decoration:none;font-weight:500">
        Купити
      </a>
    @endauth

  </div>

</div>