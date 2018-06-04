<?php

namespace App\Console\Commands;

use App\Console\Commands\Traits\Logger;
use App\Models\Transaction;
use Illuminate\Console\Command;

class SaveYesterdayTransactionsSum extends Command
{
    use Logger;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:sum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stores the sum of all transactions from previous day.';

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
     * @return mixed
     */
    public function handle()
    {
        $sum = Transaction::getYesterdayAmountSum();

        $this->logInfo('Yesterday transactions sum: ' . $sum);
    }
}
