<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    // Η συνάρτηση που θα δείχνει τη λίστα με τους λογαριασμούς
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Τώρα τραβάμε τα δεδομένα χωρίς κανένα σφάλμα
        $bills = $user->bills;
        $totalPaid = $user->bills()->whereNotNull('paid_at')->sum('amount');
        $totalUnpaid = $user->bills()->whereNull('paid_at')->sum('amount');
        $expiredCount = $user->bills()->whereNull('paid_at')->whereNotNull('expires_at')->where('expires_at', '<', now()->startOfDay())->count();

        // Στέλνουμε όλα τα δεδομένα στο view
        return view('bills.index', compact('bills', 'totalPaid', 'totalUnpaid', 'expiredCount'));
    }
    // 1. Δείχνει τη σελίδα με τη φόρμα
    public function create()
    {
        return view('bills.create');
    }

    // 2. Παίρνει τα δεδομένα της φόρμας και τα αποθηκεύει στη βάση
    public function store(Request $request)
    {
        // Κάνουμε validation (έλεγχο) για να σιγουρευτούμε ότι ο τίτλος είναι υποχρεωτικός
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
            'paid_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'notes' => 'nullable|string',
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
        $bill = Bill::findOrFail($id); // Βρίσκουμε τον λογαριασμό ή πετάει 404 αν δεν υπάρχει
        return view('bills.edit', compact('bill'));
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
