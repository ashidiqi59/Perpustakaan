<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\CheckOverdueLoans;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('loans:check-overdue', function () {
    $this->call('loans:check-overdue');
})->purpose('Check and update overdue loan status');
