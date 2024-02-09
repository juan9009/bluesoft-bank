<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('client_uuid')->constrained('clients', 'uuid')->onDelete('cascade');
            $table->string('account_number')->unique();
            $table->enum('type', ['savings', 'current']);
            $table->decimal('balance', 8, 2)->default(0);
            $table->string('city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
