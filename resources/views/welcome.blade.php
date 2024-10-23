<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel with Vue 3 and TypeScript</title>
    @vite(['resources/js/app.ts', 'resources/css/app.css']) <!-- Correct usage -->
</head>

<body class="antialiased">
    <div id="app"></div>
</body>

</html>
