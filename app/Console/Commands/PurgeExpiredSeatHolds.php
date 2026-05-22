<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PurgeExpiredSeatHolds extends Command
{
    protected $signature = 'eventflow:purge-expired-seat-holds';

    protected $description = 'Delete expired seat holds';

    public function handle(): int
    {
        $deleted = DB::table('seat_holds')
            ->where('expires_at', '<=', now())
            ->delete();

        $this->info("Deleted {$deleted} expired seat holds.");

        return self::SUCCESS;
    }
}
