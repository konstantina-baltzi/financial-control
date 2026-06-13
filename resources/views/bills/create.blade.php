<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Προσθήκη Λογαριασμού</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    @include('navbar')
    <h1>Νέος Λογαριασμός 📝</h1>
    <p><a href="/bills">← Πίσω στη Λίστα</a></p>

    {{-- Η φόρμα στέλνει τα δεδομένα με μέθοδο POST στο route /bills --}}
    <form action="/bills" method="POST">
        {{-- ΠΟΛΥ ΣΗΜΑΝΤΙΚΟ: Το @csrf είναι απαραίτητο στη Laravel για λόγους ασφαλείας, αλλιώς η φόρμα θα βγάζει error --}}
        @csrf

        <label for="title">Όνομα Υποχρέωσης / Λογαριασμού (π.χ. ΔΕΗ, ΚΤΕΟ):</label>
        <input type="text" id="title" name="title" required>

        <label for="amount">Ποσό (€):</label>
        <input type="number" id="amount" name="amount" step="0.01">

        <label for="paid_at">Ημερομηνία Πληρωμής (Προαιρετικό):</label>
        <input type="date" id="paid_at" name="paid_at">

        <label for="expires_at">Ημερομηνία Λήξης / Επόμενης Πληρωμής:</label>
        <input type="date" id="expires_at" name="expires_at">

        <label for="notes">Σημειώσεις:</label>
        <textarea id="notes" name="notes" rows="4"></textarea>

        <label for="frequency">Επανάληψη Λογαριασμού:</label>
        <select id="frequency" name="frequency">
            <option value="none">Όχι, είναι εφάπαξ</option>
            <option value="monthly">Κάθε Μήνα</option>
            <option value="yearly">Κάθε Χρόνο</option>
        </select>

        <button type="submit">Αποθήκευση Λογαριασμού</button>
    </form>

</body>

</html>