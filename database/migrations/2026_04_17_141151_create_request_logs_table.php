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
        Schema::create('request_logs', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

             $table->string('method');
              $table->text('url');

            $table->integer('status_code');
             $table->string('ip_address')->nullable();

               $table->float('duration'); // بالثواني أو ms

            $table->timestamps();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_logs');
    }
};
