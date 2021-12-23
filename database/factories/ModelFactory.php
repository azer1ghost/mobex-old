<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => 'test@' . env('DOMAIN_NAME'),
        'password'       => 'secret',
        'remember_token' => str_random(10),
    ];
});

/*
 * Page
 * */
$factory->define(App\Models\Page::class, function (Faker\Generator $faker) {
    $by = [
        $faker->randomElement(['about', 'terms', 'privacy', 'cookies', 'rules', 'elite']),
        null,
    ];
    $rand = rand(0, 1);

    return [
        'title'         => $faker->sentence(2),
        'type'          => $rand,
        'keyword'       => $by[$rand],
        'content'       => $faker->realText(),
        'author'        => $faker->name,
        'meta_keywords' => implode(",", $faker->words(4)),
        'slug'          => $by[$rand],
        'image'         => $faker->imageUrl(),
        'intro_image'   => $faker->imageUrl(),
    ];
});

/*
 * FAQ
 * */
$factory->define(App\Models\Faq::class, function (Faker\Generator $faker) {
    return [
        'question' => $faker->sentence(2),
        'answer'   => $faker->text(),
    ];
});

/*
 * Package Type
 * */
$factory->define(App\Models\PackageType::class, function (Faker\Generator $faker) {
    return [
        'name'   => $faker->word,
        'weight' => round(1 / rand(1, 4), 1),
        'icon'   => (rand(1, 5)) . '.png',
    ];
});

/*
 * Categories
 * */
$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->sentence(3),
    ];
});

/*
 * Categories
 * */
$factory->define(App\Models\Country::class, function (Faker\Generator $faker) {
    return [
        'code'           => $faker->countryCode,
        'name'           => $faker->country,
        'emails'         => 'info@' . env('DOMAIN_NAME'),
        'delivery_index' => 6000,
    ];
});

/*
 * Warehouses
 * */
$factory->define(App\Models\Warehouse::class, function (Faker\Generator $faker) {
    return [
        'country_id'   => rand(1, 4),
        'company_name' => $faker->company,
        'email'        => $faker->unique()->safeEmail,
        'password'     => 'secret',
        'half_kg'      => 4,
        'per_kg'       => 6.5,
        'up_10_kg'     => 6,
        'key'          => 'SDf3459s@34sfd',
    ];
});

/*
 * Warehouses
 * */
$factory->define(App\Models\Address::class, function (Faker\Generator $faker) {
    return [
        'warehouse_id'   => 1,
        'title'          => $faker->address,
        'contact_name'   => $faker->name,
        'address_line_1' => $faker->secondaryAddress,
        'phone'          => $faker->phoneNumber,
        'city'           => $faker->city,
        'state'          => $faker->citySuffix,
        'region'         => $faker->city,
        'zip_code'       => $faker->postcode,
        'passport'       => $faker->password,
    ];
});

/*
 * Users
 * */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    $cityId = rand(0, 3);
    $districtId = rand(0, 3);

    return [
        'name'        => $faker->firstName,
        'surname'     => $faker->lastName,
        'passport'    => $faker->creditCardNumber,
        'address'     => $faker->address,
        'phone'       => $faker->phoneNumber,
        'customer_id' => \App\Models\User::generateCode(),
        'city_id'     => $cityId ?: null,
        'district_id' => $districtId ?: null,
        'zip_code'    => $faker->postcode,
        'email'       => $faker->unique()->safeEmail,
        'password'    => 'secret',
        'fin'         => uniqid(),
    ];
});

/*
 * Stores
 * */
$factory->define(App\Models\Store::class, function (Faker\Generator $faker) {
    return [
        'url'              => $faker->url,
        'logo'             => $faker->imageUrl(),
        'name'             => $faker->company,
        'country_id'       => rand(1, 4),
        'popularity'       => rand(1, 5),
        'cashback_percent' => rand(1, 100),
        'sale'             => rand(3, 19),
        'description'      => $faker->text,
    ];
});

/*
 * Coupons
 * */
$factory->define(App\Models\Coupon::class, function (Faker\Generator $faker) {
    return [
        'store_id'    => rand(1, 10),
        'url'         => $faker->url,
        'name'        => $faker->sentence(2),
        'description' => $faker->text,
        'code'        => uniqid(),
        'image'       => $faker->imageUrl(),
    ];
});

/*
 * Coupons
 * */
$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'store_id'    => rand(1, 10),
        'url'         => $faker->url,
        'name'        => $faker->sentence(2),
        'description' => $faker->text,
        'old_price'   => '$' . rand(30, 200),
        'sale'        => '5%',
        'price'       => '$' . rand(30, 200),
    ];
});

/*
 * Package
 * */
$factory->define(App\Models\Package::class, function (Faker\Generator $faker) {
    $webSites = [
        'http://amazon.com',
        'ebay.com',
        'tozlu.com',
        'asos.com',
        'alibaba.com',
    ];

    return [
        'user_id'         => rand(1, 10),
        'warehouse_id'    => 1,
        'custom_id'       => uniqid(),
        'weight'          => rand(1, 5),
        'weight_type'     => rand(0, 2),
        'width'           => 50,
        'height'          => 60,
        'length'          => 30,
        'tracking_code'   => uniqid() . 'Ht-' . uniqid(),
        'website_name'    => $webSites[rand(0, 4)],
        'number_items'    => rand(1, 8),
        'shipping_amount' => rand(5, 15),
        'status'          => rand(0, 4),
    ];
});

/*
 * Slider
 * */
$factory->define(App\Models\Slider::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->sentence,
        'title'        => $faker->sentence(4),
        'content'      => $faker->text,
        'button_label' => 'View',
        'url'          => $faker->url,
    ];
});

/*
 * Request
 * */
$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => rand(1, 5),
        'custom_id'   => uniqid(),
        'note'        => $faker->sentence,
        'country_id'  => rand(1, 4),
        'package_id'  => rand(1, 10),
        'price'       => rand(10, 100),
        'service_fee' => rand(10, 100),
        'total_price' => rand(100, 1000),
    ];
});

$factory->define(App\Models\Link::class, function (Faker\Generator $faker) {
    return [
        'url'         => $faker->url,
        'color'       => $faker->colorName,
        'size'        => $faker->randomElement($array = ['XL', 'L', 'M', 'S', 'XS']),
        'price'       => rand(100, 1000),
        'total_price' => rand(100, 1000),
        'cargo_fee'   => rand(10, 100),
        'amount'      => rand(1, 10),
    ];
});

$factory->define(App\Models\Setting::class, function (Faker\Generator $faker) {
    return [
        'address'       => $faker->address,
        'facebook'      => 'https://facebook.com',
        'twitter'       => 'https://twitter.com',
        'email'         => $faker->email,
        'working_hours' => "10:00 - 20:00",
        'phone'         => $faker->phoneNumber,
//        'header_logo' => $faker->imageUrl(),
//        'footer_logo' => $faker->imageUrl(),
        'app_store'     => $faker->url,
        'google_play'   => $faker->url,
        'contact_map'   => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d194472.67477408345!2d49.71487435694184!3d40.39476947032693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4030606eefea1ed1%3A0x41cc40173c5f5edc!2sHeydar%20Aliyev%20International%20Airport!5e0!3m2!1sen!2s!4v1599864221171!5m2!1sen!2s',
    ];
});

/*
 * City
 * */
$factory->define(App\Models\City::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->city,
        'has_delivery' => true,
        'address'      => $faker->sentence(3),
    ];
});

$factory->define(App\Models\District::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->citySuffix,
        'city_id'      => rand(1, 3),
        'has_delivery' => true,
        'delivery_fee' => rand(1, 5),
    ];
});

/*
 * City
 * */
$factory->define(App\Models\Filial::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->city,
        'location' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3039.2363533067546!2d49.82750531539489!3d40.3814539793692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDIyJzUzLjIiTiA0OcKwNDknNDYuOSJF!5e0!3m2!1sen!2str!4v1608689411006!5m2!1sen!2str" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>',
        'address'  => $faker->sentence(3),
    ];
});

$factory->define(App\Models\Service::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->name,
        'image'       => $faker->imageUrl(),
        'description' => $faker->text(40),
    ];
});

$factory->define(App\Models\Transaction::class, function (Faker\Generator $faker) {
    return [
        'admin_id'     => 1,
        'user_id'      => 1,
        'referral_id'  => 1,
        'warehouse_id' => 1,
        'custom_id'    => 1,
        'amount'       => $faker->numberBetween(100, 1000),
    ];
});

