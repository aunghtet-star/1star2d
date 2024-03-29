<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoCloseTwodTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:closetime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        DB::table('show_hides')->where('name','twoform')->update([
            'status' => 'hide'
        ]);

        DB::table('show_hides')->where('name','htaitpaitform')->update([
            'status' => 'hide'
        ]);

        \Log::info("Cron is working fine!");
    }
}
