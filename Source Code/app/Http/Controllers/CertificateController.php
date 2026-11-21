<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Certificate;
use App\Models\ParentModel;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    protected CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    /**
     * Parent downloads their child's certificate PDF.
     */
    public function downloadForParent(Request $request, int $childId)
    {
        $user = Auth::user();
        $parent = ParentModel::where('user_id', $user->user_id)->first();

        if (!$parent) {
            return redirect()->route('parent.dashboard')->with('error', 'Parent profile not found.');
        }

        $child = Child::where('child_id', $childId)
            ->where('parent_id', $parent->parent_id)
            ->firstOrFail();

        $certificate = $this->certificateService->getOrCreateCertificate($child);
        $pdf = $this->certificateService->buildPdf($child, $certificate);

        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $child->child_name);
        return $pdf->download("VacciCare_Certificate_{$safeName}.pdf");
    }

    /**
     * Admin downloads certificate PDF for any child.
     */
    public function downloadForAdmin(Request $request, int $childId)
    {
        $child = Child::where('child_id', $childId)->firstOrFail();
        $certificate = $this->certificateService->getOrCreateCertificate($child);
        $pdf = $this->certificateService->buildPdf($child, $certificate);

        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $child->child_name);
        return $pdf->download("VacciCare_Certificate_{$safeName}.pdf");
    }

    /**
     * Public verification page accessed by QR Code scan.
     */
    public function verify(string $token)
    {
        $certificate = Certificate::where('verification_token', $token)->first();

        if (!$certificate) {
            return view('certificates.verify', [
                'certificate' => null,
                'child' => null,
                'vaccinations' => collect(),
            ]);
        }

        $child = $certificate->child;
        $child->loadMissing(['parent.user', 'vaccinations.vaccine', 'vaccinations.hospital']);

        $completedVaccinations = $child->vaccinations
            ->where('status', 'Completed')
            ->sortBy('vaccination_date');

        return view('certificates.verify', [
            'certificate' => $certificate,
            'child' => $child,
            'vaccinations' => $completedVaccinations,
        ]);
    }

    /**
     * Public download from verified page.
     */
    public function downloadPublic(string $token)
    {
        $certificate = Certificate::where('verification_token', $token)->firstOrFail();
        $child = $certificate->child;
        $pdf = $this->certificateService->buildPdf($child, $certificate);

        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $child->child_name);
        return $pdf->download("VacciCare_Certificate_{$safeName}.pdf");
    }
}
