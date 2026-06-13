<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Control - Λογαριασμοί</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Σπάμε το στενό όριο του water.css για να απλωθεί η εφαρμογή */
        body {
            max-width: 1200px !important;
            /* Ή 95% αν το θες σχεδόν full screen */
            width: 95%;
            margin: 20px auto;
        }

        /* Διορθώνουμε τον πίνακα να μην στριμώχνεται */
        table {
            width: 100% !important;
            table-layout: auto;
        }

        /* Δίνουμε λίγο αέρα στις στήλες για να μην καβαλάνε η μία την άλλη */
        th,
        td {
            padding: 12px 8px !important;
            text-align: left;
            vertical-align: middle;
        }
    </style>
</head>


<body>
    @include('navbar')
    <h1>Financial Control 📊</h1>
    <h2>Οι Λογαριασμοί μου</h2>
    <div style="display: flex; gap: 20px; margin-bottom: 25px; flex-wrap: wrap;">

        <div style="flex: 1; min-width: 200px; background-color: rgba(40, 167, 69, 0.1); border-left: 5px solid #28a745; padding: 15px; border-radius: 4px;">
            <span style="font-size: 14px; color: #555; text-transform: uppercase; font-weight: bold;">Συνολικά Πληρωμένα</span>
            <h3 style="margin: 5px 0 0 0; color: #28a745; font-size: 24px;">{{ number_format($totalPaid, 2, ',', '.') }} €</h3>
        </div>

        <div style="flex: 1; min-width: 200px; background-color: rgba(0, 123, 255, 0.1); border-left: 5px solid #007bff; padding: 15px; border-radius: 4px;">
            <span style="font-size: 14px; color: #555; text-transform: uppercase; font-weight: bold;">Αναμονή / Εκκρεμούν</span>
            <h3 style="margin: 5px 0 0 0; color: #007bff; font-size: 24px;">{{ number_format($totalUnpaid, 2, ',', '.') }} €</h3>
        </div>

        <div style="flex: 1; min-width: 200px; background-color: rgba(220, 53, 69, 0.1); border-left: 5px solid #dc3545; padding: 15px; border-radius: 4px;">
            <span style="font-size: 14px; color: #555; text-transform: uppercase; font-weight: bold;">Ληγμένοι Λογαριασμοί</span>
            <h3 style="margin: 5px 0 0 0; color: #dc3545; font-size: 24px;">{{ $expiredCount }} 🚨</h3>
        </div>

    </div>
    <p><a href="/bills/create" style="background-color: #0076d6; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px;">+ Προσθήκη Νέου Λογαριασμού</a></p>

    {{-- Εμφάνιση μηνύματος επιτυχίας αν υπάρχει --}}
    @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
    @endif

    <form action="/bills" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center; background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 20px 0;">

        <div>
            <label for="filter_month" style="font-size: 14px; font-weight: bold; margin-right: 5px;">Μήνας:</label>
            <select name="month" id="filter_month" onchange="this.form.submit()" style="padding: 8px 12px; border-radius: 4px; min-width: 160px; font-size: 14px; font-weight: 500;">
                @foreach([
                '01' => 'Ιανουάριος', '02' => 'Φεβρουάριος', '03' => 'Μάρτιος', '04' => 'Απρίλιος',
                '05' => 'Μάιος', '06' => 'Ιούνιος', '07' => 'Ιούλιος', '08' => 'Αύγουστος',
                '09' => 'Σεπτέμβριος', '10' => 'Οκτώβριος', '11' => 'Νοέμβριος', '12' => 'Δεκέμβριος'
                ] as $num => $name)
                <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="filter_year" style="font-size: 14px; font-weight: bold; margin-right: 5px;">Έτος:</label>
            <select name="year" id="filter_year" onchange="this.form.submit()" style="padding: 8px 12px; border-radius: 4px; min-width: 100px; font-size: 14px; font-weight: 500;">
                @foreach($years as $year)
                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <span style="color: #ccc; margin: 0 5px;">|</span>

        <div>
            <label for="filter_category" style="font-size: 14px; font-weight: bold; margin-right: 5px;">Κατηγορία:</label>
            <select name="category_id" id="filter_category" onchange="this.form.submit()" style="padding: 6px; border-radius: 4px;">
                <option value="">Όλες</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="filter_status" style="font-size: 14px; font-weight: bold; margin-right: 5px;">Κατάσταση:</label>
            <select name="status" id="filter_status" onchange="this.form.submit()" style="padding: 6px; border-radius: 4px;">
                <option value="">Όλοι</option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>❌ Απλήρωτοι</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>✅ Πληρωμένοι</option>
            </select>
        </div>

        @if($selectedMonth != date('m') || $selectedYear != date('Y') || request('category_id') || request('status'))
        <div>
            <a href="/bills" style="font-size: 13px; color: #ff5252; text-decoration: none; font-weight: bold;">🔄 Τρέχων Μήνας</a>
        </div>
        @endif

    </form>
    <table>
        <thead>
            <tr>
                <th>Όνομα Υποχρέωσης</th>
                <th>Κατηγορία</th>
                <th>Ποσό (€)</th>
                <th>Ημερ. Πληρωμής</th>
                <th>Ημερ. Λήξης</th>
                <th>Σημειώσεις</th>
                <th>Ενέργειες</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bills as $bill)
            @php
            $rowBg = '';
            $statusText = '';

            if ($bill->paid_at) {
            // 1. Αν έχει πληρωθεί -> Πράσινο
            $rowBg = 'background-color: rgba(40, 167, 69, 0.15);';
            $statusText = '✅ Εξοφλήθηκε';
            } elseif ($bill->expires_at) {

            // Παίρνουμε τις μέρες που απομένουν (αν είναι στο παρελθόν, θα βγει αρνητικό)
            $daysLeft = now()->startOfDay()->diffInDays($bill->expires_at, false);

            if ($daysLeft < 0) {
                // 2. Αν οι μέρες είναι αρνητικές -> Έχει λήξει (Κόκκινο)
                $rowBg = 'background-color: rgba(220, 53, 69, 0.2);';
                $statusText = '🚨 ΕΧΕΙ ΛΗΞΕΙ!';
                } elseif ($daysLeft <= 5) {
                    // 3. Αν λήγει σε 0 έως 5 μέρες -> Κίτρινο
                    $rowBg = 'background-color: rgba(255, 193, 7, 0.25);';
                    $statusText = '⚠️ Λήγει σύντομα (' . $daysLeft . ' μέρες)';
                    } else {
                    // 4. Έχει ακόμα καιρό -> Απαλό Μπλε ή Λευκό/Γκρι (για να ξεχωρίζει από το πράσινο του "Εξοφλήθηκε")
                    $rowBg = 'background-color: rgba(0, 123, 255, 0.08);';
                    $statusText = '⏳ Έχει ακόμα καιρό (' . $daysLeft . ' μέρες)';
                    }
                    }
                    @endphp

                    <tr style="{{ $rowBg }}">
                        <td>
                            <strong>{{ $bill->title }}</strong>
                            @if($statusText)
                            <br><small style="font-style: italic; color: #555;">{{ $statusText }}</small>
                            @endif
                        </td>
                        <td>
                            @if($bill->category)
                            <span style="background-color: {{ $bill->category->color }}; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; white-space: nowrap;">
                                {{ $bill->category->name }}
                            </span>
                            @else
                            <span style="color: #999; font-style: italic; font-size: 13px;">Χωρίς κατηγορία</span>
                            @endif
                        </td>
                        <td>{{ $bill->amount ? $bill->amount . ' €' : '-' }}</td>
                        <td>{{ $bill->paid_at ? $bill->paid_at->format('d/m/Y') : 'Δεν πληρώθηκε' }}</td>
                        <td>{{ $bill->expires_at ? $bill->expires_at->format('d/m/Y') : '-' }}</td>
                        <td>{{ $bill->notes ?? '-' }}</td>
                        <td style="white-space: nowrap; width: 1%;">
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <a href="/bills/{{ $bill->id }}/edit" style="background-color: #f0ad4e; color: white; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 4px;" title="Επεξεργασία">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="/bills/{{ $bill->id }}" method="POST" style="margin: 0;" onsubmit="return confirm('Είσαι σίγουρη;');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background-color: #ff4d4d; color: white; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border: none; border-radius: 4px; cursor: pointer; padding: 0;" title="Διαγραφή">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Δεν υπάρχουν καταχωρημένοι λογαριασμοί ακόμα!</td>
                    </tr>
                    @endforelse
        </tbody>
    </table>

</body>

</html>