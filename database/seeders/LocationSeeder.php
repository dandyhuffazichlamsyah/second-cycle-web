<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'city' => 'Jakarta',
                'name' => 'SecondCycle Kramat 98',
                'type' => 'Diler & Workshop',
                'range_cc' => '110CC - 1000CC',
                'image' => 'images/workshop/kramat98.png',
                'address' => 'Jl. Kramat Raya No. 98, Senen, Jakarta Pusat',
            ],
            [
                'city' => 'Bandung',
                'name' => 'SecondCycle Dago',
                'type' => 'Diler',
                'range_cc' => '110CC - 250CC',
                'image' => 'images/workshop/dago.png',
                'address' => 'Jl. Ir. H. Djuanda No. xx, Dago, Bandung',
            ],
        ];

        foreach ($locations as $loc) {
            Location::create($loc);
        }
    }
}
