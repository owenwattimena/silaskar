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

            ["name" => "Panitera"],
            ["name" => "Sekertaris"],
            ["name" => "Js/Jsp"],

            ["name" => "Panitera Pengganti"],

            ["name" => "Kasubag Umkeu"],
            ["name" => "Kasubag PTIP"],
            ["name" => "Kasubag Ortala"],

            ["name" => "Panitera Perdata"],
            ["name" => "Panitera Tipikor"],
            ["name" => "Panitera Hukum"],
            ["name" => "Panitera Pidana"],
            ["name" => "Panitera PHI"],
            ["name" => "Panitera Perikanan"]

        ];
        foreach ($divisions as $division) {
            \App\Models\Division::create($division);
        }
        // DB::insert($divisions);
    }
}