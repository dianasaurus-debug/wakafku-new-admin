<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'id' => 1,
                'name' => 'Sosial',
                'label' => 'sosial',
                'desc' => 'Sosial kemasyaratan',
                'image' => 'sosial.png'
            ],
            [
                'id' => 2,
                'name' => 'Kesehatan',
                'label' => 'kesehatan',
                'desc' => 'Program peningkatan kesehatan masyarakat',
                'image' => 'kesehatan.png'
            ],
            [
                'id' => 3,
                'name' => 'Ekonomi',
                'label' => 'ekonomi',
                'desc' => 'Memberantas angka kemiskinan',
                'image' => 'ekonomi.png'
            ],
            [
                'id' => 4,
                'name' => 'Agama',
                'label' => 'agama',
                'desc' => 'Kepentingan umat beragama',
                'image' => 'agama.png'
            ],
            [
                'id' => 5,
                'name' => 'Edukasi',
                'label' => 'edukasi',
                'desc' => 'Mencerdaskan kehidupan bangsa',
                'image' => 'edukasi.png'
            ],

        ]);
    }
}
