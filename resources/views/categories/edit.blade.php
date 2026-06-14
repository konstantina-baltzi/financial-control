<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Edit Category') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>

    @include('navbar')

    <h1>✏️ {{ __('Edit Category:') }} {{ $category->name }}</h1>
    <p><a href="/categories">← {{ __('Back to Categories') }}</a></p>

    <form action="/categories/{{ $category->id }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">{{ __('Category Name:') }}</label>
        <input type="text" id="name" name="name" value="{{ $category->name }}" required>

        <label for="color">{{ __('Color:') }}</label>
        <input type="color" id="color" name="color" value="{{ $category->color }}" style="padding:0; width:80px; height:40px; border:none; cursor:pointer;">

        <br><br>
        <button type="submit">{{ __('Save Changes') }}</button>
    </form>

</body>

</html>