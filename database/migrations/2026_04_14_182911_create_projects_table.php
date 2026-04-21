<?php

use App\Enums\BudgetTypeEnum;
use App\Enums\ProjectStatus;
use App\Enums\ProjectStatusEnum;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();

            $table->string('title');
            $table->text('description');

            $table->decimal('budget_amount',10,2);

            $table->date('delivery_date');

            $table->enum('budget_type',BudgetTypeEnum::getValues());



            $table->enum('status',ProjectStatusEnum::getValues())->default(ProjectStatusEnum::OPEN->value);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
