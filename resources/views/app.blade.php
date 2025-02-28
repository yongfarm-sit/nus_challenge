<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- Laravel PWA -->
    @laravelPWA

    <!-- vite -->
    @viteReactRefresh
    @vite('resources/js/app.jsx')
    @inertiaHead
  </head>
  <body>
    <h1>This is the blade.php view</h1>
    @inertia
  </body>
</html>