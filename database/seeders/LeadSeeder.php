<?php

use App\Domain\Models\Lead;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run()
    {
        Lead::factory()->count(10)->create();
    }
}
