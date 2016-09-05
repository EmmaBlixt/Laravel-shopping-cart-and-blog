<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $product = new Product;
        $product->name = "Pineapple";
        $product->description = "Healthy and tasty fruit";
        $product->price = 40;
        $product->image = "pineapple.png";
        $product->save();

        $product = new Product;
        $product->name = "Strawberry";
        $product->description = "Small and tasty fruit";
        $product->price = 20;
        $product->image = "strawberry.jpg";
        $product->save();

        $product = new Product;
        $product->name = "Bird";
        $product->description = "Likes to sing";
        $product->price = 45;
        $product->image = "bird.jpg";
        $product->save();

        $product = new Product;
        $product->name = "Kitten";
        $product->description = "Tiny but deadly";
        $product->price = 20;
        $product->image = "kitten.jpg";
        $product->save();
    }
}
