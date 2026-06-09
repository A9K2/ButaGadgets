@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Усі товари</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Додати товар</a>
</div>

<div class="card p-3 shadow-sm">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>Ціна</th>
                <th>Кількість</th>
                <th class="text-end">Дії</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ number_format($product->price, 2) }} грн</td>
                    <td>{{ $product->quantity }} шт</td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary me-2">✏️ Редагувати</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Видалити цей товар?')">🗑 Видалити</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Товарів поки немає.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection