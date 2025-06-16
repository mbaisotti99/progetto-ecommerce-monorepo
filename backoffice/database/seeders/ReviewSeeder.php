<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $prods = Product::all();

        foreach ($prods as $prod){
            for ($i = 0; $i < rand(3, 10); $i++){
                $newRev = new Review();
                $newRev->utente = $faker->name();
                $newRev->voto = rand(1, 5);
                $newRev->testo = implode(" ", $faker->paragraphs(rand(1, 4)));
                $newRev->data = $faker->dateTimeThisDecade();
                $newRev->product_id = $prod->id;

                $newRev->save();
            }
        }
    }
}
