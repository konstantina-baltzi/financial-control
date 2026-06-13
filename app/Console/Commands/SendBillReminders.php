<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Mail\BillReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendBillReminders extends Command
{
    /**
     * Το όνομα της εντολής που θα πληκτρολογούμε στο terminal.
     */
    protected $signature = 'bills:send-reminders';

    /**
     * Η περιγραφή της εντολής.
     */
    protected $description = 'Στέλνει email υπενθύμισης για λογαριασμούς που λήγουν σε 3 ημέρες';

    /**
     * Εδώ γράφουμε τη λογική που εκτελείται όταν τρέχει η εντολή.
     */
    public function handle()
    {
        // 1. Βρίσκουμε την ημερομηνία που θα είναι σε ακριβώς 3 ημέρες από σήμερα
        $targetDate = Carbon::now()->addDays(3)->toDateString();

        // 2. Ψάχνουμε στη βάση για λογαριασμούς που:
        //    - Δεν έχουν πληρωθεί (paid_at IS NULL)
        //    - Λήγουν σε ακριβώς 3 ημέρες (expires_at == $targetDate)
        $bills = Bill::with('user')
            ->whereNull('paid_at')
            ->whereDate('expires_at', $targetDate)
            ->get();

        if ($bills->isEmpty()) {
            $this->info('Δεν βρέθηκαν λογαριασμοί που λήγουν σε 3 ημέρες.');
            return Command::SUCCESS;
        }

        $count = 0;

        // 3. Στέλνουμε email ξεχωριστά για κάθε λογαριασμό στον ιδιοκτήτη του
        foreach ($bills as $bill) {
            // Σιγουρευόμαστε ότι ο λογαριασμός έχει συνδεδεμένο χρήστη και email
            if ($bill->user && $bill->user->email) {
                Mail::to($bill->user->email)->send(new BillReminderMail($bill));
                $count++;
                $this->info("Στάλθηκε υπενθύμιση στον χρήστη: {$bill->user->email} για τον λογαριασμό: '{$bill->title}'");
            }
        }

        $this->info("Η διαδικασία ολοκληρώθηκε! Στάλθηκαν συνολικά {$count} emails.");
        return Command::SUCCESS;
    }
}
