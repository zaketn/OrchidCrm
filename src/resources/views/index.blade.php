<html class="h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.98.0">
    <title>Web Dev</title>

    {{-- Bootstrap CSS only  --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    {{--  font-awesome  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body>
<div class="container-fluid p-0 m-0 d-flex h-100 text-white bg-dark">
    <div class="container d-flex w-100 h-100 p-3 mx-auto flex-column">

        <x-header></x-header>

        <main class="px-3">
            <div class="text-center">
                <h1 class="mb-4">Решаем ваши задачи.</h1>
                <p class="lead mb-4">Подайте заявку на встречу, кратко ее описав. Наш представитель
                    встретится с вами и обсудит все детали. Далее команда квалифицированных специалистов реализует ваши
                    идеи
                    в короткие сроки.</p>
                <p class="lead">
                    @auth
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-lg btn-primary fw-bold" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                            Подать заявку
                        </button>
                    @endauth

                    @guest
                        <span class="d-block mb-3">Но сначала нужно зарегистрироваться</span>
                        <a href="{{ route('register') }}" class="btn btn-lg btn-primary">Зарегистрируйтесь</a>
                    @endguest
                </p>
            </div>
        </main>

        <!-- Modals -->
        @auth
            <x-modals.lead-create></x-modals.lead-create>
            <x-modals.lead-personal></x-modals.lead-personal>
            <x-modals.meetup-personal></x-modals.meetup-personal>
            <x-modals.project-personal></x-modals.project-personal>
            <x-modals.logout></x-modals.logout>
        @endauth

        <x-footer/>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>


</body>
</html>
