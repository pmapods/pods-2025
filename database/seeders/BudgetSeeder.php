<?php

namespace Database\Seeders;
use Faker\Factory as Faker;

use Illuminate\Database\Seeder;
use App\Models\BudgetPricingCategory;
use App\Models\BudgetPricing;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_list = ["Office Equipment","Fixture and Furniture","Warehouse Equipment","Computer", "Others"];
        $category_code = ["EO","FF","WE","TC","OT"];
        foreach($category_list as $key=>$list){
            $newCategory = new BudgetPricingCategory;
            $newCategory->name = $list;
            $newCategory->code = $category_code[$key];
            $newCategory->save();
        }

        $faker = Faker::create('id_ID');
        for($i = 0; $i <100; $i++){
            $newBudget                             = new BudgetPricing;
            $selected_category                     = BudgetPricingCategory::inRandomOrder()->first();
            $newBudget->budget_pricing_category_id = $selected_category->id;
            $newBudget->code                       = $selected_category->code.'-'.($selected_category->budget_pricing->count()+1);
            $newBudget->name                       = $selected_category->name.$i;
            $newBudget->brand                      = 'brand1 / brand2';
            $newBudget->type                       = 'type1 / type2 / etc';
            $min_price = $faker->numberBetween(1000000, 3000000);
            $rand = array_rand([0,1],1);
            $newBudget->injs_min_price             = ($rand==0)? null : $min_price;
            $newBudget->injs_max_price             = $faker->numberBetween(4000000, 5000000);
            $newBudget->outjs_min_price            = ($rand==0)? null : $min_price;
            $newBudget->outjs_max_price            = $faker->numberBetween(4000000, 5000000);
            $newBudget->save();
        }
    }
}
