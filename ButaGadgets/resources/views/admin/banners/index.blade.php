@extends('admin.layouts.app')

@section('content')
<div style="padding: 20px; font-family: 'Segoe UI', system-ui, sans-serif;">
    <h2>🖼️ Керування рекламними банерами (Слайдер на головній)</h2>
    
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; gap: 25px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 300px; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6;">
            <h4>➕ Додати новий банер</h4>
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:600; margin-bottom:5px;">Назва/Заголовок (для внутрішнього обліку)</label>
                    <input type="text" name="title" placeholder="Напр. Акція на iPhone 16" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:600; margin-bottom:5px;">Зображення банера</label>
                    <input type="file" name="image" required style="width:100%; padding:5px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:600; margin-bottom:5px;">Посилання при кліку (URL)</label>
                    <input type="text" name="url_link" placeholder="Напр. /admin/products або повне посилання" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display:block; font-weight:600; margin-bottom:5px;">Порядок сортування</label>
                    <input type="number" name="sort_order" value="0" style="width:100%; padding:8px; border:1px solid #ddd; border-radius:4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="cursor:pointer; font-weight:600;">
                        <input type="checkbox" name="is_active" value="1" checked> Активний (відображати зараз)
                    </label>
                </div>
                <button type="submit" style="background:#28a745; color:white; border:none; padding:10px 15px; border-radius:4px; cursor:pointer; width:100%; font-weight:bold;">Зберегти банер</button>
            </form>
        </div>

        <div style="flex: 2; min-width: 500px; background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6;">
            <h4>🖼️ Активні рекламні місця</h4>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6; text-align: left;">
                        <th style="padding: 10px;">Прев'ю</th>
                        <th style="padding: 10px;">Назва/Посилання</th>
                        <th style="padding: 10px;">Сортування</th>
                        <th style="padding: 10px;">Дія</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;">
                                <img src="{{ asset($banner->image) }}" style="max-width: 180px; max-height: 80px; border-radius: 4px; object-fit: cover;">
                            </td>
                            <td style="padding: 10px;">
                                <strong>{{ $banner->title ?? 'Без назви' }}</strong><br>
                                <span style="font-size: 12px; color: #666;">{{ $banner->url_link ?? 'Немає посилання' }}</span>
                            </td>
                            <td style="padding: 10px;">{{ $banner->sort_order }}</td>
                            <td style="padding: 10px;">
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Видалити цей банер?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:#dc3545; color:white; border:none; padding:5px 10px; border-radius:4px; cursor:pointer;">❌ Видалити</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 20px; text-align: center; color: #999;">Жодного банера ще не додано. На головній сторінці відображається статичний макет.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection