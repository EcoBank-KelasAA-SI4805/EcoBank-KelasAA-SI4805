<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('ecobank:about', function () {
    $this->comment('EcoBank UI - F-01 dan F-10');
})->purpose('Display EcoBank project information');
