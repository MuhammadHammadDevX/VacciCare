<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProtectedRoutesTest extends TestCase
{
    /**
     * Parent profile requires authentication.
     */
    public function test_parent_profile_requires_auth(): void
    {
        $response = $this->get('/parent/profile');
        $response->assertRedirect();
    }

    /**
     * Parent children page requires authentication.
     */
    public function test_parent_children_requires_auth(): void
    {
        $response = $this->get('/parent/my-children');
        $response->assertRedirect();
    }

    /**
     * Parent schedule page requires authentication.
     */
    public function test_parent_schedule_requires_auth(): void
    {
        $response = $this->get('/parent/vaccination-schedule');
        $response->assertRedirect();
    }

    /**
     * Parent book hospital requires authentication.
     */
    public function test_parent_book_hospital_requires_auth(): void
    {
        $response = $this->get('/parent/book-hospital');
        $response->assertRedirect();
    }

    /**
     * Parent requests requires authentication.
     */
    public function test_parent_requests_requires_auth(): void
    {
        $response = $this->get('/parent/request-hospital');
        $response->assertRedirect();
    }

    /**
     * Parent report requires authentication.
     */
    public function test_parent_report_requires_auth(): void
    {
        $response = $this->get('/parent/vaccination-report');
        $response->assertRedirect();
    }

    /**
     * Admin profile requires authentication.
     */
    public function test_admin_profile_requires_auth(): void
    {
        $response = $this->get('/admin/profile');
        $response->assertRedirect();
    }

    /**
     * Admin children requires authentication.
     */
    public function test_admin_children_requires_auth(): void
    {
        $response = $this->get('/admin/children');
        $response->assertRedirect();
    }

    /**
     * Admin hospitals requires authentication.
     */
    public function test_admin_hospitals_requires_auth(): void
    {
        $response = $this->get('/admin/hospitals');
        $response->assertRedirect();
    }

    /**
     * Admin vaccine list requires authentication.
     */
    public function test_admin_vaccine_list_requires_auth(): void
    {
        $response = $this->get('/admin/vaccine-list');
        $response->assertRedirect();
    }

    /**
     * Admin parent requests requires authentication.
     */
    public function test_admin_parent_requests_requires_auth(): void
    {
        $response = $this->get('/admin/parent-requests');
        $response->assertRedirect();
    }

    /**
     * Hospital profile requires authentication.
     */
    public function test_hospital_profile_requires_auth(): void
    {
        $response = $this->get('/hospital/profile');
        $response->assertRedirect();
    }

    /**
     * Hospital appointments requires authentication.
     */
    public function test_hospital_appointments_requires_auth(): void
    {
        $response = $this->get('/hospital/appointments');
        $response->assertRedirect();
    }

    /**
     * Hospital vaccine status requires authentication.
     */
    public function test_hospital_vaccine_status_requires_auth(): void
    {
        $response = $this->get('/hospital/vaccine-status');
        $response->assertRedirect();
    }

    /**
     * Hospital add vaccine requires authentication.
     */
    public function test_hospital_add_vaccine_requires_auth(): void
    {
        $response = $this->get('/hospital/add-vaccine');
        $response->assertRedirect();
    }

    /**
     * Hospital all vaccines requires authentication.
     */
    public function test_hospital_all_vaccines_requires_auth(): void
    {
        $response = $this->get('/hospital/all-vaccines');
        $response->assertRedirect();
    }

    /**
     * Hospital vaccinators requires authentication.
     */
    public function test_hospital_vaccinators_requires_auth(): void
    {
        $response = $this->get('/hospital/vaccinators');
        $response->assertRedirect();
    }
}
