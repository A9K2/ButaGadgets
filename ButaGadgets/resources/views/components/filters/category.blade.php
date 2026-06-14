<div>
  <h3 class="font-bold mb-3">Фільтри</h3>

  <form method="GET" action="{{ route('category.show', request()->route('id')) }}">

    <div class="mb-3 border-b pb-3">
      <button type="button" onclick="toggle('filter-price')"
              class="flex items-center justify-between w-full font-semibold text-sm py-1">
        Ціна <span id="icon-price">▼</span>
      </button>
      <div id="filter-price" class="mt-2">
        <input type="number" name="min_price" value="{{ request('min_price') }}"
               placeholder="від" class="border p-1 w-full mb-2 rounded text-sm">
        <input type="number" name="max_price" value="{{ request('max_price') }}"
               placeholder="до" class="border p-1 w-full rounded text-sm">
      </div>
    </div>

    @if(!empty($brands) && count($brands) > 0)
      <div class="mb-3 border-b pb-3">
        <button type="button" onclick="toggle('filter-brands')"
                class="flex items-center justify-between w-full font-semibold text-sm py-1">
          Бренд <span id="icon-brands">▼</span>
        </button>
        <div id="filter-brands" class="mt-2 hidden">
          @foreach($brands as $brand)
            <label class="flex items-center gap-2 mb-1 cursor-pointer text-sm">
              <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                     {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}
                     class="accent-green-500">
              {{ $brand->name }}
            </label>
          @endforeach
        </div>
      </div>
    @endif

    @if(!empty($filterAttributes) && count($filterAttributes) > 0)
      @foreach($filterAttributes as $attr)
        <div class="mb-3 border-b pb-3">
          <button type="button" onclick="toggle('filter-attr-{{ $attr->id }}')"
                  class="flex items-center justify-between w-full font-semibold text-sm py-1">
            {{ $attr->name }} <span id="icon-attr-{{ $attr->id }}">▼</span>
          </button>
          <div id="filter-attr-{{ $attr->id }}" class="mt-2 hidden">
            @foreach($attr->values as $val)
              <label class="flex items-center gap-2 mb-1 cursor-pointer text-sm">
                <input type="checkbox"
                       name="attrs[{{ $attr->id }}][]"
                       value="{{ $val->id }}"
                       {{ isset($attrFilter[$attr->id]) && in_array($val->id, (array)$attrFilter[$attr->id]) ? 'checked' : '' }}
                       class="accent-green-500">
                {{ $val->value }}
              </label>
            @endforeach
          </div>
        </div>
      @endforeach
    @endif

    {{-- СОРТУВАННЯ --}}
    <div class="mb-3 border-b pb-3">
      <button type="button" onclick="toggle('filter-sort')"
              class="flex items-center justify-between w-full font-semibold text-sm py-1">
        Сортування <span id="icon-sort">▼</span>
      </button>
      <div id="filter-sort" class="mt-2 hidden">
        @foreach([
          'newest'     => 'Новинки',
          'price_asc'  => 'Від дешевих',
          'price_desc' => 'Від дорогих',
        ] as $value => $label)
          <label class="flex items-center gap-2 mb-1 cursor-pointer text-sm">
            <input type="radio" name="sort" value="{{ $value }}"
                   {{ request('sort', 'newest') === $value ? 'checked' : '' }}
                   class="accent-green-500">
            {{ $label }}
          </label>
        @endforeach
      </div>
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded-xl w-full mb-2 text-sm">
      Застосувати
    </button>

    <a href="{{ route('category.show', request()->route('id')) }}"
       class="block text-center text-sm text-gray-400 mb-4">
      Скинути фільтри
    </a>

  </form>

  <div class="border-t pt-4">
    <p class="font-semibold mb-2 text-sm">Категорії</p>
    @foreach(\App\Models\Category::all() as $cat)
      <a href="{{ route('category.show', $cat->id) }}"
         class="block py-1 text-sm {{ request()->route('id') == $cat->id ? 'text-green-600 font-semibold' : 'text-gray-700' }} hover:text-green-500">
        {{ $cat->name }}
      </a>
    @endforeach
  </div>

</div>

<script>
function toggle(id) {
  const el = document.getElementById(id);
  const isHidden = el.classList.contains('hidden');
  el.classList.toggle('hidden');

  const iconId = id.replace('filter-', 'icon-');
  const icon = document.getElementById(iconId);
  if (icon) icon.textContent = isHidden ? '▲' : '▼';
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('input[type=checkbox]:checked, input[type=radio]:not([value=newest]):checked')
    .forEach(function(input) {
      const panel = input.closest('[id^="filter-"]');
      if (panel) {
        panel.classList.remove('hidden');
        const iconId = panel.id.replace('filter-', 'icon-');
        const icon = document.getElementById(iconId);
        if (icon) icon.textContent = '▲';
      }
    });
});
</script>