@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h2>Замовлення</h2>

  <form method="GET" action="{{ route('admin.comments.index') }}" class="d-flex gap-2">
    <input type="text" name="search" value="{{ $search }}"
           class="form-control form-control-sm" placeholder="Пошук по імені, телефону, ID...">
    <button type="submit" class="btn btn-sm btn-dark">Знайти</button>
    @if($search)
      <a href="{{ route('admin.comments.index') }}" class="btn btn-sm btn-outline-secondary">✕</a>
    @endif
  </form>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card p-3 shadow-sm">
  <table class="table table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Клієнт</th>
        <th>Телефон</th>
        <th>Адреса</th>
        <th>Сума</th>
        <th>Статус</th>
        <th>Дата</th>
        <th>Дії</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $order)
        <tr>
          <td><strong>#{{ $order->id }}</strong></td>
          <td>{{ $order->recipient_name }}<br>
              <small class="text-muted">{{ $order->user?->username }}</small>
          </td>
          <td>{{ $order->phone }}</td>
          <td><small>{{ Str::limit($order->shipping_address, 30) }}</small></td>
          <td><strong>{{ number_format($order->total_price, 0) }} грн</strong></td>
          <td>
            <form action="{{ route('admin.comments.update', $order->id) }}" method="POST">
              @csrf @method('PUT')
              <select name="status" onchange="this.form.submit()"
                      class="form-select form-select-sm
                        {{ $order->status === 'pending' ? 'text-warning' : '' }}
                        {{ $order->status === 'completed' ? 'text-success' : '' }}
                        {{ $order->status === 'cancelled' ? 'text-danger' : '' }}">
                <option value="pending"   {{ $order->status === 'pending'   ? 'selected' : '' }}>Очікує</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Виконано</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Скасовано</option>
              </select>
            </form>
          </td>
          <td><small>{{ $order->created_at->format('d.m.Y H:i') }}</small></td>
          <td>
            <form action="{{ route('admin.comments.destroy', $order->id) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger"
                      onclick="return confirm('Видалити замовлення #{{ $order->id }}?')">🗑</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" class="text-center text-muted py-4">
            {{ $search ? 'Нічого не знайдено за запитом "' . $search . '"' : 'Замовлень ще немає.' }}
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
  {{ $orders->links() }}
</div>
@endsection