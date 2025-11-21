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
        Schema::table('stages', function (Blueprint $table) {
            // hapus FK lama
            $table->dropForeign(['workflow_id']);

            // pasang FK baru dengan cascade
            $table->foreign('workflow_id')
                ->references('id')->on('workflows')
                ->onDelete('cascade');
        });

        // === TABLE: evidences ===
        Schema::table('evidences', function (Blueprint $table) {
            $table->dropForeign(['stage_id']);
            $table->dropForeign(['user_id']);

            $table->foreign('stage_id')
                ->references('id')->on('stages')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('workflow__assignments', function (Blueprint $table) {

            // DROP FK lama
            $table->dropForeign('workflow__assignments_workflow_id_foreign');
            $table->dropForeign('workflow__assignments_user_id_foreign');

            // Tambah FK baru dengan cascade
            $table->foreign('workflow_id')
                ->references('id')->on('workflows')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
