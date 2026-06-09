@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <h2>Керування довідниками магазину</h2>
    <p class="text-muted">Тут ви можете додавати та видаляти бренди, категорії та підкатегорії.</p>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm p-3 h-100">
            <h5 class="text-primary mb-3">🏷 Новий бренд</h5>
            <form action="{{ route('admin.directories.brands.store') }}" method="POST" class="mb-3">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Назва (напр. Samsung)" required>
                    <button class="btn btn-primary" type="submit">Додати</button>
                </div>
            </form>

            <h6>Існуючі бренди:</h6>
            <ul class="list-group list-group-flush overflow-auto" style="max-height: 400px;">
                @forelse($brands as $brand)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <span>{{ $brand->name }}</span>
                            <small class="text-muted ms-2">(ID: {{ $brand->id }})</small>
                        </div>
                        
                        <form action="{{ route('admin.directories.brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цей бренд?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Видалити">
                                &#128465; </button>
                        </form>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center px-0">Брендів немає</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3 h-100">
            <h5 class="text-success mb-3">📁 Нова категорія</h5>
            <form action="{{ route('admin.directories.categories.store') }}" method="POST" class="mb-3">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Назва (напр. Смартфони)" required>
                    <button class="btn btn-success" type="submit">Додати</button>
                </div>
            </form>

            <h6>Існуючі категорії:</h6>
            <ul class="list-group list-group-flush overflow-auto" style="max-height: 400px;">
                @forelse($categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <strong>{{ $category->name }}</strong>
                            <small class="text-muted ms-2">(ID: {{ $category->id }})</small>
                        </div>

                        <form action="{{ route('admin.directories.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Ви впевнені? Підкатегорії та товари не повинні бути зв\'язані з цією категорією!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Видалити">
                                &#128465;
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center px-0">Категорій немає</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3 h-100">
            <h5 class="text-warning mb-3">🌿 Нова підкатегорія</h5>
            <form action="{{ route('admin.directories.subcategories.store') }}" method="POST" class="mb-3">
                @csrf
                <div class="mb-2">
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Оберіть батьківську категорію --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Назва (напр. Ігрові)" required>
                    <button class="btn btn-warning" type="submit">Додати</button>
                </div>
            </form>

            <h6>Зв'язки підкатегорій:</h6>
            <ul class="list-group list-group-flush overflow-auto" style="max-height: 400px;">
                @forelse($subcategories as $sub)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <span>{{ $sub->name }}</span> 
                            <small class="text-muted d-block">Категорія: {{ $sub->category?->name ?? 'Видалена' }} (ID: {{ $sub->id }})</small>
                        </div>

                        <form action="{{ route('admin.directories.subcategories.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Ви впевнені, що хочете видалити цю підкатегорію?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Видалити">
                                &#128465;
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center px-0">Підкатегорій немає</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection