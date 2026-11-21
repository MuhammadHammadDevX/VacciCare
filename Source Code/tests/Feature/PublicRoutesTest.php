<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    /**
     * Test homepage loads successfully.
     */
    public function test_homepage_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test vaccines page loads.
     */
    public function test_vaccines_page_loads(): void
    {
        $response = $this->get('/vaccines');
        $response->assertStatus(200);
    }

    /**
     * Test signin page loads.
     */
    public function test_signin_page_loads(): void
    {
        $response = $this->get('/signin');
        $response->assertStatus(200);
    }

    /**
     * Test register select page loads.
     */
    public function test_register_select_page_loads(): void
    {
        $response = $this->get('/register-select');
        $response->assertStatus(200);
    }

    /**
     * Test parent register page loads.
     */
    public function test_parent_register_page_loads(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /**
     * Test admin login page loads.
     */
    public function test_admin_login_page_loads(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    /**
     * Test admin create-admin page loads.
     */
    public function test_admin_create_admin_page_loads(): void
    {
        $response = $this->get('/admin/create-admin');
        $response->assertStatus(200);
    }

    /**
     * Test hospital login page loads.
     */
    public function test_hospital_login_page_loads(): void
    {
        $response = $this->get('/hospital/login');
        $response->assertStatus(200);
    }

    /**
     * Test hospital register page loads.
     */
    public function test_hospital_register_page_loads(): void
    {
        $response = $this->get('/hospital/register');
        $response->assertStatus(200);
    }

    /**
     * Test legacy index.php redirect.
     */
    public function test_legacy_index_php_redirect(): void
    {
        $response = $this->get('/index.php');
        $response->assertRedirect('/');
    }

    /**
     * Test legacy signin.php loads.
     */
    public function test_legacy_signin_php_loads(): void
    {
        $response = $this->get('/signin.php');
        $response->assertStatus(200);
    }
}
