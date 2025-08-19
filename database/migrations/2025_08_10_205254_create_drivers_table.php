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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Personal Information
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            
            // License Information
            $table->string('license_number')->nullable();
            $table->string('license_class')->nullable(); // CDL Class A, B, C
            $table->date('license_expiry_date')->nullable();
            $table->json('endorsements')->nullable(); // Array of endorsements
            
            // Medical Information
            $table->date('medical_cert_expiry')->nullable();
            $table->string('medical_cert_number')->nullable();
            
            // Experience and Qualifications
            $table->integer('years_experience')->nullable();
            $table->text('previous_employers')->nullable();
            $table->boolean('hazmat_certified')->default(false);
            $table->date('hazmat_expiry')->nullable();
            
            // Vehicle Information
            $table->string('preferred_vehicle_type')->nullable();
            $table->boolean('owns_vehicle')->default(false);
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->integer('vehicle_year')->nullable();
            $table->string('vehicle_vin')->nullable();
            $table->string('vehicle_license_plate')->nullable();
            
            // Insurance Information
            $table->string('insurance_company')->nullable();
            $table->string('insurance_policy_number')->nullable();
            $table->date('insurance_expiry')->nullable();
            
            // Status and Availability
            $table->enum('status', ['pending', 'approved', 'suspended', 'inactive'])->default('pending');
            $table->boolean('available_for_work')->default(true);
            $table->json('preferred_routes')->nullable(); // Array of preferred routes/areas
            
            // Additional Information
            $table->text('notes')->nullable();
            $table->json('documents')->nullable(); // Store document file paths
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
