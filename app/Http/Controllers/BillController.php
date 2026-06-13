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
}
