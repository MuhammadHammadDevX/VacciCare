<?php

namespace App\Services;

use App\Models\Child;
use App\Models\Certificate;
use App\Models\Vaccination;
use Barryvdh\DomPDF\Facade\Pdf;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Str;

class CertificateService
{
    /**
     * Get existing certificate or issue a new one for a child.
     */
    public function getOrCreateCertificate(Child $child): Certificate
    {
        $certificate = Certificate::where('child_id', $child->child_id)->first();

        if (!$certificate) {
            $year = date('Y');
            $certNumber = sprintf('VC-%s-%05d', $year, $child->child_id);
            $token = Str::random(32);

            $certificate = Certificate::create([
                'child_id' => $child->child_id,
                'certificate_number' => $certNumber,
                'verification_token' => $token,
                'issued_at' => now(),
            ]);
        }

        return $certificate;
    }

    /**
     * Generate QR Code as base64 SVG data URI.
     */
    public function generateQrCodeDataUri(string $content): string
    {
        $options = new QROptions([
            'outputInterface' => \chillerlan\QRCode\Output\QRMarkupSVG::class,
            'returnResource' => false,
            'addQuietzone' => true,
            'quietzoneSize' => 2,
        ]);

        $svgString = (new QRCode($options))->render($content);

        // If chillerlan returns raw SVG, convert to base64 data uri for DomPDF compatibility
        if (str_starts_with(trim($svgString), '<svg') || str_starts_with(trim($svgString), '<?xml')) {
            return 'data:image/svg+xml;base64,' . base64_encode($svgString);
        }

        return $svgString;
    }

    /**
     * Build the PDF document for download or streaming.
     */
    public function buildPdf(Child $child, Certificate $certificate)
    {
        $child->loadMissing(['parent.user', 'vaccinations.vaccine', 'vaccinations.hospital', 'vaccinations.vaccinator']);

        $completedVaccinations = $child->vaccinations
            ->where('status', 'Completed')
            ->sortBy('vaccination_date');

        $verifyUrl = route('certificate.verify', ['token' => $certificate->verification_token]);
        $qrCodeDataUri = $this->generateQrCodeDataUri($verifyUrl);

        $pdf = Pdf::loadView('certificates.template', [
            'child' => $child,
            'parent' => $child->parent,
            'certificate' => $certificate,
            'vaccinations' => $completedVaccinations,
            'qrCode' => $qrCodeDataUri,
            'verifyUrl' => $verifyUrl,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }
}
