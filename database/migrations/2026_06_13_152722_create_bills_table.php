<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Όνομα λογαριασμού (π.χ. ΔΕΗ)
            $table->decimal('amount', 8, 2)->nullable(); // Ποσό (π.χ. 120.50), nullable σημαίνει προαιρετικό
            $table->date('paid_at')->nullable(); // Πότε πληρώθηκε (προαιρετικό αν δεν έχει πληρωθεί ακόμα)
            $table->date('expires_at')->nullable(); // Πότε λήγει / πρέπει να ξαναπληρωθεί
            $table->text('notes')->nullable(); // Σημειώσεις
            $table->timestamps(); // Δημιουργεί αυτόματα στήλες created_at και updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
