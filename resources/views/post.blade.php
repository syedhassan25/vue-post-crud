1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
 
    <title>Crud</title>
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.css" media="screen" title="no title" charset="utf-8">
 
    <script>
        window.BaseUrl = '{{ url("/") }}'
    </script>
</head>
<body>
<div class="ui container">
 
    <base href="{{ url('/') }}" />
 
    <div class="content">
        <div id="app">
            <main-app></main-app>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.js" charset="utf-8"></script>
</body>
</html>