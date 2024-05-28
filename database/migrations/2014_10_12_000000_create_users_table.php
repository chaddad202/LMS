<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function GuzzleHttp\default_ca_bundle;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
          //  $table->text('roles_name')->nullable();
            $table->rememberToken();
            $table->timestamps();

        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //    // $table->string('roles_name');
        //     $table->string('photo')->nullable()->default('1');
        //     $table->string('age')->nullable()->default('1');
        //     $table->float('wallet')->nullable()->default('1');
        //     $table->unsignedBigInteger('company_id')->nullable()->default('1');
        //     $table->unsignedBigInteger('role_id')->default('8');
        //     $table->foreign('company_id')->references('id') ->on('companies')->onDelete('cascade');
        //     $table->foreign('role_id')->references('id') ->on('roles')->onDelete('cascade');
        //     $table->rememberToken();
        //     $table->timestamps();
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
