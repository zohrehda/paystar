<!doctype html>
<html lang="en">

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="{{asset('css/style.css') }}" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <main>
            @if(session('message'))
            <div class="alert alert-danger" role="alert">
                {{session('message')}}
            </div>
            @endif

            @yield('main')
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2023 Company Name</p>
            <ul class="list-inline">
                @auth
                <li class="list-inline-item"><a href="{{route('checkout')}}">Checkout</a></li>
                <li class="list-inline-item"><a href="{{route('logout')}}">Logout</a></li>
                @endAuth

                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>

</html>