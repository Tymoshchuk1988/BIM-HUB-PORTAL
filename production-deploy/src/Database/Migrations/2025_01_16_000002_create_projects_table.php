<?php
declare(strict_types=1);

namespace BIMHub\Database\Migrations;

use BIMHub\Database\Migration;

class CreateProjectsTable extends Migration
{
    public function up(): void
    {
        $this->createTable('projects', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->json('address')->nullable();
            $table->string('status')->default('planning');
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('currency', 3)->default('UAH');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('bim_level')->nullable();
            $table->integer('progress_percentage')->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->foreign('created_by')->references('users', 'id');
            
            $table->index('slug');
            $table->index('status');
            $table->index('created_by');
            $table->index(['status', 'created_at']);
        });
    }
    
    public function down(): void
    {
        $this->dropTable('projects');
    }
}
