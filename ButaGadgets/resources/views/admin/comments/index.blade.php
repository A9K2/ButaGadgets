@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <h2>Модерація відгуків</h2>
</div>

<div class="card p-3 shadow-sm">
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>Користувач</th>
                <th>Товар</th>
                <th>Рейтинг</th>
                <th>Коментар</th>
                <th>Видимість на сайті</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $review)
                <tr class="{{ !$review->is_visible ? 'table-warning' : '' }}">
                    <td><strong>{{ $review->user?->username ?? 'Гість' }}</strong></td>
                    <td><small class="text-muted">{{ $review->product?->name }}</small></td>
                    <td><span class="text-warning">★ {{ $review->rating }}</span>/5</td>
                    <td>{{ $review->comment ?? 'Без тексту' }}</td>
                    <td>
                        <form action="{{ route('admin.comments.update', $review->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_visible" onchange="this.form.submit()" {{ $review->is_visible ? 'checked' : '' }}>
                                <label class="form-check-label"><small>{{ $review->is_visible ? 'Показано' : 'Приховано' }}</small></label>
                            </div>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.comments.destroy', $review->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Видалити цей відгук остаточно?')">🗑 Видалити</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">Відгуків поки ніхто не залишав.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $reviews->links() }}
</div>
@endsection