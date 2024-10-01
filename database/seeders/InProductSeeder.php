<?php

namespace Database\Seeders;

use App\Models\InProduct;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all()->pluck('id');
        $notifs = Notification::where('status', 'private')->get();

        foreach ($notifs as $notif) {
            $h = 0;
            if ($h > count($notifs) - 2) {
                for ($i = 0; $i < fake()->numberBetween(5, 12); $i++) {
                    InProduct::create(
                        [
                            'product_id' => fake()->randomElement($products),
                            'stock_in' => fake()->numberBetween(4, 22),
                            'date_confirm' => fake()->dateTimeBetween('-1 day', '+3 day'),
                            'notif_id' => $notif->id
                        ]
                    );
                }
            } else {
                for ($i = 0; $i < fake()->numberBetween(5, 12); $i++) {
                    InProduct::create(
                        [
                            'product_id' => fake()->randomElement($products),
                            'stock_in' => fake()->numberBetween(4, 22),
                            'notif_id' => $notif->id
                        ]
                    );
                }
            }
        }
    }
}
