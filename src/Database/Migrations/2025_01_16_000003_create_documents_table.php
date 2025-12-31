<?php
declare(strict_types=1);

namespace BIMHub\Database\Migrations;

use BIMHub\Database\Migration;

class CreateDocumentsTable extends Migration
{
    public function up(): void
    {
        $this->createTable('documents', function ($table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->bigInteger('project_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type', 100);
            $table->bigInteger('file_size');
            $table->string('mime_type', 100);
            $table->string('category')->default('general');
            $table->integer('version')->default(1);
            $table->boolean('is_latest')->default(true);
            $table->bigInteger('uploaded_by')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->foreign('project_id')->references('projects', 'id')->onDelete('CASCADE');
            $table->foreign('uploaded_by')->references('users', 'id');
            
            $table->index('project_id');
            $table->index('uploaded_by');
            $table->index('category');
            $table->index(['project_id', 'is_latest']);
            $table->index('created_at');
        });
    }
    
    public function down(): void
    {
        $this->dropTable('documents');
    }
}
