<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Blog Square (Your all-in-one blogging platfrom)</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    </head>
    <body>
    @include('sweetalert::alert')

    <div class="container">
        <nav class="navbar bg-light" style="margin-bottom: 20px">
            <div class="container-fluid">
              <a class="navbar-brand">Blog Square</a>
              @if (Route::has('login'))
              <div>
                  @auth
                      <a href="{{ url('/dashboard') }}" class="font-size-sm text-secondary dark:text-dark text-decoration-none">Dashboard</a>
                  @else
                        <a href="{{ route('login') }}" class="mr-10 font-size-sm text-secondary dark:text-dark text-decoration-none">Log in</a>
                      @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-5 font-size-sm text-secondary dark:text-dark text-decoration-none" style="margin-left: 15px">Register</a>
                    @endif
                  @endauth
              </div>
              @endif
            </div>
          </nav>

        <p><h3 class="text-center">All Blog posts</h3></p>
        <x-posts-view :posts="$posts"/>
    </div>
    </body>
</html>
