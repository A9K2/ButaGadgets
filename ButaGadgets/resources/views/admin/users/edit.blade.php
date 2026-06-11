@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <h2>Редагування прав: {{ $user->username }}</h2>
</div>

<div class="card p-4 shadow-sm" style="max-width: 500px;">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Нікнейм</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-4">
            <label for="role" class="form-label">Рівень доступу (Роль)</label>
            <select name="role" id="role" class="form-select" required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User (Звичайний покупець)</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin (Повний доступ до адмінки)</option>
            </select>
        </div>
        

        <button type="submit" class="btn btn-success">💾 Зберегти налаштування</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Назад до списку</a>
    </form>
</div>
@endsection