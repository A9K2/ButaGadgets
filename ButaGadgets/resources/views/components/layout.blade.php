<!DOCTYPE html>

<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>{{ env('APP_NAME')}}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<!-- 🔹 HEADER -->

<header class="bg-white shadow-md">
  <div class="container mx-auto flex items-center justify-between p-4">
    <h1 class="text-2xl font-bold text-green-600"><a href="{{route('index')}}">ButaGadgets</a></h1>


<input type="text" placeholder="Я шукаю..." 
  class="border rounded-xl px-4 py-2 w-1/2">

<div class="flex gap-4">

  @guest
  <span><a href="{{route('login')}}">Вхід</a></span>  
  @endguest

  @guest
  <span><a href="{{route('register')}}">Реєстрація👤</a></span>  
  @endguest

  @auth
  <span>Привіт, *Ім'я</span>
  @endauth

  <span>Обране❤️</span>
  <span>Кошик🛒</span>

  @auth
  <span>
    <form action="{{route('logout')}}" method="POST">
      @csrf
      <button>
        Вихід
      </button>
    </form>
  </span>
  @endauth
</div>


  </div>
</header>

<!-- 🔹 MAIN -->

<div class="container mx-auto p-4 flex gap-4">

  <!-- 🔹 SIDEBAR -->

  @if (
    !request()->routeIs('register') &&
    !request()->routeIs('login')
      )

    @if (request()->routeIs('phones'))
        @include('components.filters.phones')

    @elseif (request()->routeIs('laptops'))
        @include('components.filters.laptops')

    @elseif (request()->routeIs('householdAppliances'))
        @include('components.filters.householdAppliances')

    @elseif (request()->routeIs('home'))
        @include('components.filters.home')

    @elseif (request()->routeIs('gaming'))
        @include('components.filters.gaming')

    @else
        @include('components.sidebar.categories')
    @endif

    @endif

  <!-- 🔹 CONTENT -->

  {{$slot}}

  </main>
</div>

</body>
</html>
