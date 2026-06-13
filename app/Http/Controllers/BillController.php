<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    // Η συνάρτηση που θα δείχνει τη λίστα με τους λογαριασμούς
    public function index()
    {
        // 1. Παίρνουμε όλους τους λογαριασμούς (όπως πριν)
        $bills = Bill::all();

        // 2. Υπολογίζουμε το σύνολο των ΠΛΗΡΩΜΕΝΩΝ λογαριασμών
        $totalPaid = Bill::whereNotNull('paid_at')->sum('amount');

        // 3. Υπολογίζουμε το σύνολο των ΑΠΛΗΡΩΤΩΝ λογαριασμών
        $totalUnpaid = Bill::whereNull('paid_at')->sum('amount');

        // 4. Μετράμε πόσοι είναι οι ΛΗΓΜΕΝΟΙ (εκπρόθεσμοι) λογαριασμοί
        $expiredCount = Bill::whereNull('paid_at')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now()->startOfDay())
            ->count();

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
        Bill::create($request->all());

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
        // Έλεγχος εγκυρότητας
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'nullable|numeric',
            'paid_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $bill = Bill::findOrFail($id);

        // Ενημέρωση των στοιχείων στη βάση
        $bill->update($request->all());

        return redirect('/bills')->with('success', 'Ο λογαριασμός ανανεώθηκε επιτυχώς!');
    }
}
