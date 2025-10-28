<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cashier_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('type'); // collection | disbursement | sale | purchase | other
            $table->decimal('amount', 12, 2);
            $table->boolean('is_inflow'); // true for IN, false for OUT
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cashier_transactions');
    }
};
