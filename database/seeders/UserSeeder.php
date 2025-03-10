<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initialize Faker
        $faker = Faker::create();

        // Insert 10 dummy users
        for ($i = 0; $i < 26; $i++) {
            DB::table('users')->insert([
                'role_id' => 2,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'username' => $faker->userName,
                'mobile' => $faker->phoneNumber,
                'referral_code' => $faker->uuid,
                'bio' => $faker->text(200),
                'birthdate' => $faker->date(),
                'gender' => $faker->randomElement([0, 1]),
                'location' => $faker->city,
                'website' => $faker->url,
                'avatar' => $faker->imageUrl(),
                'cover' => $faker->imageUrl(),
                'identity_verified_at' => $faker->optional()->dateTimeThisYear(),
                'password' => bcrypt('password'), // default password for testing
                'gender_id' => $faker->randomElement([1, 2, 3]), // Assuming these IDs exist in the 'user_genders' table
                'gender_pronoun' => $faker->randomElement(['He', 'She', 'They']),
                'public_profile' => 1,
                'paid_profile' => 1,
                'profile_access_price' => 5.00,
                'profile_access_price_6_months' => 5.00,
                'profile_access_price_3_months' => 5.00,
                'profile_access_price_12_months' => 5.00,
                'billing_address' => $faker->address,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'city' => $faker->city,
                'country' => $faker->country,
                'state' => $faker->state,
                'postcode' => $faker->postcode,
                'block_video_call' => '0',
                'block_audio_call' => '0',
                'block_message' => '0',
                'fcm_token' => $faker->uuid,
                'remember_token' => Str::random(10),
                'auth_provider' => 'google',
                'auth_provider_id' => $faker->uuid,
                'enable_2fa' => $faker->boolean,
                'enable_geoblocking' => $faker->boolean,
                'open_profile' => 0,
                'enable_blur' => 0,
                'settings' => $faker->text(200),
                'audio_download_list' => $faker->text(200),
                'artist_verify_status' => $faker->randomElement(['P', 'A', 'R']),
                'accept_term_and_policy' => '1',
                'email_verified_at' => $faker->optional()->dateTimeThisYear(),
                'plan_id' => 0,
                'purchased_plan_date' => $faker->optional()->date(),
                'dob' => $faker->date(),
                'image' => $faker->imageUrl(),
                'status' => 1,
                'address' => $faker->address,
                'billing_detail' => $faker->text(200),
                'country_id' => $faker->randomNumber(),
                'state_id' => $faker->randomNumber(),
                'city_id' => $faker->randomNumber(),
                'orole' => 0,
                'stripe_id' => $faker->uuid,
                'stripe_status' => '0',
                'pincode' => $faker->postcode,
                'redirect_option' => '0',
                'otp' => $faker->randomNumber(6),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
