<x-layout>
<main class="w-4/5 space-y-6">

    
    <!-- 🔹 HERO -->
    <section class="grid grid-cols-4 gap-4">
      <div class="col-span-2 bg-pink-200 rounded-2xl p-6 flex flex-col justify-between">
        <h2 class="text-3xl font-bold">Забери подарунок </h2>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-xl w-fit">Отримати</button>
      </div>
    
      <div class="bg-white p-4 rounded-2xl shadow-sm">
        <img src="https://www.samsung-online.com.ua/uploads/shop/products/large/76c264d190144ad195a2733a9da1b0c8.jpg" class="mx-auto mb-2">
        <p class="text-center font-semibold">Samsung S24 Plus</p>
        <p class="text-center text-green-600">30 900₴</p>
      </div>
    
      <div class="bg-white p-4 rounded-2xl shadow-sm">
        <img src="https://hdphone.com.ua/image/cache/wp/ij/data/Apple/iPhone_16/apple_iphone_16_img1.webp" class="mx-auto mb-2">
        <p class="text-center font-semibold">iPhone 16</p>
        <p class="text-center text-green-600">51 999₴</p>
      </div>
    </section>
    
    <!-- 🔹 CATEGORIES -->
    <section class="grid grid-cols-6 gap-4">
      <div class="bg-white p-4 rounded-xl text-center shadow-sm"><a href="{{route('phones')}}">Смартфони</a></div>
      <div class="bg-white p-4 rounded-xl text-center shadow-sm"><a href="{{route('laptops')}}">Ноутбуки</a></div>
      <div class="bg-white p-4 rounded-xl text-center shadow-sm"><a href="{{route('gaming')}}">Геймінг</a></div>
      <div class="bg-white p-4 rounded-xl text-center shadow-sm"><a href="{{route('householdAppliances')}}">Техніка</a></div>
      <div class="bg-white p-4 rounded-xl text-center shadow-sm"><a href="{{route('home')}}">Дім</a></div>
    </section>
    
    <!-- 🔹 PROMO -->
    <section class="grid grid-cols-3 gap-4">
      <div class="bg-green-400 text-white p-6 rounded-2xl">
        <h3 class="text-2xl font-bold">Пральні машини</h3>
        <p>Знижки до 50%</p>
      </div>
    
      <div class="bg-yellow-300 p-6 rounded-2xl">
        <h3 class="text-xl font-bold">Чохли</h3>
        <p>від 139₴</p>
      </div>
    
      <div class="bg-green-500 text-white p-6 rounded-2xl">
        <h3 class="text-4xl font-bold">Акційні товари</h3>
      </div>
    </section>
    
    <!-- 🔹 PRODUCTS -->
    
    <h2 class="text-2xl font-bold mb-4">Популярні товари</h2>
  
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl shadow-sm">
          <img src="https://cdn.comfy.ua//media/catalog/product/i/m/img_2742.jpg">
          <p class="mt-2">Товар 1</p>
        </div>
    
        <div class="bg-white p-4 rounded-xl shadow-sm">
          <img src="https://scdn.comfy.ua/89fc351a-22e7-41ee-8321-f8a9356ca351/https://cdn.comfy.ua/media/catalog/product/i/m/img_0988_copy.jpg/w_1440">
          <p class="mt-2">Товар 2</p>
        </div>
    
        <div class="bg-white p-4 rounded-xl shadow-sm">
          <img src="https://i.allo.ua/media/catalog/product/cache/1/image/710x600/602f0fa2c1f0d1ba5e241f914e856ff9/3/9/391885922_3_4.webp">
          <p class="mt-2">Товар 3</p>
        </div>
    
        <div class="bg-white p-4 rounded-xl shadow-sm">
          <img src="https://scdn.comfy.ua/89fc351a-22e7-41ee-8321-f8a9356ca351/https://cdn.comfy.ua/media/catalog/product/y/o/yoga_7_2-in-1_14akp10_seashell.jpg/w_1440">
          <p class="mt-2">Товар 4</p>
        </div>
      </div>
  </x-layout>

  
