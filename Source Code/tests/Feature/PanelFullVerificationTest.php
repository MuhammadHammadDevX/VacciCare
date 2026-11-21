<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ParentModel;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\HospitalUser;
use App\Models\HospitalVaccine;
use App\Models\Vaccine;
use App\Models\Vaccinator;
use App\Models\Booking;
use App\Models\ParentRequest;
use App\Models\Vaccination;
use App\Models\Certificate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class PanelFullVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $parentUser;
    protected ParentModel $parent;
    protected Child $child;
    protected Hospital $hospital;
    protected HospitalUser $hospitalUser;
    protected Vaccine $vaccine;
    protected HospitalVaccine $hospitalVaccine;
    protected Vaccinator $vaccinator;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Admin
        $this->adminUser = User::create([
            'name' => 'Admin Officer',
            'email' => 'admin@vaccicare.test',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // 2. Parent & User
        $this->parentUser = User::create([
            'name' => 'Fatima Ali',
            'email' => 'fatima@vaccicare.test',
            'password' => Hash::make('secret123'),
            'role' => 'parent',
            'status' => 'active',
        ]);

        $this->parent = ParentModel::create([
            'user_id' => $this->parentUser->user_id,
            'parent_name' => 'Fatima Ali',
            'phone' => '03001234567',
            'address' => 'Gulshan-e-Iqbal, Karachi',
        ]);

        $this->child = Child::create([
            'parent_id' => $this->parent->parent_id,
            'child_name' => 'Zain Ali',
            'date_of_birth' => '2025-05-10',
            'gender' => 'Male',
            'blood_group' => 'B+',
            'contact' => '03001234567',
            'vaccination_status' => 'Pending',
        ]);

        // 3. Hospital & Hospital User
        $this->hospital = Hospital::create([
            'user_id' => $this->adminUser->user_id,
            'hospital_name' => 'National Children Hospital',
            'hospital_type' => 'Specialized',
            'license_no' => 'NCH-LIC-9988',
            'email' => 'nch@vaccicare.test',
            'phone' => '0219988776',
            'city' => 'Karachi',
            'address' => 'Clifton Block 5, Karachi',
            'latitude' => 24.8138,
            'longitude' => 67.0300,
            'contact_person' => 'Dr. Kamran',
            'working_hours' => '24 Hours',
            'status' => 'Active',
        ]);

        $this->hospitalUser = HospitalUser::create([
            'hospital_name' => 'National Children Hospital',
            'hospital_type' => 'Specialized',
            'registration_number' => 'NCH-LIC-9988',
            'email' => 'nch@vaccicare.test',
            'phone' => '03129988776',
            'address' => 'Clifton Block 5, Karachi',
            'city' => 'Karachi',
            'province' => 'Sindh',
            'password' => Hash::make('secret123'),
            'role' => 'hospital',
        ]);

        $vaccinatorUser = User::create([
            'name' => 'Nurse Saima',
            'email' => 'saima@vaccicare.test',
            'password' => Hash::make('secret123'),
            'role' => 'vaccinator',
            'status' => 'active',
        ]);

        $this->vaccinator = Vaccinator::create([
            'user_id' => $vaccinatorUser->user_id,
            'hospital_id' => $this->hospital->hospital_id,
            'name' => 'Nurse Saima',
            'qualification' => 'RN, BSN',
            'phone' => '03009988776',
            'status' => 'Active',
        ]);

        $this->vaccine = Vaccine::create([
            'vaccine_name' => 'Polio (OPV)',
            'description' => 'Oral Polio Vaccine',
            'dosage_schedule' => 'Birth, 6, 10, 14 Weeks',
        ]);

        $this->hospitalVaccine = HospitalVaccine::create([
            'hospital_id' => $this->hospital->hospital_id,
            'vaccine_name' => 'Polio (OPV)',
            'description' => 'Oral Polio Vaccine Drops',
            'availability' => 'Available',
            'stock_quantity' => 25,
            'batch_number' => 'BATCH-POL-2026',
            'expiry_date' => now()->addMonths(8)->toDateString(),
            'low_stock_threshold' => 10,
        ]);
    }

    /**
     * Test Public Pages and Verification
     */
    public function test_public_pages_and_verification(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/vaccines')->assertStatus(200);
        // Guest visiting appointment is redirected to signin
        $this->get('/appointment')->assertRedirect(route('signin'));
        // Authenticated parent visiting appointment gets 200
        $this->actingAs($this->parentUser, 'web')->get('/appointment')->assertStatus(200);
        $this->get('/signin')->assertStatus(200);

        // Verification with invalid token gives 200 showing friendly not found message
        $this->get(route('certificate.verify', ['token' => 'invalid-token-123']))
            ->assertStatus(200)
            ->assertSee('Certificate Not Found');
    }

    /**
     * Test Admin Panel Routes and Actions
     */
    public function test_admin_panel_all_pages_and_actions(): void
    {
        $admin = $this->actingAs($this->adminUser, 'web');

        // Dashboard
        $admin->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('Admin Dashboard')
            ->assertSee('SYSTEM MANAGEMENT');

        // Profile
        $admin->get(route('admin.profile'))->assertStatus(200);

        // Children list & details
        $admin->get(route('admin.children'))
            ->assertStatus(200)
            ->assertSee($this->child->child_name);

        $admin->get(route('admin.child-details', $this->child->child_id))
            ->assertStatus(200)
            ->assertSee($this->child->child_name);

        // Certificate download as Admin
        $admin->get(route('admin.certificate.download', $this->child->child_id))
            ->assertStatus(200)
            ->assertHeader('content-type', 'application/pdf');

        // Hospitals
        $admin->get(route('admin.hospital-list'))
            ->assertStatus(200)
            ->assertSee($this->hospital->hospital_name);

        $admin->get(route('admin.add-hospital'))
            ->assertStatus(200)
            ->assertSee('Pin Hospital Location on Map');

        $admin->get(route('admin.view-hospital', $this->hospital->hospital_id))
            ->assertStatus(200)
            ->assertSee($this->hospital->hospital_name);

        $admin->get(route('admin.edit-hospital', $this->hospital->hospital_id))
            ->assertStatus(200)
            ->assertSee($this->hospital->hospital_name);

        // Vaccines & requests & bookings
        $admin->get(route('admin.vaccine-list'))->assertStatus(200);
        $admin->get(route('admin.parent-requests'))->assertStatus(200);
        $admin->get(route('admin.booking-details'))->assertStatus(200);
        $admin->get(route('admin.vaccinations-date'))->assertStatus(200);
        $admin->get(route('admin.vaccination-report'))->assertStatus(200);

        // Exports
        $admin->get(route('admin.export.vaccinations'))->assertStatus(200)->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $admin->get(route('admin.export.children'))->assertStatus(200)->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $admin->get(route('admin.export.hospitals'))->assertStatus(200)->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $admin->get(route('admin.export.bookings'))->assertStatus(200)->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    /**
     * Test Parent Panel Routes, Smart Schedule, Map, and Booking
     */
    public function test_parent_panel_all_pages_and_actions(): void
    {
        $parent = $this->actingAs($this->parentUser, 'web');

        // Dashboard
        $parent->get(route('parent.dashboard'))
            ->assertStatus(200)
            ->assertSee('Parent Panel');

        // Profile & Edit Profile
        $parent->get(route('parent.profile'))->assertStatus(200);
        $parent->get(route('parent.edit-profile'))->assertStatus(200);

        // Children list
        $parent->get(route('parent.children'))
            ->assertStatus(200)
            ->assertSee($this->child->child_name);

        // Edit Child form
        $parent->get(route('parent.edit-child', $this->child->child_id))
            ->assertStatus(200)
            ->assertSee($this->child->child_name);

        // Smart Schedule with WHO/EPI engine
        $parent->get(route('parent.schedule', ['child_id' => $this->child->child_id]))
            ->assertStatus(200)
            ->assertSee('WHO / EPI SMART ENGINE')
            ->assertSee('At Birth')
            ->assertSee('6 Weeks');

        // Book Hospital with Leaflet Map
        $parent->get(route('parent.book-hospital', ['hospital_id' => $this->hospital->hospital_id]))
            ->assertStatus(200)
            ->assertSee('Find Vaccination Centers Near You')
            ->assertSee('parentHospitalMap');

        // Submit Booking Request
        $bookResponse = $parent->post(route('parent.store-book-hospital'), [
            'child_id' => $this->child->child_id,
            'hospital_id' => $this->hospital->hospital_id,
            'hospital_vaccine_id' => $this->hospitalVaccine->id,
            'appointment_date' => now()->addDays(2)->format('Y-m-d'),
            'preferred_time' => '10:00:00',
            'notes' => 'First vaccination appointment',
        ]);
        $bookResponse->assertRedirect(route('parent.book-hospital') . '?hospital_id=' . $this->hospital->hospital_id);

        $this->assertDatabaseHas('parent_requests', [
            'child_id' => $this->child->child_id,
            'hospital_id' => $this->hospital->hospital_id,
            'status' => 'Pending',
        ]);

        // Requests page & Report page
        $parent->get(route('parent.requests'))->assertStatus(200);
        $parent->get(route('parent.report'))->assertStatus(200);

        // Certificate download as Parent
        $parent->get(route('parent.certificate.download', $this->child->child_id))
            ->assertStatus(200)
            ->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Test Hospital Panel Routes, Inventory, and Vaccine Administration
     */
    public function test_hospital_panel_all_pages_and_actions(): void
    {
        $hospitalGuard = $this->actingAs($this->hospitalUser, 'hospital');

        // Hospital Dashboard
        $hospitalGuard->get(route('hospital.dashboard'))
            ->assertStatus(200)
            ->assertSee('Vaccine Stock');

        // Profile & Edit Profile
        $hospitalGuard->get(route('hospital.profile'))->assertStatus(200);
        $hospitalGuard->get(route('hospital.edit-profile'))->assertStatus(200);

        // Appointments & Vaccine Status
        $hospitalGuard->get(route('hospital.appointments'))->assertStatus(200);
        $hospitalGuard->get(route('hospital.vaccine-status'))->assertStatus(200);

        // Add Vaccine with Inventory details
        $hospitalGuard->get(route('hospital.add-vaccine'))
            ->assertStatus(200)
            ->assertSee('Stock Quantity (Vials)')
            ->assertSee('Batch / Lot Number');

        // Post Add Vaccine
        $hospitalGuard->post(route('hospital.manage-vaccine'), [
            'vaccine_name' => 'Measles & Rubella',
            'availability' => 'Available',
            'stock_quantity' => 40,
            'batch_number' => 'BATCH-MR-2026',
            'expiry_date' => now()->addMonths(12)->format('Y-m-d'),
            'low_stock_threshold' => 8,
            'description' => 'Measles prevention dose',
        ])->assertRedirect(route('hospital.add-vaccine'));

        $this->assertDatabaseHas('hospital_vaccines', [
            'hospital_id' => $this->hospitalUser->id,
            'vaccine_name' => 'Measles & Rubella',
            'stock_quantity' => 40,
        ]);

        // All Vaccines inventory table
        $hospitalGuard->get(route('hospital.all-vaccines'))
            ->assertStatus(200)
            ->assertSee('Stock (Vials)')
            ->assertSee('BATCH-MR-2026');

        // Vaccinators
        $hospitalGuard->get(route('hospital.vaccinators'))->assertStatus(200);

        // Create a confirmed Booking and Administer Vaccination -> Decrement stock
        $booking = Booking::create([
            'parent_id' => $this->parent->parent_id,
            'child_id' => $this->child->child_id,
            'hospital_id' => $this->hospital->hospital_id,
            'vaccine_id' => $this->vaccine->vaccine_id,
            'vaccinator_id' => $this->vaccinator->vaccinator_id,
            'booking_date' => now()->toDateString(),
            'booking_time' => '10:00:00',
            'status' => 'Confirmed',
        ]);

        $prevStock = $this->hospitalVaccine->stock_quantity;

        // Administer vaccine
        $hospitalGuard->post(route('hospital.vaccine-status'), [
            'request_id' => $booking->booking_id,
            'vaccination_result' => 'Vaccinated',
            'notes' => 'Successfully vaccinated on time',
        ])->assertRedirect();

        $this->assertDatabaseHas('vaccinations', [
            'child_id' => $this->child->child_id,
            'status' => 'Completed',
        ]);

        // Verify stock decremented
        $this->assertEquals($prevStock - 1, $this->hospitalVaccine->fresh()->stock_quantity);
    }
}
