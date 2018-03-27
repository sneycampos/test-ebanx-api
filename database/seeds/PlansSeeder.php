<?php

use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<10;$i++)
        {
            \App\Models\Plan::create([
                'name' => 'Plan ' . $i,
                'price' => rand(1,10) . .00,
            ]);
        }
    }
}
