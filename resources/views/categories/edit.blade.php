<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Κατηγορίας</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>

    @include('navbar')

    <h1>✏️ Επεξεργασία Κατηγορίας: {{ $category->name }}</h1>
    <p><a href="/categories">← Πίσω στις Κατηγορίες</a></p>

    <form action="/categories/{{ $category->id }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Όνομα Κατηγορίας:</label>
        <input type="text" id="name" name="name" value="{{ $category->name }}" required>

        <label for="color">Χρώμα:</label>
        <input type="color" id="color" name="color" value="{{ $category->color }}" style="padding:0; width:80px; height:40px; border:none; cursor:pointer;">

        <br><br>
        <button type="submit">Αποθήκευση Αλλαγών</button>
    </form>

</body>

</html>