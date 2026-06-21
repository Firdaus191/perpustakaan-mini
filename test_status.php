<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$userTino = \App\Models\User::find(2);
$userKurnia = \App\Models\User::find(6);

echo "Tino (ID 2):\n";
print_r($userTino->cekStatusSanksi());

echo "Kurnia (ID 6):\n";
print_r($userKurnia->cekStatusSanksi());
