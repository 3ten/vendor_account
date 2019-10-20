 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
     <title>Document</title>
     <link rel="stylesheet" href="css/app.css">
     <script src="js/app.js" defer></script>
 </head>
 <body>
     <header>
        @yield('header')
     </header>
     <div id="content">
        @yield('content')
     </div>
     <footer>
        @yield('footer')
     </footer>
 </body>
 </html>