<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Control - Λογαριασμοί</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>

    <h1>Financial Control 📊</h1>
    <h2>Οι Λογαριασμοί μου</h2>
    <p><a href="/bills/create" style="background-color: #0076d6; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px;">+ Προσθήκη Νέου Λογαριασμού</a></p>

    {{-- Εμφάνιση μηνύματος επιτυχίας αν υπάρχει --}}
    @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
    @endif
    <table>
        <thead>
            <tr>
                <th>Όνομα Υποχρέωσης</th>
                <th>Ποσό (€)</th>
                <th>Ημερ. Πληρωμής</th>
                <th>Ημερ. Λήξης</th>
                <th>Σημειώσεις</th>
            </tr>
        </thead>
        <tbody>
            {{-- Εδώ η Laravel κάνει λούπα (foreach) όλους τους λογαριασμούς --}}
            @forelse($bills as $bill)
            <tr>
                <td><strong>{{ $bill->title }}</strong></td>
                <td>{{ $bill->amount ?? '-' }}</td>
                <td>{{ $bill->paid_at ?? 'Δεν πληρώθηκε' }}</td>
                <td>{{ $bill->expires_at ?? '-' }}</td>
                <td>{{ $bill->notes ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Δεν υπάρχουν καταχωρημένοι λογαριασμοί ακόμα!</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>