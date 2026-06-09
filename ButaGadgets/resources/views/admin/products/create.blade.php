@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <h2>Додати товар зі специфікаціями</h2>
</div>

<div class="card p-4 shadow-sm">
    <form action="{{ route('admin.products.create') }}" method="GET">
        <select name="category_id" onchange="this.form.submit()">
            <option value="">Оберіть категорію...</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </form>
    
    @if($category && $category->attributes?->isNotEmpty())
    <div class="mt-4">
        @foreach($category->attributes as $attribute)
            <div class="form-group">
                <label>{{ $attribute->name }}</label>
                <select name="attributes[{{ $attribute->id }}]" class="form-control">
                    @foreach($attribute->values ?? [] as $value)
                        <option value="{{ $value->id }}">{{ $value->value }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
    </div>
    @else
        <p>Для цієї категорії ще не створено характеристик або категорію не обрано.</p>
    @endif
</div>
</script>
@endsection