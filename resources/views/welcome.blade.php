<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Laravel</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">



<style>
body {
font-family: 'Nunito', sans-serif;
}
</style>
</head>
<body class="antialiased">

<div class="container-fluid">
<div class="row" style="height: 100vh;background: #efefef;">

<div class="col-lg-12" style="padding: 30px;">
<center>
    <h1 style="">Welcome To LendTech</h1>
    <p>You can quickly register and be able to apply for a loan!</p>

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
        <a href="{{ url('/dashboard') }}" class="text-sm  text-gray-700 dark:text-gray-500 underline">
            <button type="button" class="btn btn-dark">Dashboard</button>
        
    </a>
        @else
        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 ">
           
       
    </a>

        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 ">
             <button type="button" class="btn btn-dark"> Register</button>
        </a>
        @endif
        @endauth
        </div>
        @endif
        </div>
</center>

</div>
</div>
</div>



</body>
</html>
