<?php

namespace App\Http\Controllers\Auth;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $defaultCategories = [
            ['name' => '🏠 Σπίτι (Ενοίκιο, Λογαριασμοί)', 'color' => '#007bff'],
            ['name' => '🚗 Αυτοκίνητο (Ασφάλεια, ΚΤΕΟ, Σέρβις)', 'color' => '#ffc107'],
            ['name' => '🛒 Supermarket & Αγορές', 'color' => '#28a745'],
            ['name' => '📺 Συνδρομές (Netflix, Spotify)', 'color' => '#dc3545'],
            ['name' => '💼 Επαγγελματικά / Δουλειά', 'color' => '#6c757d']
        ];

        foreach ($defaultCategories as $category) {
            Category::create([
                'user_id' => $user->id,
                'name' => $category['name'],
                'color' => $category['color'],
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect('/bills');
    }
}
