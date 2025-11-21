<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // Buat admin
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'aaadddmmiiinn@example.com',
            'role' => 'admin',
            'password' => bcrypt('adminpassword'),
        ]);
        // Buat user biasa
        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'uusseerr@example.com',
            'role' => 'user',
            'password' => bcrypt('userpassword'),
        ]);
        // Buat workflow contoh
        $workflow = \App\Models\Workflows::create([
            'name' => 'Legal Service Workflows',
            'description' => 'Monitoring legalitas servicess',
            'created_by' => 1, // Admin ID
        ]);
        // Buat stages
        \App\Models\Stages::create([
            'workflow_id' => $workflow->id,
            'name' => 'Document Submissions',
            'description' => 'Submit legal documents',
            'order' => 1,
            'required_evidence_type' => 'document',
        ]);
        \App\Models\Stages::create([
            'workflow_id' => $workflow->id,
            'name' => 'Photo Verifications',
            'description' => 'Upload verification photos',
            'order' => 4,
            'required_evidence_type' => 'image',
        ]);
        // Assign workflow ke user
        $workflow->assignedUsers()->attach(2); // User ID 2
    }
}
