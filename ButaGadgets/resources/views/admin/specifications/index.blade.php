@extends('admin.layouts.app')

@section('content')    
    <div class="container">
        <h2>Конструктор характеристик</h2>
        
        @if($categories->isEmpty())
            <p>У базі даних немає жодної категорії.</p>
        @else
            @foreach($categories as $category)
                <div class="card mb-4">
                    <div class="card-header"><h4>{{ $category->name }}</h4></div>
                    <div class="card-body">
                        
                        <form action="{{ route('admin.specifications.attribute.store', $category->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" placeholder="Назва (напр. Процесор)" required>
                                <button type="submit" class="btn btn-primary">Додати характеристику</button>
                            </div>
                        </form>
    
                        <ul class="list-group">
                            @foreach($category->attributes ?? [] as $attribute)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $attribute->name }}</strong>
                                        <small class="text-muted d-block">
                                            Значення: {{ $attribute->values ? $attribute->values->pluck('value')->join(', ') : 'Немає значень' }}
                                        </small>
                                    </div>

                                    <div class="d-flex">
                                        <form action="{{ route('admin.specifications.value.store', $attribute->id) }}" method="POST" class="d-flex">
                                            @csrf
                                            <input type="text" name="value" class="form-control form-control-sm" placeholder="Значення (напр. Intel i7)" required>
                                            <button type="submit" class="btn btn-sm btn-success mx-1">+</button>
                                        </form>

                                        <form action="{{ route('admin.specifications.destroy', $attribute->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Видалити?')">X</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection