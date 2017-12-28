<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Task Scheduler @yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="/css/style.css" rel="stylesheet">
    @section('style')
    @show
</head>
<body>

@section('body')
@show

<footer>
    <a href="https://GitHub.com/RostislavZalevsky">By Rostislav Zalevsky &copy; <?php echo date('Y')?></a>
</footer>

<script src="/js/jquery-3.2.1.min.js" rel="stylesheet"></script>
@section('script')
@show
</body>
</html>