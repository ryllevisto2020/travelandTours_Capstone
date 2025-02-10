<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="{{ asset('icon.jpg') }}" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JVD Event and Travel Company</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('loader.css') }}" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="{{ asset('js/opencv.js') }}"></script>
  @vite(['resources/js/main.js'])

</head>

<body>
  <div id="app" class="dialog">

  </div>

  <script>
    const loaderColor = localStorage.getItem('sneat-initial-loader-bg') || '#FFFFFF'
    const primaryColor = localStorage.getItem('sneat-initial-loader-color') || '#696CFF'

    if (loaderColor)
      document.documentElement.style.setProperty('--initial-loader-bg', loaderColor)

    if (primaryColor)
      document.documentElement.style.setProperty('--initial-loader-color', primaryColor)
  </script>
</body>

</html>
