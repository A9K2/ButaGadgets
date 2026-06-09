@extends('admin.layouts.app')

@section('content')
<div style="padding: 20px; font-family: 'Segoe UI', system-ui, sans-serif;">
    
    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 25px;">
        <h2 style="margin: 0 0 5px 0; color: #333;">✏️ Редагування товару: {{ $product->name }}</h2>
        <p style="margin: 0; color: #666; font-size: 14px;">Внесіть зміни в загальні параметри або технічні характеристики пристрою.</p>
    </div>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @php
            $specs = DB::table('phones')->where('product_id', $product->id)->first() 
                  ?? DB::table('laptops')->where('product_id', $product->id)->first();
        @endphp

        <div style="display: flex; gap: 25px; flex-wrap: wrap; align-items: flex-start;">
            
            <div style="flex: 2; min-width: 60%; display: flex; flex-direction: column; gap: 25px;">
                
                <div style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <h5 style="margin-top: 0; margin-bottom: 20px; color: #4e73df; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px;">📦 Основна інформація</h5>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #495057;">Назва товару</label>
                        <input type="text" name="name" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; box-sizing: border-box;" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div style="display: flex; gap: 20px; margin-bottom: 15px; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #495057;">Поточна ціна (грн)</label>
                            <input type="number" step="0.01" name="price" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; box-sizing: border-box;" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #dc3545;">Стара ціна (акційна закреслена)</label>
                            <input type="number" step="0.01" name="old_price" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; box-sizing: border-box;" value="{{ old('old_price', $product->old_price) }}">
                        </div>
                        <div style="flex: 1; min-width: 200px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #495057;">Кількість на складі</label>
                            <input type="number" name="quantity" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; box-sizing: border-box;" value="{{ old('quantity', $product->quantity) }}" required>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 30px; background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 15px; border: 1px dashed #ced4da;">
                        <label style="display: flex; align-items: center; gap: 10px; font-weight: 600; color: #4e73df; cursor: pointer;">
                            <input type="checkbox" name="is_popular" value="1" style="transform: scale(1.3);" {{ old('is_popular', $product->is_popular) ? 'checked' : '' }}>
                            ⭐ Популярний товар (на головну)
                        </label>
                        
                        <label style="display: flex; align-items: center; gap: 10px; font-weight: 600; color: #1cc88a; cursor: pointer;">
                            <input type="checkbox" name="is_action" value="1" style="transform: scale(1.3);" {{ old('is_action', $product->is_action) ? 'checked' : '' }}>
                            🔥 Акційний товар (у промо-блок)
                        </label>
                    </div>
                        <div style="flex: 1;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #495057;">Кількість на складі</label>
                            <input type="number" name="quantity" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; box-sizing: border-box;" value="{{ old('quantity', $product->quantity) }}" required>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #495057;">Опис товару</label>
                        <textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; box-sizing: border-box; resize: vertical;">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div style="margin-bottom: 5px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #495057;">Зображення товару</label>
                        @if(!empty($product->image))
                            <div style="margin-bottom: 10px;">
                                <img src="{{ asset($product->image) }}" style="max-height: 80px; border-radius: 4px; border: 1px solid #ddd;">
                            </div>
                        @endif
                        <input type="file" name="image" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 6px; background: #f8f9fa;" accept="image/*">
                    </div>
                </div>

                <div id="specs_card" style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; box-shadow: 0 4px 6px rgba(0,0,0,0.02); display: none;">
                    <h5 id="specs_title" style="margin-top: 0; margin-bottom: 10px; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px;">💻 Технічні характеристики</h5>
                    <p style="color: #666; font-size: 13px; margin-bottom: 20px;">Параметри пристрою підлаштуються під обрану категорію автоматично.</p>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                        
                        <div class="spec-field laptop-field phone-field" style="flex: 1; min-width: calc(50% - 10px);">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; color: #495057;">Процесор</label>
                            <select name="processor_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;">
                                <option value="">-- Оберіть процесор --</option>
                                @foreach($processors as $processor)
                                    <option value="{{ $processor->id }}" {{ old('processor_id', $specs->processor_id ?? '') == $processor->id ? 'selected' : '' }}>{{ $processor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spec-field laptop-field" style="flex: 1; min-width: calc(50% - 10px);">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; color: #495057;">Відеокарта</label>
                            <select name="video_card_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;">
                                <option value="">-- Оберіть відеокарту --</option>
                                @foreach($video_cards as $vc)
                                    <option value="{{ $vc->id }}" {{ old('video_card_id', $specs->video_card_id ?? '') == $vc->id ? 'selected' : '' }}>{{ $vc->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spec-field laptop-field phone-field" style="flex: 1; min-width: calc(50% - 10px);">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; color: #495057;">RAM (ОЗП)</label>
                            <select name="ram_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;">
                                <option value="">-- Оберіть об'єм RAM --</option>
                                @foreach($rams as $ram)
                                    <option value="{{ $ram->id }}" {{ old('ram_id', $specs->ram_id ?? '') == $ram->id ? 'selected' : '' }}>{{ $ram->size }} GB</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spec-field laptop-field phone-field" style="flex: 1; min-width: calc(50% - 10px);">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; color: #495057;">Накопичувач (Storage)</label>
                            <select name="storage_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;">
                                <option value="">-- Оберіть об'єм пам'яті --</option>
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}" {{ old('storage_id', $specs->storage_id ?? '') == $storage->id ? 'selected' : '' }}>{{ $storage->size }} GB</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spec-field laptop-field" style="flex: 1; min-width: calc(33.333% - 14px);">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; color: #495057;">Діагональ екрану</label>
                            <select name="screen_size_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;">
                                <option value="">-- Діагональ --</option>
                                @foreach($screen_sizes as $ss)
                                    <option value="{{ $ss->id }}" {{ old('screen_size_id', $specs->screen_size_id ?? '') == $ss->id ? 'selected' : '' }}>{{ $ss->size }}″</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spec-field laptop-field phone-field" style="flex: 1; min-width: calc(33.333% - 14px);">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; color: #495057;">Тип матриці / екрану</label>
                            <select name="screen_type_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;">
                                <option value="">-- Матриця --</option>
                                @foreach($screen_types as $st)
                                    <option value="{{ $st->id }}" {{ old('screen_type_id', $specs->screen_type_id ?? '') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spec-field laptop-field phone-field" style="flex: 1; min-width: calc(33.333% - 14px);">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; color: #495057;">Операційна система</label>
                            <select name="operating_system_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;">
                                <option value="">-- Оберіть ОС --</option>
                                @foreach($operating_systems as $os)
                                    <option value="{{ $os->id }}" {{ old('operating_system_id', $specs->operating_system_id ?? '') == $os->id ? 'selected' : '' }}>{{ $os->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spec-field laptop-field phone-field" style="flex: 1; min-width: calc(50% - 10px);">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; color: #495057;">Колір корпусу</label>
                            <select name="color_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;">
                                <option value="">-- Оберіть колір --</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}" {{ old('color_id', $specs->color_id ?? '') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="spec-field phone-field" style="flex: 1; min-width: calc(50% - 10px);">
                            <label style="display: block; font-weight: 600; margin-bottom: 6px; color: #495057;">Ємність акумулятора</label>
                            <select name="battery_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;">
                                <option value="">-- Оберіть ємність батареї --</option>
                                @foreach($batteries as $battery)
                                    <option value="{{ $battery->id }}" {{ old('battery_id', $specs->battery_id ?? '') == $battery->id ? 'selected' : '' }}>{{ $battery->capacity }} mAh</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 25px;">
                
                <div style="background: #fff; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <h5 style="margin-top: 0; margin-bottom: 20px; color: #f6c23e; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px;">🏷 Класифікація</h5>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #495057;">Батьківська категорія</label>
                        <select name="category_id" id="category_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;" required>
                            <option value="">-- Оберіть категорію --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-slug="{{ Str::slug($category->name) }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #495057;">Підкатегорія</label>
                        <select name="subcategory_id" id="subcategory_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;" required>
                            @foreach($subcategories as $sub)
                                <option value="{{ $sub->id }}" data-category="{{ $sub->category_id }}" {{ old('subcategory_id', $product->subcategory_id) == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #495057;">Бренд / Виробник</label>
                        <select name="brand_id" style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 6px; background-color: #fff;" required>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <button type="submit" style="width: 100%; background-color: #007bff; color: white; border: none; padding: 12px; font-size: 16px; font-weight: bold; border-radius: 6px; cursor: pointer; margin-bottom: 10px;">💾 Зберегти зміни</button>
                    <a href="{{ route('admin.products.index') }}" style="display: block; text-align: center; width: 100%; background-color: #fff; color: #6c757d; border: 1px solid #6c757d; padding: 10px; font-size: 15px; border-radius: 6px; text-decoration: none; box-sizing: border-box;">Назад</a>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');
        const allSubOptions = Array.from(subcategorySelect.options);
        
        const specsCard = document.getElementById('specs_card');
        const specsTitle = document.getElementById('specs_title');
        const allFields = document.querySelectorAll('.spec-field');

        function updateFormLayout() {
            const selectedOption = categorySelect.options[categorySelect.selectedIndex];
            const selectedCatId = categorySelect.value;
            
            if (!selectedCatId) {
                specsCard.style.display = 'none';
                return;
            }

            // 1. Динамічна фільтрація підкатегорій
            const currentSubValue = subcategorySelect.value;
            subcategorySelect.innerHTML = '<option value="">-- Оберіть підкатегорію --</option>';
            allSubOptions.forEach(option => {
                if (option.getAttribute('data-category') === selectedCatId) {
                    const clone = option.cloneNode(true);
                    if(clone.value === currentSubValue) clone.selected = true;
                    subcategorySelect.appendChild(clone);
                }
            });

            // 2. Фільтрація полів конфігуратора
            const slug = selectedOption.getAttribute('data-slug') || '';
            specsCard.style.display = 'block';
            allFields.forEach(field => field.style.display = 'none');

            if (slug.includes('noutbuk') || slug.includes('laptop')) {
                specsTitle.innerHTML = '💻 Характеристики ноутбука';
                specsTitle.style.color = '#1cc88a';
                document.querySelectorAll('.laptop-field').forEach(f => f.style.display = 'block');
            } else if (slug.includes('smartfon') || slug.includes('phone')) {
                specsTitle.innerHTML = '📱 Характеристики смартфона';
                specsTitle.style.color = '#4e73df';
                document.querySelectorAll('.phone-field').forEach(f => f.style.display = 'block');
            } else {
                specsTitle.innerHTML = '⚙️ Технічні характеристики';
                specsTitle.style.color = '#333';
                allFields.forEach(f => f.style.display = 'block');
            }
        }

        categorySelect.addEventListener('change', updateFormLayout);
        updateFormLayout(); // Первинний виклик при завантаженні сторінки редагування
    });
</script>
@endsection