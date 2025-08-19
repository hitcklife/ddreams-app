<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CdlScannerService
{
    /**
     * Extract data from CDL image using OCR and pattern matching
     */
    public function extractCdlData(UploadedFile $file): array
    {
        try {
            // Process and optimize image for OCR
            $processedImagePath = $this->preprocessImage($file);
            
            // Extract text using OCR
            $extractedText = $this->performOcr($processedImagePath);
            
            // Parse CDL data from extracted text
            $cdlData = $this->parseCdlData($extractedText);
            
            // Clean up temporary files
            Storage::disk('local')->delete($processedImagePath);
            
            return [
                'success' => true,
                'data' => $cdlData,
                'raw_text' => $extractedText,
                'confidence' => $this->calculateConfidence($cdlData)
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ];
        }
    }

    /**
     * Preprocess image for better OCR results
     */
    private function preprocessImage(UploadedFile $file): string
    {
        $tempPath = 'temp/' . Str::random(20) . '.jpg';
        
        // Load and process image
        $image = Image::read($file->getPathname());
        
        // Resize if too large (optimal OCR size)
        if ($image->width() > 1200) {
            $image->scale(width: 1200);
        }
        
        // Enhance contrast and brightness for better OCR
        $image->brightness(10)
              ->contrast(15)
              ->sharpen(10);
        
        // Save processed image
        Storage::disk('local')->put($tempPath, $image->encode());
        
        return $tempPath;
    }

    /**
     * Perform OCR on the processed image
     */
    private function performOcr(string $imagePath): string
    {
        $fullPath = Storage::disk('local')->path($imagePath);
        
        $ocr = new TesseractOCR($fullPath);
        $ocr->config('tessedit_char_whitelist', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz /-.,');
        
        return $ocr->run();
    }

    /**
     * Parse CDL data from extracted text using pattern matching
     */
    private function parseCdlData(string $text): array
    {
        $data = [];
        $lines = explode("\n", $text);
        $allText = strtoupper(implode(' ', $lines));

        // Extract license number patterns
        $data['license_number'] = $this->extractLicenseNumber($allText);
        
        // Extract license class
        $data['license_class'] = $this->extractLicenseClass($allText);
        
        // Extract dates
        $data['issue_date'] = $this->extractDate($allText, ['ISS', 'ISSUED', 'ISSUE']);
        $data['expiry_date'] = $this->extractDate($allText, ['EXP', 'EXPIRES', 'EXPIRY']);
        $data['birth_date'] = $this->extractDate($allText, ['DOB', 'BIRTH', 'BORN']);
        
        // Extract endorsements
        $data['endorsements'] = $this->extractEndorsements($allText);
        
        // Extract restrictions
        $data['restrictions'] = $this->extractRestrictions($allText);
        
        // Extract personal information
        $data['name'] = $this->extractName($lines);
        $data['address'] = $this->extractAddress($lines);
        
        return array_filter($data); // Remove empty values
    }

    /**
     * Extract license number using various patterns
     */
    private function extractLicenseNumber(string $text): ?string
    {
        // Common CDL license number patterns
        $patterns = [
            '/(?:LIC|LICENSE|DL|CDL)[\s#:]*([A-Z0-9]{8,15})/',
            '/\b([A-Z]{1,3}[0-9]{6,12})\b/',
            '/\b([0-9]{8,15})\b/',
            '/([A-Z0-9]{8,15})(?=\s+(?:CLASS|CDL|COMMERCIAL))/i'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }

        return null;
    }

    /**
     * Extract license class (CDL A, B, C)
     */
    private function extractLicenseClass(string $text): ?string
    {
        $patterns = [
            '/CLASS[\s:]*([ABC])\b/',
            '/CDL[\s:]*([ABC])\b/',
            '/COMMERCIAL[\s:]*([ABC])\b/',
            '/\bCLASS\s+([ABC])\b/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return 'CDL Class ' . $matches[1];
            }
        }

        return null;
    }

    /**
     * Extract dates based on context keywords
     */
    private function extractDate(string $text, array $keywords): ?string
    {
        foreach ($keywords as $keyword) {
            // Look for dates near the keyword
            $pattern = '/' . $keyword . '[\s:]*(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})/';
            if (preg_match($pattern, $text, $matches)) {
                return $this->formatDate($matches[1]);
            }
            
            // Alternative date format
            $pattern = '/' . $keyword . '[\s:]*(\d{2,4}[-\/]\d{1,2}[-\/]\d{1,2})/';
            if (preg_match($pattern, $text, $matches)) {
                return $this->formatDate($matches[1]);
            }
        }

        return null;
    }

    /**
     * Format date to Y-m-d format
     */
    private function formatDate(string $date): string
    {
        try {
            $date = str_replace('/', '-', $date);
            $parsed = date_create_from_format('m-d-Y', $date) ?: 
                     date_create_from_format('Y-m-d', $date) ?: 
                     date_create_from_format('d-m-Y', $date);
            
            return $parsed ? $parsed->format('Y-m-d') : $date;
        } catch (\Exception $e) {
            return $date;
        }
    }

    /**
     * Extract endorsements
     */
    private function extractEndorsements(string $text): array
    {
        $endorsements = [];
        $endorsementCodes = ['H', 'N', 'P', 'S', 'T', 'X'];
        
        foreach ($endorsementCodes as $code) {
            if (preg_match('/\b' . $code . '\b/', $text)) {
                $endorsements[] = $code;
            }
        }

        return $endorsements;
    }

    /**
     * Extract restrictions
     */
    private function extractRestrictions(string $text): array
    {
        $restrictions = [];
        
        if (preg_match('/RESTRICTIONS?[\s:]*([A-Z0-9\s,]+)/', $text, $matches)) {
            $restrictions = array_map('trim', explode(',', $matches[1]));
        }

        return array_filter($restrictions);
    }

    /**
     * Extract name from text lines
     */
    private function extractName(array $lines): ?string
    {
        foreach ($lines as $line) {
            $line = trim($line);
            // Look for lines that might contain names (2-4 words, mostly letters)
            if (preg_match('/^[A-Za-z\s]{5,50}$/', $line) && str_word_count($line) >= 2 && str_word_count($line) <= 4) {
                return $line;
            }
        }

        return null;
    }

    /**
     * Extract address from text lines
     */
    private function extractAddress(array $lines): ?string
    {
        foreach ($lines as $line) {
            $line = trim($line);
            // Look for address patterns (contains numbers and letters)
            if (preg_match('/\d+.*[A-Za-z].*/', $line) && strlen($line) > 10) {
                return $line;
            }
        }

        return null;
    }

    /**
     * Calculate confidence score based on extracted data
     */
    private function calculateConfidence(array $data): int
    {
        $score = 0;
        $maxScore = 100;

        // License number found
        if (!empty($data['license_number'])) $score += 30;
        
        // License class found
        if (!empty($data['license_class'])) $score += 25;
        
        // Expiry date found
        if (!empty($data['expiry_date'])) $score += 20;
        
        // Birth date found
        if (!empty($data['birth_date'])) $score += 15;
        
        // Name found
        if (!empty($data['name'])) $score += 10;

        return min($score, $maxScore);
    }

    /**
     * Validate extracted CDL data
     */
    public function validateExtractedData(array $data): array
    {
        $errors = [];

        // Validate license number format
        if (!empty($data['license_number'])) {
            if (strlen($data['license_number']) < 6) {
                $errors['license_number'] = 'License number seems too short';
            }
        }

        // Validate dates
        foreach (['expiry_date', 'birth_date', 'issue_date'] as $dateField) {
            if (!empty($data[$dateField])) {
                if (!strtotime($data[$dateField])) {
                    $errors[$dateField] = 'Invalid date format';
                }
            }
        }

        return $errors;
    }
}
