<?php

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
        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('username')->unique();
        //     $table->string('mobile')->nullable();
        //     $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Changed from boolean
        //     $table->string('password');
        //     $table->string('avatar')->nullable();
        //     $table->boolean('public_profile')->default(1); // Removed nullable()
        //     $table->boolean('open_profile')->default(0);
        //     $table->boolean('paid_profile')->default(0);
        //     $table->boolean('id_verified')->default(1);
        //     $table->enum('role', ['0', '1', '2'])->default('2'); // Consider using integers instead
        //     $table->enum('status', ['active', 'blocked'])->default('active');
        //     $table->rememberToken();
        //     $table->timestamps();
        // });

        Schema::create('users', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing 'id' column as UNSIGNED BIGINT by default
            $table->unsignedBigInteger('role_id')->constrained('roles')->default(2); // Foreign key for 'role_id' with default value 2
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('mobile')->nullable();
            $table->string('referral_code')->nullable()->unique();
            $table->text('bio')->nullable();
            $table->date('birthdate')->nullable();
            $table->boolean('gender')->default(0);
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->timestamp('identity_verified_at')->nullable();
            $table->string('password')->default('0');
            $table->unsignedBigInteger('gender_id')->nullable()->constrained('user_genders');
            $table->string('gender_pronoun')->nullable();
            $table->boolean('public_profile')->default(1);
            $table->boolean('paid_profile')->default(1);
            $table->double('profile_access_price', 8, 2)->default(5.00);
            $table->double('profile_access_price_6_months', 8, 2)->nullable()->default(5.00);
            $table->double('profile_access_price_3_months', 8, 2)->nullable()->default(5.00);
            $table->double('profile_access_price_12_months', 8, 2)->nullable()->default(5.00);
            $table->string('billing_address')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('block_video_call', 50)->default('0');
            $table->string('block_audio_call', 50)->default('0');
            $table->string('block_message', 50)->default('0');
            $table->longText('fcm_token')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('auth_provider')->nullable();
            $table->string('auth_provider_id')->nullable();
            $table->boolean('enable_2fa')->nullable();
            $table->boolean('enable_geoblocking')->nullable();
            $table->boolean('open_profile')->default(0);
            $table->boolean('enable_blur')->default(0);
            $table->text('settings')->nullable();
            $table->longText('audio_download_list')->nullable();
            $table->enum('artist_verify_status', ['P', 'A', 'R'])->default('P')->comment('A-Approved, R-Rejected, P-Pending');
            $table->enum('accept_term_and_policy', ['0', '1'])->default('0')->comment('0=No,1=Yes');
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('plan_id')->default(0);
            $table->string('purchased_plan_date')->nullable();
            $table->string('dob')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->string('address')->nullable();
            $table->longText('billing_detail')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->constrained();
            $table->unsignedBigInteger('state_id')->nullable()->constrained();
            $table->unsignedBigInteger('city_id')->nullable()->constrained();
            $table->boolean('orole')->default(0);
            $table->string('stripe_id')->nullable();
            $table->enum('stripe_status', ['0', '1'])->default('0');
            $table->string('pincode')->nullable();
            $table->timestamps(0); // for created_at and updated_at (timestamps with precision 0)
            $table->string('redirect_option', 10)->default('0');
            $table->string('otp')->nullable();
            $table->index('role_id');
            $table->index('auth_provider');
            $table->index('auth_provider_id');
            $table->index('gender_id');
            $table->index('birthdate');
            $table->index('location');
            $table->index('enable_2fa');
            $table->index('enable_geoblocking');
            $table->index('open_profile');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
