@extends('admin.layouts.app')

@section('content')
<div class="card p-4 shadow-sm">
    {{-- ✅ update, не store --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- ✅ category_id з продукту --}}
        <input type="hidden" name="category_id" value="{{ $category->id }}">

        <div class="form-group">
            <label>Назва товару</label>
            {{-- ✅ value з $product --}}
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <label>Назва бренду</label>
        <select name="brand_id" class="form-control" required>
            @foreach($brands as $brand)
                {{-- ✅ selected поточний бренд --}}
                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>

        <label>Назва підкатегорії</label>
        <select name="subcategory_id" class="form-control" required>
            @foreach($subcategories as $subcategory)
                {{-- ✅ selected поточна підкатегорія --}}
                <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                    {{ $subcategory->name }}
                </option>
            @endforeach
        </select>

        <div class="form-group mt-2">
            <label>Зображення (залиште порожнім, щоб не змінювати)</label>
            <input type="file" name="images[]" multiple class="form-control">
        </div>

        <div class="form-group mt-2">
            <label>Ціна</label>
            {{-- ✅ value з $product --}}
            <input type="number" name="price" class="form-control" step="0.01" value="{{ $product->price }}" required>
        </div>

        @if($category && $category->attributes?->isNotEmpty())
            <div class="mt-4">
                <h4>Характеристики</h4>
                @foreach($category->attributes as $attribute)
                <div class="form-group">
                    <label>{{ $attribute->name }}</label>
                    
                    {{-- Використовуємо $currentAttributes для перевірки --}}
                    <select name="attributes[{{ $attribute->id }}]" class="form-control">
                        <option value="">-- Оберіть значення --</option>
                        @foreach($attribute->values as $value)
                            <option value="{{ $value->id }}"
                                {{ ($currentAttributes[$attribute->id] ?? null) == $value->id ? 'selected' : '' }}>
                                {{ $value->value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endforeach
            </div>
        @endif

        <button type="submit" class="btn btn-primary mt-3">Оновити товар</button>
    </form>
</div>

{{-- Зміна категорії --}}
<div class="mt-4">
    <form action="{{ route('admin.products.edit', $product->id) }}" method="GET">
        <label>Змінити категорію:</label>
        <select name="category_id" onchange="this.form.submit()" class="form-control">
            <option value="">Оберіть категорію...</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $category?->id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </form>
</div>
@endsection