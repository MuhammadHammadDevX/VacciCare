<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ParentModel;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\HospitalVaccine;
use App\Models\Vaccine;
use App\Models\Vaccination;
use App\Services\CertificateService;
use App\Services\VaccineScheduleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AdvancedFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $parentUser;
    protected ParentModel $parent;
    protected Child $child;
    protected Hospital $hospital;
    protected Vaccine $vaccine;
    protected HospitalVaccine $hospitalVaccine;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin_test@vaccicare.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $this->parentUser = User::create([
            'name' => 'Parent User',
            'email' => 'parent_test@vaccicare.com',
            'password' => Hash::make('password123'),
            'role' => 'parent',
            'status' => 'active',
        ]);

        $this->parent = ParentModel::create([
            'user_id' => $this->parentUser->user_id,
            'parent_name' => 'Parent User',
            'phone' => '03001234567',
            'address' => 'Test Address, Karachi',
        ]);

        $this->child = Child::create([
            'parent_id' => $this->parent->parent_id,
            'child_name' => 'Test Baby',
            'date_of_birth' => '2025-06-15',
            'gender' => 'Male',
            'blood_group' => 'O+',
            'contact' => '03001234567',
            'vaccination_status' => 'Pending',
        ]);

        $this->hospital = Hospital::create([
            'user_id' => $this->adminUser->user_id,
            'hospital_name' => 'Aga Khan Test Hospital',
            'hospital_type' => 'Private',
            'license_no' => 'LIC-TEST-001',
            'email' => 'hospital_test@vaccicare.com',
            'phone' => '0213456789',
            'city' => 'Karachi',
            'address' => 'Stadium Road, Karachi',
            'latitude' => 24.8924,
            'longitude' => 67.0739,
            'contact_person' => 'Dr. Test',
            'working_hours' => '24 Hours',
            'status' => 'Active',
        ]);

        $this->vaccine = Vaccine::create([
            'vaccine_name' => 'BCG',
            'description' => 'Tuberculosis vaccine',
            'dosage_schedule' => 'At Birth',
        ]);

        $this->hospitalVaccine = HospitalVaccine::create([
            'hospital_id' => $this->hospital->hospital_id,
            'vaccine_name' => 'BCG',
            'description' => 'Tuberculosis vaccine dose',
            'availability' => 'Available',
            'stock_quantity' => 45,
            'batch_number' => 'BATCH-BCG-01',
            'expiry_date' => now()->addMonths(6)->toDateString(),
            'low_stock_threshold' => 10,
        ]);
    }

    /**
     * Feature 1: Digital Certificate & Public Verification
     */
    public function test_certificate_service_creates_certificate_and_verifies(): void
    {
        $certService = app(CertificateService::class);
        $certificate = $certService->getOrCreateCertificate($this->child);

        $this->assertNotEmpty($certificate->certificate_number);
        $this->assertNotEmpty($certificate->verification_token);

        // Test public verification route
        $response = $this->get(route('certificate.verify', ['token' => $certificate->verification_token]));
        $response->assertStatus(200);
        $response->assertSee('Official Certificate Verified');
        $response->assertSee($this->child->child_name);

        // Test public PDF download route
        $pdfResponse = $this->get(route('certificate.download.public', ['token' => $certificate->verification_token]));
        $pdfResponse->assertStatus(200);
        $pdfResponse->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Feature 2: Smart Schedule Engine
     */
    public function test_smart_schedule_engine_generates_who_milestones(): void
    {
        $scheduleService = app(VaccineScheduleService::class);
        $schedule = $scheduleService->generateForChild($this->child);

        $this->assertArrayHasKey('milestones', $schedule);
        $this->assertCount(6, $schedule['milestones']);
        $this->assertEquals('At Birth', $schedule['milestones'][0]['title']);
        $this->assertEquals('6 Weeks', $schedule['milestones'][1]['title']);
        $this->assertArrayHasKey('progress_percentage', $schedule);
    }

    /**
     * Feature 3: Automated Reminders Command
     */
    public function test_reminders_command_runs_successfully(): void
    {
        $this->artisan('reminders:send --days=2')
            ->assertExitCode(0);
    }

    /**
     * Feature 4: Interactive Hospital Map Locator
     */
    public function test_hospitals_have_map_coordinates(): void
    {
        $hospitalsWithCoords = Hospital::whereNotNull('latitude')->whereNotNull('longitude')->count();
        $this->assertGreaterThan(0, $hospitalsWithCoords);
        $this->assertEquals(24.8924, (float)$this->hospital->latitude);
    }

    /**
     * Feature 5: Vaccine Inventory & Batch/Expiry Management
     */
    public function test_hospital_vaccines_have_inventory_fields_and_methods(): void
    {
        $vaccine = $this->hospitalVaccine;

        $this->assertIsInt($vaccine->stock_quantity);
        $this->assertFalse($vaccine->isOutOfStock());

        // Test low stock simulation
        $vaccine->stock_quantity = 5;
        $vaccine->low_stock_threshold = 10;
        $this->assertTrue($vaccine->isLowStock());
        $this->assertFalse($vaccine->isOutOfStock());

        // Out of stock simulation
        $vaccine->stock_quantity = 0;
        $this->assertTrue($vaccine->isOutOfStock());
    }

    /**
     * Feature 6: PWA Assets Files Exist
     */
    public function test_pwa_files_exist_on_filesystem(): void
    {
        $this->assertFileExists(public_path('manifest.json'));
        $this->assertFileExists(public_path('sw.js'));
        $this->assertFileExists(public_path('images/pwa/icon.svg'));

        $manifestContent = file_get_contents(public_path('manifest.json'));
        $this->assertStringContainsString('VacciCare', $manifestContent);
    }

    /**
     * Feature 7: Admin Reports Export
     */
    public function test_admin_exports_csv_reports(): void
    {
        // Vaccinations Export
        $response = $this->actingAs($this->adminUser, 'web')->get(route('admin.export.vaccinations'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

        // Children Export
        $response = $this->actingAs($this->adminUser, 'web')->get(route('admin.export.children'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

        // Hospitals Export
        $response = $this->actingAs($this->adminUser, 'web')->get(route('admin.export.hospitals'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

        // Bookings Export
        $response = $this->actingAs($this->adminUser, 'web')->get(route('admin.export.bookings'));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
