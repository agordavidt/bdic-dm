<?php

namespace Database\Seeders;

use App\Models\DeviceCategory;
use Illuminate\Database\Seeder;

class DeviceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tablets', 'description' => 'Tablet devices and accessories'],
            ['name' => 'Smartphones', 'description' => 'Mobile phones and accessories'],
            ['name' => 'Laptops', 'description' => 'Laptop computers and accessories'],
            ['name' => 'Desktops', 'description' => 'Desktop computers and accessories'],
            ['name' => 'Accessories', 'description' => 'Device accessories and peripherals'],
            ['name' => 'Networking', 'description' => 'Network equipment and devices'],
            ['name' => 'Storage', 'description' => 'Data storage devices'],
            ['name' => 'Audio/Video', 'description' => 'Audio and video equipment'],
        ];

        foreach ($categories as $category) {
            DeviceCategory::create($category);
        }
    }
}