<!DOCTYPE html>
<html lang="en"  class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>{{$title}}</title>
</head>

<body class="h-full">
  

<div class="min-h-full">


      <nav class="bg-gray-500">
        <div class="mx-auto max-w-10xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-25 items-center justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <img class="h-20 w-40 mr-5 py-4" src={{ asset('compass.png') }} alt="compasss">
              </div>
              <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                  <a href="/welcome" class="text-blue-300 hover:bg-gray-700 hover:text-green rounded-md px-3 py-2 text-sm font-medium">Home</a>
                  @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-blue-300 dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-blue-300 dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-blue-300 dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                                @endif
                 </div>
              </div>
            </div>
          </div>
        </div>
      </nav>

  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900"> {{$heading}} </h1>
    </div>
  </header>

  <main class="bg-gray-300">
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
    {{$content}}
    </div>
  </main>

<footer class="bg-gray-500 text-white text-center py-4 mt-2">
  <div class="container mx-auto flex items-center justify-between">

              <div class="flex items-center">
                  <img src={{ asset('compass.png') }} alt="compass" class="h-200 w-400 mr-4">
              </div>

              <div>
                  <p class="text-2xl font-bold text-blue-300">Follow Us :</p></br>
                  <a href="https://www.facebook.com/cput.ac.za" class="text-gray-300 mx-10 hover:text-white" title="https://www.facebook.com/cput.ac.za">
                      <i class="fab fa-facebook fa-2x"></i>
                  </a>
                  <a href="https://twitter.com/CPUT" class="text-gray-300 mx-10 hover:text-white" title="https://twitter.com/CPUT">
                      <i class="fab fa-twitter fa-2x"></i>
                  </a>
                  <a href="https://www.instagram.com" class="text-gray-300 mx-10 hover:text-white" title="Instagram">
                      <i class="fab fa-instagram fa-2x"></i>
                  </a>
                  <a href="https://www.youtube.com/user/cputnews" class="text-gray-300 mx-10 hover:text-white" title="https://www.youtube.com/user/cputnews">
                    <i class="fab fa-youtube fa-2x"></i>
                  </a>
            </div>

              <div>
                  <h2 class="text-2xl font-bold text-blue-300">Contact Us :</h2>
                  <p class="text-gray-300">Call Centre: +27 21 959 6767</p>
                  <p class="text-gray-300">Email: info@Campus.ac.za</p>
                  <p class="text-gray-300">support@compass.com</p>
              </div>
  </div>
            <p class="text-white text-center py-4 mt-4">
              &copy; 2024 Copyright, Compass.
            </p>
</footer>

</body>
</html>