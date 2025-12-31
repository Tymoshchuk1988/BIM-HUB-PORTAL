<?php
declare(strict_types=1);

namespace BIMHub\Database\Migrations;

use BIMHub\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        $this->createTable('users', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->string('full_name')->nullable();
            $table->string('role')->default('viewer');
            $table->string('status')->default('active');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            
            $table->index('email');
            $table->index('status');
            $table->index('role');
        });
    }
    
    public function down(): void
    {
        $this->dropTable('users');
    }
}
