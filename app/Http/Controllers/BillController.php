<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    // Η συνάρτηση που θα δείχνει τη λίστα με τους λογαριασμούς
    public function index()
    {
        // Παίρνουμε όλους τους λογαριασμούς από τη βάση δεδομένων
        $bills = Bill::all();

        // Στέλνουμε τους λογαριασμούς στο view που λέγεται "bills.index"
        return view('bills.index', compact('bills'));
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
}
