<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>{{ env('APP_NAME')}}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<header class="bg-white shadow-md">
  <div class="container mx-auto flex items-center justify-between p-4">
    <h1 class="text-2xl font-bold text-green-600"><a href="{{route('index')}}">ButaGadgets</a></h1>
    <form action="{{ route('search') }}" method="GET" style="flex:1">
      <input type="text"
             name="q"
             value="{{ request('q') }}"
             placeholder="Я шукаю..."
             class="border rounded-xl px-4 py-2 w-full">
    </form>
    <div class="flex gap-4">
      @guest
        <span><a href="{{route('login')}}">Вхід</a></span>
        <span><a href="{{route('register')}}">Реєстрація👤</a></span>
      @endguest
      @auth
        <span>Привіт, {{auth()->user()->username}}</span>
      @endauth

      @auth
      @php $favCount = \App\Models\Favorite::where('user_id', auth()->id())->count() @endphp
      <a href="{{ route('favorites.index') }}">
        Обране{{ $favCount > 0 ? '❤️' : '🤍' }}
        @if($favCount > 0)
          <span class="inline-flex items-center justify-center w-5 h-5 bg-green-500 text-white text-xs rounded-full ml-1">
            {{ $favCount }}
          </span>
        @endif
      </a>
      @else
        <a href="{{ route('login') }}">Обране🤍</a>
      @endauth

        @auth
        @php
          $cartCount = \App\Models\Cart::where('user_id', auth()->id())
                        ->first()?->items()->sum('quantity') ?? 0;
        @endphp
        <a href="{{ route('cart.index') }}">
          Кошик🛒
          @if($cartCount > 0)
            <span class="inline-flex items-center justify-center w-5 h-5 bg-green-500 text-white text-xs rounded-full ml-1">
              {{ $cartCount }}
            </span>
          @endif
        </a>
        @else
        <a href="{{ route('login') }}">Кошик🛒</a>
        @endauth
        @auth
          <a href="{{ route('orders') }}">Замовлення 📦</a>
        @endauth
        @auth
        <span>
          <form action="{{route('logout')}}" method="POST">
            @csrf
            <button>Вихід</button>
          </form>
        </span>
      @endauth
    </div>
  </div>
</header>

<div class="container mx-auto p-4 flex gap-4">

  @if(!request()->routeIs('register') && !request()->routeIs('login'))
    @if(request()->routeIs('category.show'))
      {{ $sidebar ?? '' }}
    @elseif(request()->routeIs('home'))
      @include('components.filters.home')
    @elseif(request()->routeIs('gaming'))
      @include('components.filters.gaming')
    @else
      @include('components.sidebar.categories')
    @endif
  @endif

  <div class="flex-1 min-w-0">
    {{ $slot }}
  </div>

</div>
{{-- BOTPRESS CHATBOT --}}
<script src="https://cdn.botpress.cloud/webchat/v3.6/inject.js"></script>
<script src="https://files.bpcontent.cloud/2026/06/12/18/20260612184028-P6B9L4RC.js" defer></script>

</body>
</html>