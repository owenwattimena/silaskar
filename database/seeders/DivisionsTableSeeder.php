<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = [
            ["name" => "Superadmin"],

            ["name" => "Admin"],

            ["name" => "Ketua"],
            ["name" => "Wakil Ketua"],
            ["name" => "Hakim"],

            ["name" => "Panitra Pidana"],
            ["name" => "Panitra Perdata"],
            ["name" => "Panitra Tipikor"],
            ["name" => "Panitra Perikanan"],
            ["name" => "Panitra PHI"],
            ["name" => "Panitra PP"],
            ["name" => "Panitra JS/JSP"],

            ["name" => "Kesek-Kasubag Umkeu"],
            ["name" => "Kesek-Kasubag PTIP"],
            ["name" => "Kesek-Kepeg Ortala"]
        ];
        foreach ($divisions as $division) {
            \App\Models\Division::create($division);
        }
        // DB::insert($divisions);
    }
}