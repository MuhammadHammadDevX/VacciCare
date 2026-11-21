<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital;
use App\Models\HospitalVaccine;

class FeaturesDataSeeder extends Seeder
{
    public function run(): void
    {
        $coords = [
            ['lat' => 24.8924, 'lng' => 67.0739], // Aga Khan, Karachi
            ['lat' => 24.8938, 'lng' => 67.0699], // Liaquat, Karachi
            ['lat' => 31.4820, 'lng' => 74.2693], // Shaukat Khanum, Lahore
            ['lat' => 33.7083, 'lng' => 73.0558], // PIMS, Islamabad
            ['lat' => 24.9392, 'lng' => 67.1147], // Dow, Karachi
            ['lat' => 31.4641, 'lng' => 74.3496], // General Hospital, Lahore
        ];

        $hospitals = Hospital::all();
        foreach ($hospitals as $idx => $hospital) {
            $c = $coords[$idx % count($coords)];
            $hospital->latitude = $c['lat'];
            $hospital->longitude = $c['lng'];
            $hospital->save();
        }

        $vaccines = HospitalVaccine::all();
        foreach ($vaccines as $idx => $vaccine) {
            $vaccine->stock_quantity = 35 + ($idx * 7) % 50;
            $vaccine->batch_number = 'BATCH-' . strtoupper(substr(md5($vaccine->vaccine_name . $vaccine->hospital_id), 0, 6));
            $vaccine->expiry_date = now()->addMonths(6 + ($idx % 12))->format('Y-m-d');
            $vaccine->low_stock_threshold = 10;
            $vaccine->save();
        }
    }
}
