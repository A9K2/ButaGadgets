@extends('admin.layouts.app')

@section('content')
<div class="card p-4 shadow-sm">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <input type="hidden" name="category_id" value="{{ request('category_id') }}">

        <div class="form-group">
            <label>Назва товару</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Кількість на складі</label>
            <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 0) }}" required>
        </div>

        <label>Назва бренду</label>
        <select name="brand_id" class="form-control" required>
            @foreach($brands as $brand)
                <option value="{{ $brand->id }}">
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>

        <label>Назва підкатегорії</label>
        <select name="subcategory_id" class="form-control" required>
            @foreach($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}">
                    {{ $subcategory->name }}
                </option>
            @endforeach
        </select>

        <div class="form-group">
            <label>Зображення</label>
            <input type="file" name="images[]" multiple class="form-control">
        </div>
        <div class="form-group">
        <label>Ціна</label>
        <input type="number" name="price" class="form-control" step="0.01" required>
        </div>
        @if($category && $category->attributes?->isNotEmpty())
            <div class="mt-4">
                <h4>Характеристики</h4>
                @foreach($category->attributes as $attribute)
                    <div class="form-group">
                        <label>{{ $attribute->name }}</label>
                        <select name="attributes[{{ $attribute->id }}]" class="form-control">
                            @foreach($attribute->values as $value)
                                <option value="{{ $value->id }}">{{ $value->value }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
        @endif

        <button type="submit" class="btn btn-primary mt-3">Зберегти товар</button>
    </form>
</div>

<div class="mt-4">
    <form action="{{ route('admin.products.create') }}" method="GET">
        <label>Змінити категорію (скине незаповнені дані):</label>
        <select name="category_id" onchange="this.form.submit()" class="form-control">
            <option value="">Оберіть категорію...</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </form>
</div>
@endsection