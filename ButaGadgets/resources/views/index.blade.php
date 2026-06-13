<x-layout>

    {{-- ========== TOP ROW: Sidebar + Hero ========== --}}
    <div style="display:flex; gap:0; min-height:100vh; background:#f5f5f5">
    
      {{-- SIDEBAR --}}
      
    
      {{-- MAIN --}}
      <main style="flex:1; padding:20px; overflow:hidden">
    
        {{-- HERO: banner + 2 featured phones --}}
        <div style="display:grid; grid-template-columns:1.4fr 1fr 1fr; gap:12px; margin-bottom:16px">
    
          {{-- Banner --}}
          @if($banners->isNotEmpty())
            @php $b = $banners->first() @endphp
            <div style="background:{{ $b->bg_color ?? '#fce4ec' }};border-radius:12px;padding:28px 24px;display:flex-direction:column;justify-content:flex-end;min-height:180px;position:relative;overflow:hidden">
              @if($b->image)
                <img src="{{ asset('storage/'.$b->image) }}" style="position:absolute;right:0;top:0;height:100%;object-fit:cover;opacity:.18">
              @endif
              <h2 style="font-size:20px;font-weight:700;color:{{ $b->text_color ?? '#c2185b' }};margin-bottom:12px;position:relative">
                {{ $b->title }}
              </h2>
              @if($b->button_url)
                <a href="{{ $b->button_url }}"
                   style="display:inline-block;background:#2ECC71;color:#fff;border-radius:8px;padding:8px 18px;font-size:13px;font-weight:500;text-decoration:none;width:fit-content;position:relative">
                  {{ $b->button_text ?? 'Отримати' }}
                </a>
              @endif
            </div>
          @endif
    
          {{-- 2 featured products --}}
            @foreach($featuredProducts->take(2) as $fp)
            <a href="/products/{{ $fp->id }}"
              style="background:#fff;border-radius:12px;padding:14px;display:flex;flex-direction:column;align-items:center;border:1px solid #eee;text-decoration:none;transition:box-shadow .15s"
              onmouseover="this.style.boxShadow='0 2px 12px rgba(0,0,0,.08)'" onmouseout="this.style.boxShadow='none'">
              <div style="width:100%;height:120px;background:#f8f8f8;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden">
                @php $fpImg = $fp->images->first() @endphp
                @if($fpImg)
                  <img src="{{ asset('storage/' . $fpImg->image_path) }}" style="max-height:110px;max-width:100%;object-fit:contain">
                @else
                  <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="#ccc">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                @endif
              </div>
              <p style="font-size:12px;font-weight:600;margin-top:10px;text-align:center;color:#222">{{ $fp->name }}</p>
              <p style="font-size:13px;color:#2ECC71;font-weight:700;margin-top:2px">{{ number_format($fp->price, 0) }}₴</p>
            </a>
            @endforeach
    
        </div>
    
        {{-- CATEGORY PILLS --}}
        <div style="display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap">
          @foreach($categories as $cat)
            <a href="{{ route('category.show', $cat->id) }}"
              style="padding:7px 18px;border-radius:8px;border:1px solid #ddd;font-size:13px;background:#fff;color:#333;text-decoration:none;white-space:nowrap"
              onmouseover="this.style.background='#2ECC71';this.style.color='#fff';this.style.borderColor='#2ECC71'"
              onmouseout="this.style.background='#fff';this.style.color='#333';this.style.borderColor='#ddd'">
              {{ $cat->name }}
            </a>
          @endforeach
        </div>
    
        {{-- PROMO BANNERS --}}
        @if($banners->count() > 1)
          <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-bottom:24px">
            @foreach($banners->skip(1) as $promo)
              <a href="{{ $promo->button_url ?? '#' }}"
                 style="background:{{ $promo->bg_color ?? '#2ECC71' }};border-radius:12px;padding:16px 20px;text-decoration:none;display:block">
                <h4 style="color:{{ $promo->text_color ?? '#fff' }};font-size:14px;font-weight:700;margin-bottom:4px">{{ $promo->title }}</h4>
                @if($promo->subtitle)
                  <p style="color:{{ $promo->text_color ?? '#fff' }};font-size:12px;opacity:.85">{{ $promo->subtitle }}</p>
                @endif
              </a>
            @endforeach
          </div>
        @endif
    
        {{-- POPULAR PRODUCTS --}}
        @if($popularProducts->isNotEmpty())
          <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;color:#222">Популярні товари</h3>
          <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;margin-bottom:28px">
            @foreach($popularProducts as $product)
              @include('partials.product-card', ['product' => $product])
            @endforeach
          </div>
        @endif
    
        {{-- ACTION PRODUCTS --}}
        @if($actionProducts->isNotEmpty())
          <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;color:#222">Акційні товари</h3>
          <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;margin-bottom:28px">
            @foreach($actionProducts as $product)
              @include('partials.product-card', ['product' => $product, 'showOldPrice' => true])
            @endforeach
          </div>
        @endif
    
        {{-- ALL PRODUCTS (paginated) --}}
        <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;color:#222">Всі товари</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px;margin-bottom:20px">
          @foreach($products as $product)
            @include('partials.product-card', ['product' => $product])
          @endforeach
        </div>
    
        {{ $products->links() }}
    
      
    </div>
    
    </x-layout>