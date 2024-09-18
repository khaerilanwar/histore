<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder Tabel Kategori
        $images = array_map(function ($i) {
            return "category$i.jpg";
        }, range(0, 9));

        $categories = ['Food' => "Nikmati Kelezatan, Setiap Suapnya!", 'Beverage' => "Segarkan Harimu, Satu Teguk Penuh Rasa!", 'Kitchen' => "Alat Dapur Terbaik, Untuk Masakan Terlezat!", 'Style' => "Gaya Kekinian, Tampil Percaya Diri!", 'School' => "Perlengkapan Belajar, Teman Setia di Kelas!", 'Camping' => "Petualangan Nyaman, Alam Semakin Dekat!", 'Travel' => "Perjalanan Seru, Siap Jelajahi Dunia!", 'Sport' => "Bertenaga Maksimal, Raih Prestasi!", 'Electronic' => "Teknologi Canggih, Hidup Lebih Mudah!", 'Others' => "Produk Lainnya, Lengkap dan Terpercaya!"];

        foreach ($categories as $category => $slogan) {
            \App\Models\Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'slogan' => $slogan,
                'image' => fake()->randomElement($images),
            ]);
        }
    }
}
