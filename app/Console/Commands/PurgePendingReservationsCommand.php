<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\ReservationService;

class PurgePendingReservationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:purge {--start=-10 minutes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge pending reservations.';

    /**
     * Execute the console command.
     */
    public function handle(ReservationService $service)
    {
        $purged = $service->purgePending(Carbon::parse($this->option('start'))->toImmutable());

        $this->components->info(sprintf('%s reservations purged.', $purged));
    }
}
