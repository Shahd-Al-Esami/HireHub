<?php

use App\Enums\AvailabilityStatusEnum;
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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('bio')->nullable();

            $table->decimal('hourly_rate',10,4)->nullable();
            $table->string('image')->nullable();
            $table->string('phone_number')->nullable();
            $table->json('portfolio_links')->nullable();
            $table->json('skills_summary')->nullable();

            $table->enum('availability_status',AvailabilityStatusEnum::getValues());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
