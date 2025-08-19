<?php

namespace App\Livewire;

use App\Models\Driver;
use App\Services\CdlScannerService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class DriverProfile extends Component
{
    use WithFileUploads;

    public $driver;

    // Personal Information
    #[Validate('required|date|before:today')]
    public $date_of_birth;

    #[Validate('required|string|max:20')]
    public $phone_number;

    #[Validate('required|string|max:255')]
    public $address;

    #[Validate('required|string|max:100')]
    public $city;

    #[Validate('required|string|max:50')]
    public $state;

    #[Validate('required|string|max:10')]
    public $zip_code;

    #[Validate('nullable|string|max:100')]
    public $emergency_contact_name;

    #[Validate('nullable|string|max:20')]
    public $emergency_contact_phone;

    // License Information
    #[Validate('required|string|max:50')]
    public $license_number;

    #[Validate('required|string')]
    public $license_class;

    #[Validate('required|date|after:today')]
    public $license_expiry_date;

    #[Validate('nullable|array')]
    public $endorsements = [];

    // Medical Information
    #[Validate('nullable|date')]
    public $medical_cert_expiry;

    #[Validate('nullable|string|max:50')]
    public $medical_cert_number;

    // Experience
    #[Validate('nullable|integer|min:0|max:50')]
    public $years_experience;

    #[Validate('nullable|string')]
    public $previous_employers;

    #[Validate('boolean')]
    public $hazmat_certified = false;

    #[Validate('nullable|date')]
    public $hazmat_expiry;

    // Vehicle Information
    #[Validate('nullable|string|max:100')]
    public $preferred_vehicle_type;

    #[Validate('boolean')]
    public $owns_vehicle = false;

    #[Validate('nullable|string|max:50')]
    public $vehicle_make;

    #[Validate('nullable|string|max:50')]
    public $vehicle_model;

    #[Validate('nullable|integer|min:1900|max:2030')]
    public $vehicle_year;

    #[Validate('nullable|string|max:17')]
    public $vehicle_vin;

    #[Validate('nullable|string|max:20')]
    public $vehicle_license_plate;

    // Insurance Information
    #[Validate('nullable|string|max:100')]
    public $insurance_company;

    #[Validate('nullable|string|max:50')]
    public $insurance_policy_number;

    #[Validate('nullable|date')]
    public $insurance_expiry;

    // Additional Information
    #[Validate('nullable|string')]
    public $notes;

    public $currentStep = 1;
    public $totalSteps = 5;

    // CDL Scanning properties
    public $cdlImage;
    public $useAiScan = true;
    public $scanInProgress = false;
    public $scanResults = [];
    public $scanError = null;
    public $extractedData = [];
    public $showManualForm = false;

    public function mount()
    {
        $user = Auth::user();
        $this->driver = $user->driver ?? $user->driver()->create(['user_id' => $user->id]);
        
        // Populate existing data
        $this->fillFormFromDriver();
    }

    public function fillFormFromDriver()
    {
        $this->date_of_birth = $this->driver->date_of_birth?->format('Y-m-d');
        $this->phone_number = $this->driver->phone_number;
        $this->address = $this->driver->address;
        $this->city = $this->driver->city;
        $this->state = $this->driver->state;
        $this->zip_code = $this->driver->zip_code;
        $this->emergency_contact_name = $this->driver->emergency_contact_name;
        $this->emergency_contact_phone = $this->driver->emergency_contact_phone;
        $this->license_number = $this->driver->license_number;
        $this->license_class = $this->driver->license_class;
        $this->license_expiry_date = $this->driver->license_expiry_date?->format('Y-m-d');
        $this->endorsements = $this->driver->endorsements ?? [];
        $this->medical_cert_expiry = $this->driver->medical_cert_expiry?->format('Y-m-d');
        $this->medical_cert_number = $this->driver->medical_cert_number;
        $this->years_experience = $this->driver->years_experience;
        $this->previous_employers = $this->driver->previous_employers;
        $this->hazmat_certified = $this->driver->hazmat_certified;
        $this->hazmat_expiry = $this->driver->hazmat_expiry?->format('Y-m-d');
        $this->preferred_vehicle_type = $this->driver->preferred_vehicle_type;
        $this->owns_vehicle = $this->driver->owns_vehicle;
        $this->vehicle_make = $this->driver->vehicle_make;
        $this->vehicle_model = $this->driver->vehicle_model;
        $this->vehicle_year = $this->driver->vehicle_year;
        $this->vehicle_vin = $this->driver->vehicle_vin;
        $this->vehicle_license_plate = $this->driver->vehicle_license_plate;
        $this->insurance_company = $this->driver->insurance_company;
        $this->insurance_policy_number = $this->driver->insurance_policy_number;
        $this->insurance_expiry = $this->driver->insurance_expiry?->format('Y-m-d');
        $this->notes = $this->driver->notes;
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->validate([
                    'date_of_birth' => 'required|date|before:today',
                    'phone_number' => 'required|string|max:20',
                    'address' => 'required|string|max:255',
                    'city' => 'required|string|max:100',
                    'state' => 'required|string|max:50',
                    'zip_code' => 'required|string|max:10',
                ]);
                break;
            case 2:
                $this->validate([
                    'license_number' => 'required|string|max:50',
                    'license_class' => 'required|string',
                    'license_expiry_date' => 'required|date|after:today',
                ]);
                break;
            case 3:
                $this->validate([
                    'years_experience' => 'nullable|integer|min:0|max:50',
                ]);
                break;
        }
    }

    public function save()
    {
        // Add dynamic validation rules
        $this->validate([
            'vehicle_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);
        
        $this->validate();

        $this->driver->update([
            'date_of_birth' => $this->date_of_birth,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
            'license_number' => $this->license_number,
            'license_class' => $this->license_class,
            'license_expiry_date' => $this->license_expiry_date,
            'endorsements' => $this->endorsements,
            'medical_cert_expiry' => $this->medical_cert_expiry,
            'medical_cert_number' => $this->medical_cert_number,
            'years_experience' => $this->years_experience,
            'previous_employers' => $this->previous_employers,
            'hazmat_certified' => $this->hazmat_certified,
            'hazmat_expiry' => $this->hazmat_expiry,
            'preferred_vehicle_type' => $this->preferred_vehicle_type,
            'owns_vehicle' => $this->owns_vehicle,
            'vehicle_make' => $this->vehicle_make,
            'vehicle_model' => $this->vehicle_model,
            'vehicle_year' => $this->vehicle_year,
            'vehicle_vin' => $this->vehicle_vin,
            'vehicle_license_plate' => $this->vehicle_license_plate,
            'insurance_company' => $this->insurance_company,
            'insurance_policy_number' => $this->insurance_policy_number,
            'insurance_expiry' => $this->insurance_expiry,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'Driver profile updated successfully!');
        return redirect()->route('driver.dashboard');
    }

    /**
     * Toggle between AI scan and manual entry
     */
    public function toggleInputMethod()
    {
        $this->useAiScan = !$this->useAiScan;
        $this->showManualForm = !$this->useAiScan;
        $this->resetScanState();
    }

    /**
     * Process uploaded CDL image with AI
     */
    public function processCdlImage()
    {
        $this->validate([
            'cdlImage' => 'required|image|max:10240', // 10MB max
        ]);

        $this->scanInProgress = true;
        $this->scanError = null;
        $this->scanResults = [];

        try {
            $scanner = new CdlScannerService();
            $results = $scanner->extractCdlData($this->cdlImage);

            if ($results['success']) {
                $this->scanResults = $results;
                $this->extractedData = $results['data'];
                $this->fillFormWithExtractedData($results['data']);
                
                // Store the CDL image
                $this->driver->addMedia($this->cdlImage->getRealPath())
                    ->usingName('CDL License')
                    ->usingFileName('cdl_' . time() . '.' . $this->cdlImage->getClientOriginalExtension())
                    ->toMediaCollection('cdl_images');
                
                session()->flash('message', 'CDL scanned successfully! Please review the extracted information.');
            } else {
                $this->scanError = $results['error'] ?? 'Failed to process CDL image';
            }
        } catch (\Exception $e) {
            $this->scanError = 'Error processing image: ' . $e->getMessage();
        } finally {
            $this->scanInProgress = false;
        }
    }

    /**
     * Fill form with extracted data from CDL scan
     */
    private function fillFormWithExtractedData(array $data)
    {
        if (!empty($data['license_number'])) {
            $this->license_number = $data['license_number'];
        }
        
        if (!empty($data['license_class'])) {
            $this->license_class = $data['license_class'];
        }
        
        if (!empty($data['expiry_date'])) {
            $this->license_expiry_date = $data['expiry_date'];
        }
        
        if (!empty($data['birth_date'])) {
            $this->date_of_birth = $data['birth_date'];
        }
        
        if (!empty($data['endorsements'])) {
            $this->endorsements = $data['endorsements'];
        }
    }

    /**
     * Accept extracted data and continue
     */
    public function acceptExtractedData()
    {
        $this->resetScanState();
        $this->nextStep();
    }

    /**
     * Reject extracted data and show manual form
     */
    public function rejectExtractedData()
    {
        $this->showManualForm = true;
        $this->useAiScan = false;
        $this->resetScanState();
    }

    /**
     * Reset scan state
     */
    private function resetScanState()
    {
        $this->scanResults = [];
        $this->scanError = null;
        $this->extractedData = [];
        $this->scanInProgress = false;
    }

    /**
     * Clear uploaded CDL image
     */
    public function clearCdlImage()
    {
        $this->cdlImage = null;
        $this->resetScanState();
    }

    public function render()
    {
        return view('livewire.driver-profile')
            ->layout('components.layouts.app', ['title' => 'Driver Profile']);
    }
}
