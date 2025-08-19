<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Driver extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'phone_number',
        'address',
        'city',
        'state',
        'zip_code',
        'emergency_contact_name',
        'emergency_contact_phone',
        'license_number',
        'license_class',
        'license_expiry_date',
        'endorsements',
        'medical_cert_expiry',
        'medical_cert_number',
        'years_experience',
        'previous_employers',
        'hazmat_certified',
        'hazmat_expiry',
        'preferred_vehicle_type',
        'owns_vehicle',
        'vehicle_make',
        'vehicle_model',
        'vehicle_year',
        'vehicle_vin',
        'vehicle_license_plate',
        'insurance_company',
        'insurance_policy_number',
        'insurance_expiry',
        'status',
        'available_for_work',
        'preferred_routes',
        'notes',
        'documents',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'license_expiry_date' => 'date',
        'medical_cert_expiry' => 'date',
        'hazmat_expiry' => 'date',
        'insurance_expiry' => 'date',
        'hazmat_certified' => 'boolean',
        'owns_vehicle' => 'boolean',
        'available_for_work' => 'boolean',
        'endorsements' => 'array',
        'preferred_routes' => 'array',
        'documents' => 'array',
    ];

    /**
     * Get the user that owns the driver profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if driver profile is complete
     */
    public function isProfileComplete(): bool
    {
        $requiredFields = [
            'date_of_birth',
            'phone_number',
            'address',
            'city',
            'state',
            'zip_code',
            'license_number',
            'license_class',
            'license_expiry_date',
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get completion percentage
     */
    public function getCompletionPercentage(): int
    {
        $allFields = [
            'date_of_birth',
            'phone_number',
            'address',
            'city',
            'state',
            'zip_code',
            'emergency_contact_name',
            'emergency_contact_phone',
            'license_number',
            'license_class',
            'license_expiry_date',
            'medical_cert_expiry',
            'years_experience',
            'preferred_vehicle_type',
        ];

        $completedFields = 0;
        foreach ($allFields as $field) {
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        return round(($completedFields / count($allFields)) * 100);
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cdl_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg'])
            ->singleFile();

        $this->addMediaCollection('medical_certificates')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
            ->singleFile();

        $this->addMediaCollection('insurance_documents')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
            ->singleFile();
    }

    /**
     * Register media conversions
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->quality(90);
    }

    /**
     * Get CDL image
     */
    public function getCdlImage()
    {
        return $this->getFirstMedia('cdl_images');
    }

    /**
     * Get CDL image URL
     */
    public function getCdlImageUrl(): ?string
    {
        $media = $this->getCdlImage();
        return $media ? $media->getUrl() : null;
    }
}
