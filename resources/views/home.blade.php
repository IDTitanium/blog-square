<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Blog Square (Your all-in-one blogging platfrom)</title>

        {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous"> --}}
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
        <h3 class="text-center">All Blog posts</h3>
        <table class="table">
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>@sortablelink('published_at', 'Date of Publication')</th>
            </tr>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->description }}</td>
                    <td>{{ $post->user_name }} </td>
                    <td>{{\Carbon\Carbon::parse($post->published_at) }}</td>
                </tr>
            @endforeach
        </table>
        {!! $posts->appends(\Request::except('page'))->render() !!}

    </div>


    </body>
</html>
