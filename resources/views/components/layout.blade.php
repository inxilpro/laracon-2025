@props(['title' => 'Laracon US 2025'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>{{ $title }}</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 flex items-stretch min-h-screen flex-col">

{{ $slot }}

</body>
</html>
