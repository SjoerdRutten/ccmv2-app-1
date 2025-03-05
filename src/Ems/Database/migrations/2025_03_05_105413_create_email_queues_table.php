<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_queues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_id')->constrained('emails')->cascadeOnDelete();
            $table->foreignId('crm_card_id')->constrained('crm_cards')->cascadeOnDelete();
            $table->foreignId('mail_server_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('start_sending_at')->nullable();
            $table->string('to_name')->nullable();
            $table->string('to_email');
            $table->string('from_name')->nullable();
            $table->string('from_email');
            $table->string('reply_to')->nullable();
            $table->string('subject');
            $table->longText('html_content');
            $table->longText('text_content');
            $table->string('domain');
            $table->string('message_id')->nullable();
            $table->dateTime('queued_at')->nullable();
            $table->dateTime('send_at')->nullable();
            $table->dateTime('error_at')->nullable();
            $table->boolean('bounce')->default(false);
            $table->dateTime('bounced_at')->nullable();
            $table->boolean('abuse')->default(false);
            $table->dateTime('abused_at')->nullable();
            $table->timestamps();

            $table->index('message_id');
        });
    }
};
