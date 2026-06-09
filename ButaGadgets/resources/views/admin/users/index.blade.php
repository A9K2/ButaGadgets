@extends('admin.layouts.app')

@section('content')
<div class="mb-4">
    <h2>Керування користувачами</h2>
</div>

<div class="card p-3 shadow-sm">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Нікнейм</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-secondary' }}">
                            {{ strtoupper($user->role) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary me-2">🛡 Змінити роль</a>
                        
                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Видалити користувача з системи?')">🗑 Видалити</button>
                            </form>
                        @else
                            <small class="text-muted">(Це ви)</small>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection