<?php

namespace App\Console\Commands;

use App\Http\Controllers\exportController;
use Illuminate\Console\Command;

class your_fetch_leads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'your:fetch-leadsqqq';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches and stores lead data for the past year';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $controller = new exportController();
        $controller->fetchAndStoreLeadsForPastYear();
        $this->info('Lead data fetching and storage completed successfully.');
        return 0;
    }
}
