<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->text('content');
            $table->boolean('status')->default(0);
            $table->timestamp('scheduled_at')->nullable();
            $table->unsignedInteger('total_recipients')->default(0);
            $table->unsignedInteger('delivered')->default(0);
            $table->unsignedInteger('opens')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->unsignedInteger('unsubscribes')->default(0);
            $table->unsignedInteger('bounces')->default(0);
            $table->unsignedInteger('complaints')->default(0);
            $table->string('from_name');
            $table->string('from_email');
            $table->string('type')->nullable();
            $table->foreignId('list_id')->constrained('email_lists')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
