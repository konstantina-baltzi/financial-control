<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Bill;
use Illuminate\Http\Request;
use App\Models\Category;

class BillController extends Controller
{
    // Η συνάρτηση που θα δείχνει τη λίστα με τους λογαριασμούς
    public function index(\Illuminate\Http\Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Καθορισμός Μήνα και Έτους (Default: Ο τρέχων μήνας και έτος)
        $selectedMonth = $request->input('month', date('m'));
        $selectedYear = $request->input('year', date('Y'));

        // 2. Δημιουργία του βασικού Query για τον συγκεκριμένο Μήνα και Έτος
        // Φιλτράρουμε με βάση την ημερομηνία λήξης (expires_at)
        $baseQuery = $user->bills()
            ->whereYear('expires_at', $selectedYear)
            ->whereMonth('expires_at', $selectedMonth);

        // 3. Υπολογισμός Στατιστικών ΜΟΝΟ για τον επιλεγμένο μήνα/έτος
        $totalPaid = (clone $baseQuery)->whereNotNull('paid_at')->sum('amount');
        $totalUnpaid = (clone $baseQuery)->whereNull('paid_at')->sum('amount');
        $expiredCount = (clone $baseQuery)->whereNull('paid_at')->where('expires_at', '<', now()->startOfDay())->count();

        // 4. Εφαρμογή των έξτρα φίλτρων στον πίνακα (Κατηγορία & Κατάσταση)
        $tableQuery = clone $baseQuery;

        if ($request->has('category_id') && $request->category_id != '') {
            $tableQuery->where('category_id', $request->category_id);
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'paid') {
                $tableQuery->whereNotNull('paid_at');
            } elseif ($request->status == 'unpaid') {
                $tableQuery->whereNull('paid_at');
            }
        }

        // Παίρνουμε τους τελικούς λογαριασμούς για τον πίνακα
        $bills = $tableQuery->orderBy('expires_at', 'asc')->get();

        // Παίρνουμε τις κατηγορίες του χρήστη για το dropdown
        $categories = $user->categories;

        // Φτιάχνουμε μια λίστα με τα τελευταία 5 χρόνια για το φίλτρο του έτους
        $years = range(date('Y'), date('Y') - 4);

        // Στέλνουμε όλα τα δεδομένα στο view, μαζί με τις επιλογές του χρήστη
        return view('bills.index', compact(
            'bills',
            'totalPaid',
            'totalUnpaid',
            'expiredCount',
            'categories',
            'selectedMonth',
            'selectedYear',
            'years'
        ));
    }
    // 1. Δείχνει τη σελίδα με τη φόρμα
    public function create()
    {
        $categories = auth()->user()->categories; // Παίρνουμε τις κατηγορίες του χρήστη
        return view('bills.create', compact('categories'));
    }

    // 2. Παίρνει τα δεδομένα της φόρμας και τα αποθηκεύει στη βάση
    public function store(Request $request)
    {
        // Κάνουμε validation (έλεγχο) για να σιγουρευτούμε ότι ο τίτλος είναι υποχρεωτικός
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
            'expires_at' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id', // Έλεγχος αν η κατηγορία υπάρχει στη βάση
            'notes' => 'nullable|string',
            'frequency' => 'required|string',
        ]);

        // Αποθήκευση στη βάση δεδομένων με βάση το $fillable που ορίσαμε στο Model
        $data = $request->all();
        $data['user_id'] = Auth::id();

        Bill::create($data);

        // Μόλις αποθηκευτεί, ανακατευθύνουμε τον χρήστη πίσω στη λίστα με ένα μήνυμα επιτυχίας
        return redirect('/bills')->with('success', 'Ο λογαριασμός προστέθηκε επιτυχώς!');
    }

    // Διαγραφή λογαριασμού
    public function destroy($id)
    {
        // Βρίσκουμε τον λογαριασμό με βάση το ID του
        $bill = Bill::findOrFail($id);

        // Τον διαγράφουμε από τη βάση
        $bill->delete();

        // Γυρνάμε πίσω με μήνυμα επιτυχίας
        return redirect('/bills')->with('success', 'Ο λογαριασμός διαγράφηκε επιτυχώς!');
    }

    // 1. Εμφάνιση της φόρμας επεξεργασίας για έναν συγκεκριμένο λογαριασμό
    public function edit($id)
    {
        $bill = Bill::findOrFail($id);
        $categories = auth()->user()->categories; // Παίρνουμε τις κατηγορίες
        return view('bills.edit', compact('bill', 'categories'));
    }
    // 2. Αποθήκευση των αλλαγών (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
            'paid_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'frequency' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $bill = Bill::findOrFail($id);

        // Κρατάμε την παλιά κατάσταση πληρωμής για να δούμε αν άλλαξε ΤΩΡΑ σε πληρωμένο
        $wasPaid = !is_null($bill->paid_at);
        $isPaidNow = !is_null($request->paid_at);

        // Ενημερώνουμε τον τρέχοντα λογαριασμό
        $bill->update($request->all());

        // ΑΝ ο λογαριασμός δεν ήταν πληρωμένος, αλλά πληρώθηκε ΤΩΡΑ, και είναι επαναλαμβανόμενος:
        if (!$wasPaid && $isPaidNow && $bill->frequency !== 'none') {

            // Υπολογίζουμε τη νέα ημερομηνία λήξης για τον επόμενο λογαριασμό
            $newExpiresAt = $bill->expires_at;
            if ($newExpiresAt) {
                if ($bill->frequency === 'monthly') {
                    $newExpiresAt = $bill->expires_at->addMonth();
                } elseif ($bill->frequency === 'yearly') {
                    $newExpiresAt = $bill->expires_at->addYear();
                }
            }

            // Δημιουργούμε τον επόμενο λογαριασμό (αντίγραφο) στη βάση, αλλά ΑΠΛΗΡΩΤΟ
            Bill::create([
                'user_id' => $bill->user_id,
                'title' => $bill->title,
                'amount' => $bill->amount,
                'paid_at' => null, // Ο νέος είναι απλήρωτος
                'expires_at' => $newExpiresAt,
                'frequency' => $bill->frequency,
                'notes' => $bill->notes,
            ]);
        }

        return redirect('/bills')->with('success', 'Ο λογαριασμός ενημερώθηκε επιτυχώς!');
    }
}
