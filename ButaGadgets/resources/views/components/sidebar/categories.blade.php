

<aside style="width:200px; background:#fff; border-right:1px solid #eee; padding:16px 0; flex-shrink:0">
  @foreach($categories as $cat)
    <a href="{{ route('category.show', $cat->id) }}"
       style="display:flex;align-items:center;gap:10px;padding:9px 20px;font-size:13px;color:#333;text-decoration:none"
       onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">
      <i class="ti ti-{{ $cat->icon ?? 'tag' }}" aria-hidden="true"></i>
      {{ $cat->name }}
    </a>
  @endforeach
</aside>