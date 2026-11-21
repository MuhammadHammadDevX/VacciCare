<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\HospitalUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test parent signin with invalid credentials returns back.
     */
    public function test_parent_login_with_invalid_credentials(): void
    {
        $response = $this->post('/signin', [
            'email' => 'nonexistent@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect();
    }

    /**
     * Test admin login with invalid credentials returns back.
     */
    public function test_admin_login_with_invalid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'notadmin@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect();
    }

    /**
     * Test hospital login with invalid credentials returns back.
     */
    public function test_hospital_login_with_invalid_credentials(): void
    {
        $response = $this->post('/hospital/login', [
            'hospitalEmail' => 'nothospital@test.com',
            'hospitalPassword' => 'wrongpassword',
        ]);

        $response->assertRedirect();
    }

    /**
     * Test parent registration validation requires all fields.
     */
    public function test_parent_registration_validation(): void
    {
        $response = $this->post('/register', []);

        // Should redirect back with errors
        $response->assertRedirect();
    }

    /**
     * Test hospital registration validation.
     */
    public function test_hospital_registration_validation(): void
    {
        $response = $this->post('/hospital/register', []);

        // Should redirect back with errors
        $response->assertRedirect();
    }

    /**
     * Test logout confirmation page renders.
     */
    public function test_logout_page_renders(): void
    {
        $response = $this->get('/logout');
        $response->assertStatus(200);
    }

    /**
     * Test confirmed logout redirects to signin.
     */
    public function test_logout_action_redirects(): void
    {
        $response = $this->get('/logout?confirm=1');
        $response->assertRedirect('/signin');
    }

    /**
     * Test unauthenticated access to parent dashboard redirects.
     */
    public function test_parent_dashboard_requires_auth(): void
    {
        $response = $this->get('/parent/dashboard');
        $response->assertRedirect();
    }

    /**
     * Test unauthenticated access to admin dashboard redirects.
     */
    public function test_admin_dashboard_requires_auth(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect();
    }

    /**
     * Test unauthenticated access to hospital dashboard redirects.
     */
    public function test_hospital_dashboard_requires_auth(): void
    {
        $response = $this->get('/hospital/dashboard');
        $response->assertRedirect();
    }
}
