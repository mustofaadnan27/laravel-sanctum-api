<?php

use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable(false);
            $table->string("price")->nullable(false);
            $table->string("description")->nullable(false);
            $table->timestamps();
        });

        $faker = Factory::create();
        for ($i=0; $i < 10; $i++) { 
            Product::create([
                'name' => $faker->word,
                'price' => $faker->randomNumber(5, true),
                'description' => $faker->sentence(5, true)
            ]);
        }
    }

  
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
