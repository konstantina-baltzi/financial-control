<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // 1. READ: Εμφάνιση λίστας κατηγοριών και της φόρμας δημιουργίας
    public function index()
    {
        $categories = Auth::user()->categories;
        return view('categories.index', compact('categories'));
    }

    // 2. CREATE: Αποθήκευση νέας κατηγορίας
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        Auth::user()->categories()->create($request->all());

        return redirect('/categories')->with('success', 'Η κατηγορία προστέθηκε!');
    }

    // 3. EDIT: Εμφάνιση φόρμας επεξεργασίας
    public function edit($id)
    {
        $category = Auth::user()->categories()->findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // 4. UPDATE: Αποθήκευση αλλαγών κατηγορίας
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $category = Auth::user()->categories()->findOrFail($id);
        $category->update($request->all());

        return redirect('/categories')->with('success', 'Η κατηγορία ενημερώθηκε!');
    }

    // 5. DELETE: Διαγραφή κατηγορίας
    public function destroy($id)
    {
        $category = Auth::user()->categories()->findOrFail($id);
        $category->delete();

        return redirect('/categories')->with('success', 'Η κατηγορία διαγράφηκε!');
    }
}
