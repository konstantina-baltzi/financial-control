<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Λογαριασμού</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>

    <h1>Επεξεργασία: {{ $bill->title }} ✏️</h1>
    <p><a href="/bills">← Πίσω στη Λίστα</a></p>

    {{-- Η φόρμα στέλνει τα δεδομένα στο /bills/id --}}
    <form action="/bills/{{ $bill->id }}" method="POST">
        @csrf
        @method('PUT') {{-- Η Laravel χρειάζεται το PUT για ανανεώσεις δεδομένων --}}

        <label for="title">Όνομα Υποχρέωσης:</label>
        <input type="text" id="title" name="title" value="{{ $bill->title }}" required>

        <label for="amount">Ποσό (€):</label>
        <input type="number" id="amount" name="amount" step="0.01" value="{{ $bill->amount }}">

        <label for="paid_at">Ημερομηνία Πληρωμής:</label>
        <input type="date" id="paid_at" name="paid_at"
            value="{{ $bill->paid_at ? $bill->paid_at->format('Y-m-d') : '' }}">

        <label for="expires_at">Ημερομηνία Λήξης:</label>
        <input type="date" id="expires_at" name="expires_at"
            value="{{ $bill->expires_at ? $bill->expires_at->format('Y-m-d') : '' }}">

        <label for="notes">Σημειώσεις:</label>
        <textarea id="notes" name="notes" rows="4">{{ $bill->notes }}</textarea>

        <button type="submit">Αποθήκευση Αλλαγών</button>
    </form>

</body>

</html>