<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Setting::setMany([
            'default_locale' => 'ar',
            'default_timezone' => 'Africa/Cairo',
            'reviews_enabled' => true,
            'auto_approve_reviews' => true,
            'supported_currencies' => ['USD','LE','SAR'],
            'default_currency' => 'USD',
            'store_email' => 'admin@ecommerce.test',
            'search_engine' => 'mysql',
            'local_shipping_cost'=> 0,
            'outer_shipping_cost'=>0,
            'free_shipping_cost'=>0,
            'translatable' => [
                'store_name' => 'متجر البدر',
                'free_shipping_label' => 'توصيل مجانى',
                'local_shipping_label' => 'توصيل داخلى',
                'outer_shipping_label' => 'توصيل خارجى'
            ]
        ]);
    }
}
