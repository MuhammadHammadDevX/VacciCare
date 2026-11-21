<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ParentModel;
use App\Models\Child;
use App\Models\Hospital;
use App\Models\HospitalVaccine;
use App\Models\Vaccine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AdminMasterCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected ParentModel $parent;
    protected Hospital $hospital;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'System Admin',
            'email' => 'admin@vaccicare.test',
            'password' => Hash::make('secret123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $parentUser = User::create([
            'name' => 'Test Parent',
            'email' => 'parent@vaccicare.test',
            'password' => Hash::make('secret123'),
            'role' => 'parent',
            'status' => 'active',
        ]);

        $this->parent = ParentModel::create([
            'user_id' => $parentUser->user_id,
            'parent_name' => 'Test Parent',
            'phone' => '03001234567',
            'address' => 'Test Street Karachi',
        ]);

        $this->hospital = Hospital::create([
            'user_id' => $this->adminUser->user_id,
            'hospital_name' => 'Test Hospital',
            'hospital_type' => 'General',
            'license_no' => 'LIC-TEST-001',
            'email' => 'hospital@vaccicare.test',
            'city' => 'Karachi',
            'address' => 'Stadium Road',
            'phone' => '02134567890',
            'contact_person' => 'Dr. Kamran',
            'working_hours' => '24 Hours',
            'status' => 'Active',
        ]);
    }

    public function test_admin_can_crud_vaccines(): void
    {
        // 1. Create vaccine
        $response = $this->actingAs($this->adminUser)
            ->withSession(['role' => 'admin', 'user_id' => $this->adminUser->user_id])
            ->post(route('admin.vaccines.store'), [
                'hospital_id' => $this->hospital->hospital_id,
                'vaccine_name' => 'Polio Booster Plus',
                'description' => 'Oral polio vaccine booster dose',
                'availability' => 'Available',
            ]);

        $response->assertRedirect(route('admin.vaccine-list'));
        $this->assertDatabaseHas('hospital_vaccines', [
            'vaccine_name' => 'Polio Booster Plus',
            'availability' => 'Available',
        ]);

        $vaccine = HospitalVaccine::where('vaccine_name', 'Polio Booster Plus')->first();
        $this->assertNotNull($vaccine);

        // 2. Update vaccine
        $updateResponse = $this->actingAs($this->adminUser)
            ->withSession(['role' => 'admin', 'user_id' => $this->adminUser->user_id])
            ->post(route('admin.vaccines.update', $vaccine->id), [
                'hospital_id' => $this->hospital->hospital_id,
                'vaccine_name' => 'Polio Booster Updated',
                'description' => 'Updated description',
                'availability' => 'Unavailable',
            ]);

        $updateResponse->assertRedirect(route('admin.vaccine-list'));
        $this->assertDatabaseHas('hospital_vaccines', [
            'id' => $vaccine->id,
            'vaccine_name' => 'Polio Booster Updated',
            'availability' => 'Unavailable',
        ]);

        // 3. Delete vaccine
        $deleteResponse = $this->actingAs($this->adminUser)
            ->withSession(['role' => 'admin', 'user_id' => $this->adminUser->user_id])
            ->post(route('admin.vaccines.destroy', $vaccine->id));

        $deleteResponse->assertRedirect(route('admin.vaccine-list'));
        $this->assertDatabaseMissing('hospital_vaccines', [
            'id' => $vaccine->id,
        ]);
    }

    public function test_admin_can_crud_children(): void
    {
        // 1. Create child
        $response = $this->actingAs($this->adminUser)
            ->withSession(['role' => 'admin', 'user_id' => $this->adminUser->user_id])
            ->post(route('admin.children.store'), [
                'parent_id' => $this->parent->parent_id,
                'child_name' => 'Sara Khan',
                'date_of_birth' => '2024-05-10',
                'gender' => 'Female',
                'blood_group' => 'O+',
                'contact' => '03009998877',
                'vaccination_status' => 'Pending',
                'additional_notes' => 'Healthy infant',
            ]);

        $response->assertRedirect(route('admin.children'));
        $this->assertDatabaseHas('children', [
            'child_name' => 'Sara Khan',
            'parent_id' => $this->parent->parent_id,
        ]);

        $child = Child::where('child_name', 'Sara Khan')->first();
        $this->assertNotNull($child);

        // 2. Update child
        $updateResponse = $this->actingAs($this->adminUser)
            ->withSession(['role' => 'admin', 'user_id' => $this->adminUser->user_id])
            ->post(route('admin.children.update', $child->child_id), [
                'parent_id' => $this->parent->parent_id,
                'child_name' => 'Sara Khan Updated',
                'date_of_birth' => '2024-05-10',
                'gender' => 'Female',
                'blood_group' => 'O+',
                'contact' => '03009998877',
                'vaccination_status' => 'Up to Date',
                'additional_notes' => 'Vaccination completed',
            ]);

        $updateResponse->assertStatus(302);
        $this->assertDatabaseHas('children', [
            'child_id' => $child->child_id,
            'child_name' => 'Sara Khan Updated',
            'vaccination_status' => 'Up to Date',
        ]);

        // 3. Delete child
        $deleteResponse = $this->actingAs($this->adminUser)
            ->withSession(['role' => 'admin', 'user_id' => $this->adminUser->user_id])
            ->post(route('admin.children.destroy', $child->child_id));

        $deleteResponse->assertRedirect(route('admin.children'));
        $this->assertDatabaseMissing('children', [
            'child_id' => $child->child_id,
        ]);
    }
}
