<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #333333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            margin: 0 auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-top: 5px solid #3b82f6;
            /* Μπλε γραμμή στην κορυφή */
        }

        .header {
            background-color: #eff6ff;
            padding: 25px;
            text-align: center;
        }

        .body {
            padding: 30px;
            line-height: 1.6;
        }

        .bill-details {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }

        .bill-row {
            margin-bottom: 10px;
            font-size: 15px;
        }

        .label {
            font-weight: bold;
            color: #475569;
        }

        .btn {
            display: inline-block;
            background-color: #3b82f6;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 15px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #94a3b8;
            background-color: #f8fafc;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2 style="margin: 0; color: #1e3a8a;">Financial Control 📊</h2>
        </div>

        <div class="body">
            <p>Καλημέρα <strong>{{ $bill->user->name }}</strong>,</p>
            <p>Σου στέλνουμε αυτή την υπενθύμιση γιατί ένας καταχωρημένος λογαριασμός σου πρόκειται να λήξει σύντομα και εκκρεμεί η πληρωμή του.</p>

            <div class="bill-details">
                <div class="bill-row"><span class="label">Υποχρέωση:</span> {{ $bill->title }}</div>
                <div class="bill-row"><span class="label">Ποσό:</span> {{ number_format($amount ?? $bill->amount, 2, ',', '.') }} €</div>
                <div class="bill-row"><span class="label">Ημερομηνία Λήξης:</span> {{ \Carbon\Carbon::parse($bill->expires_at)->format('d/m/Y') }}</div>

                @if($bill->category)
                <div class="bill-row">
                    <span class="label">Κατηγορία:</span>
                    <span style="background: {{ $bill->category->color }}; color: white; padding: 2px 6px; border-radius: 4px; font-size: 13px;">
                        {{ $bill->category->name }}
                    </span>
                </div>
                @endif
            </div>

            <p style="text-align: center;">
                <a href="{{ url('/bills') }}" class="btn">Προβολή Λογαριασμών</a>
            </p>
        </div>

        <div class="footer">
            Αυτό είναι ένα αυτοματοποιημένο μήνυμα από την εφαρμογή Financial Control.<br>
            &copy; {{ date('Y') }} Financial Control. All rights reserved.
        </div>
    </div>

</body>

</html>