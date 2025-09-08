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
        Schema::table('users', function (Blueprint $table) {
            // profile_picture, address, phone, city, country, pincode, status
            $table->string('profile_picture')->nullable()->after('password');
            $table->text('address')->nullable()->after('profile_picture');
            $table->string('phone')->nullable()->after('address');
            $table->string('city')->nullable()->after('phone');
            $table->string('country')->nullable()->after('city');
            $table->string('pincode')->nullable()->after('country');
            $table->integer('status')->default(0)->after('pincode')->comment('1=active,0=inactive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn([
                'profile_picture',
                'address',
                'phone',
                'city',
                'country',
                'pincode',
                'status'
            ]);
        });
    }
};
