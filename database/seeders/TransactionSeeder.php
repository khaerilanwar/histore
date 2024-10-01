<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allProducts = \App\Models\Product::all();
        $cashiers = \App\Models\User::where('role', 2)->get();

        $countTransaction = 45;

        for ($x = 0; $x < $countTransaction; $x++) {

            $soldProducts = [];
            $countSoldProduct = fake()->numberBetween(1, 8);

            // Data untuk tabel transaction_products
            for ($i = 0; $i < $countSoldProduct; $i++) {
                $product = fake()->randomElement($allProducts);
                $quantity = fake()->numberBetween(1, 8);
                $subTotal = $product->price * $quantity;
                $soldProducts[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'subtotal' => $subTotal,
                ];
            }

            // Menjumlahkan total harga pada transaksi produk
            $totalPrice = collect($soldProducts)->sum('subtotal');

            // Mendapatkan waktu sekarang dan membuat id transaksi
            $current = fake()->dateTimeBetween('-1 day', '+1 day');
            $idTransaction = $current->format('m') . $current->format('d') . strtoupper(Str::random(4));

            // if ($x < 3) {
            //     // Data untuk tabel transactions
            //     \App\Models\Transaction::create([
            //         'id' => $idTransaction,
            //         'total_price' => $totalPrice,
            //         'transaction_date' => $current,
            //         'payment_method' => 'cash',
            //         'status' => 'pending',
            //         'pending_time' => $current->modify(
            //             '+' .
            //                 fake()->numberBetween(8, 15) .
            //                 ' minutes'
            //         ),
            //         'user_id' => fake()->randomElement($cashiers)->id,
            //     ]);
            // }
            if ($x < 20) {
                $membersId = Member::pluck('id')->all();
                // Data untuk tabel transactions
                \App\Models\Transaction::create([
                    'id' => $idTransaction,
                    'total_price' => $totalPrice,
                    'transaction_date' => $current,
                    'payment_method' => 'cash',
                    'status' => 'success',
                    'member_id' => fake()->randomElement($membersId),
                    'user_id' => fake()->randomElement($cashiers)->id,
                ]);
            } else {
                // Data untuk tabel transactions
                \App\Models\Transaction::create([
                    'id' => $idTransaction,
                    'total_price' => $totalPrice,
                    'transaction_date' => $current,
                    'payment_method' => 'cash',
                    'status' => 'success',
                    'user_id' => fake()->randomElement($cashiers)->id,
                ]);
            }



            // Menambahkan key id transaksi ke dalam sold product
            foreach ($soldProducts as $soldProduct) {
                $soldProduct['transaction_id'] = $idTransaction;
                DB::table('transaction_products')->insert($soldProduct);
            }
        }
    }
}
