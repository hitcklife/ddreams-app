# CDL Scanner Setup Guide

## Overview
The CDL Scanner feature uses AI-powered OCR (Optical Character Recognition) to automatically extract information from Commercial Driver's License images.

## Requirements

### 1. Tesseract OCR Installation

**Windows:**
```bash
# Download and install Tesseract from:
# https://github.com/UB-Mannheim/tesseract/wiki

# Or use Chocolatey:
choco install tesseract

# Or use Scoop:
scoop install tesseract
```

**macOS:**
```bash
brew install tesseract
```

**Ubuntu/Debian:**
```bash
sudo apt-get install tesseract-ocr
```

### 2. PHP Extensions
Ensure the following PHP extensions are installed:
- GD or Imagick
- fileinfo

### 3. Storage Configuration
Make sure the `storage/app` directory is writable:
```bash
chmod -R 775 storage/
```

## Features

### AI-Powered Extraction
The CDL scanner can automatically extract:
- License number
- License class (CDL A, B, C)
- Expiration date
- Date of birth
- Endorsements (H, N, P, S, T, X)
- Restrictions

### Fallback Options
- Manual entry toggle
- Error handling with fallback to manual form
- Confidence scoring for extracted data
- Data validation and correction

### Security
- Secure image storage using Spatie Media Library
- File type validation (JPEG, PNG only)
- File size limits (10MB max)
- Temporary file cleanup

## Usage

1. **Upload CDL Image**: Drivers can upload a photo of their CDL
2. **AI Processing**: The system automatically extracts information
3. **Review & Confirm**: Drivers review extracted data for accuracy
4. **Manual Override**: Option to edit or enter information manually
5. **Save**: Information is saved to the driver profile

## Troubleshooting

### Common Issues

**Tesseract not found:**
- Ensure Tesseract is installed and in system PATH
- Check PHP can execute system commands

**Poor OCR results:**
- Ensure good image quality (clear, well-lit, high resolution)
- Try manual entry if automatic extraction fails

**File upload issues:**
- Check file size limits in php.ini
- Ensure storage directory permissions are correct

### Configuration

You can adjust OCR settings in `app/Services/CdlScannerService.php`:
- Character whitelist
- Image preprocessing parameters
- Pattern matching rules

## Support

If you encounter issues:
1. Check the application logs for detailed error messages
2. Verify Tesseract installation
3. Test with high-quality, clear CDL images
4. Use the manual entry option as a fallback
