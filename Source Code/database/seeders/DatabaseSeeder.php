<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        DB::table('users')->upsert([
            [
                'user_id' => 13,
                'name' => 'Muntaha',
                'email' => 'muntaha123@gmail.com',
                'password' => '$2y$10$HsSXqvJCYZoIqMDwx2vyx.jEVwt5LDo7qe3C0/.LXe0uR7k2XA4cK',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => '2026-08-27 10:31:23',
                'updated_at' => '2026-08-27 10:31:23',
            ],
            [
                'user_id' => 14,
                'name' => 'faiza',
                'email' => 'faiza@gmail.com',
                'password' => '$2y$10$czQ7/aebuieAIncX4VMdAem7XvkeAMZBXywirKRbxwnEkQhLqkPR2',
                'role' => 'parent',
                'status' => 'active',
                'created_at' => '2026-08-28 17:36:14',
                'updated_at' => '2026-08-28 17:36:14',
            ],
            [
                'user_id' => 15,
                'name' => 'Hospital Vaccinator',
                'email' => 'vaccinator@vaccicare.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC5Z3W5jW5mQ7w3K0m7W',
                'role' => 'vaccinator',
                'status' => 'active',
                'created_at' => '2026-08-30 08:29:13',
                'updated_at' => '2026-08-30 08:29:13',
            ],
            [
                'user_id' => 16,
                'name' => 'Agha Khan Vaccinator',
                'email' => 'vaccinator@agha-khan.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC8V9aV0N5vYvZQv6n6',
                'role' => 'vaccinator',
                'status' => 'active',
                'created_at' => '2026-08-30 08:51:54',
                'updated_at' => '2026-08-30 08:51:54',
            ],
        ], ['user_id'], ['name', 'email', 'password', 'role', 'status', 'created_at', 'updated_at']);

        // 2. Parents
        DB::table('parents')->upsert([
            [
                'parent_id' => 8,
                'user_id' => 14,
                'parent_name' => 'faiza',
                'phone' => '+923001234567',
                'address' => '',
                'created_at' => '2026-08-28 17:36:14',
                'updated_at' => '2026-08-28 17:36:14',
            ],
        ], ['parent_id'], ['user_id', 'parent_name', 'phone', 'address', 'created_at', 'updated_at']);

        // 3. Hospitals
        DB::table('hospitals')->upsert([
            [
                'hospital_id' => 5,
                'user_id' => 13,
                'hospital_name' => 'Agha Khan Hospital',
                'hospital_type' => 'Private',
                'license_no' => 'RG-10002',
                'email' => 'agha.khan@vaccicare.com',
                'phone' => '03001234567',
                'city' => 'Karachi',
                'address' => 'Karachi, Gulshan',
                'contact_person' => 'Dr.Ahsan',
                'working_hours' => '24 Hours',
                'status' => 'Active',
                'created_at' => '2026-08-29 14:54:34',
                'updated_at' => '2026-08-30 18:27:04',
            ],
        ], ['hospital_id'], ['user_id', 'hospital_name', 'hospital_type', 'license_no', 'email', 'phone', 'city', 'address', 'contact_person', 'working_hours', 'status', 'created_at', 'updated_at']);

        // 4. Hospital Users
        DB::table('hospital_users')->upsert([
            [
                'id' => 5,
                'hospital_name' => 'Agha Khan Hospital',
                'hospital_type' => 'Private',
                'registration_number' => 'RG-10001',
                'email' => 'agha.khan@vaccicare.com',
                'phone' => '03001234567',
                'address' => 'Karachi, Gulshan',
                'city' => 'Karachi',
                'province' => 'Sindh',
                'password' => '$2y$10$n3H6.hu.7L8.mNCTNOC.nuRoLeZj4DOPpvhTdYfwH4aDMk7.p2KQm',
                'role' => 'hospital',
                'created_at' => '2026-08-27 10:14:05',
                'updated_at' => '2026-08-27 10:14:05',
            ],
        ], ['id'], ['hospital_name', 'hospital_type', 'registration_number', 'email', 'phone', 'address', 'city', 'province', 'password', 'role', 'created_at', 'updated_at']);

        // 5. Children
        DB::table('children')->upsert([
            [
                'child_id' => 6,
                'parent_id' => 8,
                'child_name' => 'Ahmed',
                'date_of_birth' => '2023-10-05',
                'gender' => 'Male',
                'blood_group' => 'B+',
                'contact' => '02876789678',
                'additional_notes' => 'None',
                'vaccination_status' => 'Up to Date',
                'created_at' => '2026-08-29 15:14:27',
                'updated_at' => '2026-08-29 15:14:27',
            ],
            [
                'child_id' => 7,
                'parent_id' => 8,
                'child_name' => 'mahnoor',
                'date_of_birth' => '2019-02-02',
                'gender' => 'Female',
                'blood_group' => 'A+',
                'contact' => '02876789678',
                'additional_notes' => 'None',
                'vaccination_status' => 'Up to Date',
                'created_at' => '2026-08-29 15:15:35',
                'updated_at' => '2026-08-29 15:15:35',
            ],
            [
                'child_id' => 8,
                'parent_id' => 8,
                'child_name' => 'Anaya',
                'date_of_birth' => '2025-01-27',
                'gender' => 'Female',
                'blood_group' => 'A-',
                'contact' => '02876789678',
                'additional_notes' => 'None',
                'vaccination_status' => 'Pending',
                'created_at' => '2026-08-29 15:16:33',
                'updated_at' => '2026-08-29 15:16:33',
            ],
            [
                'child_id' => 9,
                'parent_id' => 8,
                'child_name' => 'ayan',
                'date_of_birth' => '2022-10-28',
                'gender' => 'Male',
                'blood_group' => 'B+',
                'contact' => '02876789678',
                'additional_notes' => 'None',
                'vaccination_status' => 'Pending',
                'created_at' => '2026-08-30 18:24:25',
                'updated_at' => '2026-08-30 18:24:25',
            ],
        ], ['child_id'], ['parent_id', 'child_name', 'date_of_birth', 'gender', 'blood_group', 'contact', 'additional_notes', 'vaccination_status', 'created_at', 'updated_at']);

        // 6. Vaccines
        DB::table('vaccines')->upsert([
            [
                'vaccine_id' => 4,
                'vaccine_name' => 'BCG',
                'description' => 'BCG vaccine',
                'manufacturer' => null,
                'recommended_age' => null,
                'created_at' => '2026-08-30 07:45:25',
                'updated_at' => '2026-08-30 07:45:25',
            ],
            [
                'vaccine_id' => 5,
                'vaccine_name' => 'polio',
                'description' => 'Polio vaccine',
                'manufacturer' => null,
                'recommended_age' => null,
                'created_at' => '2026-08-30 07:45:25',
                'updated_at' => '2026-08-30 07:45:25',
            ],
            [
                'vaccine_id' => 6,
                'vaccine_name' => 'MMR',
                'description' => 'MMR vaccine',
                'manufacturer' => null,
                'recommended_age' => null,
                'created_at' => '2026-08-30 07:45:25',
                'updated_at' => '2026-08-30 07:45:25',
            ],
        ], ['vaccine_id'], ['vaccine_name', 'description', 'manufacturer', 'recommended_age', 'created_at', 'updated_at']);

        // 7. Hospital Vaccines
        DB::table('hospital_vaccines')->upsert([
            [
                'id' => 5,
                'hospital_id' => 5,
                'vaccine_name' => 'BCG',
                'description' => 'BCG vaccine',
                'availability' => 'Available',
                'created_at' => '2026-08-29 15:09:20',
                'updated_at' => '2026-08-29 15:09:20',
            ],
            [
                'id' => 6,
                'hospital_id' => 5,
                'vaccine_name' => 'polio',
                'description' => 'Polio vaccine',
                'availability' => 'Available',
                'created_at' => '2026-08-29 15:09:51',
                'updated_at' => '2026-08-29 15:09:51',
            ],
            [
                'id' => 7,
                'hospital_id' => 5,
                'vaccine_name' => 'MMR',
                'description' => 'MMR vaccine',
                'availability' => 'Available',
                'created_at' => '2026-08-29 15:10:13',
                'updated_at' => '2026-08-29 15:10:13',
            ],
        ], ['id'], ['hospital_id', 'vaccine_name', 'description', 'availability', 'created_at', 'updated_at']);

        // 8. Vaccinators
        DB::table('vaccinators')->upsert([
            [
                'vaccinator_id' => 3,
                'user_id' => 15,
                'hospital_id' => 5,
                'name' => 'Agha Khan Vaccinator',
                'qualification' => 'Certified Vaccinator',
                'phone' => '03001234567',
                'status' => 'Active',
                'created_at' => '2026-08-30 08:54:15',
                'updated_at' => '2026-08-30 08:54:15',
            ],
        ], ['vaccinator_id'], ['user_id', 'hospital_id', 'name', 'qualification', 'phone', 'status', 'created_at', 'updated_at']);

        // 9. Parent Requests
        DB::table('parent_requests')->upsert([
            [
                'request_id' => 8,
                'parent_id' => 8,
                'child_id' => 6,
                'hospital_id' => 5,
                'hospital_vaccine_id' => 6,
                'request_type' => 'Vaccination',
                'request_date' => '2026-08-31',
                'preferred_time' => '15:00:00',
                'message' => 'Vaccination appointment for child.',
                'status' => 'Approved',
                'reviewed_by' => 13,
                'reviewed_at' => '2026-08-29 15:30:11',
                'created_at' => '2026-08-29 15:30:11',
                'updated_at' => '2026-08-29 15:30:11',
            ],
            [
                'request_id' => 9,
                'parent_id' => 8,
                'child_id' => 7,
                'hospital_id' => 5,
                'hospital_vaccine_id' => 7,
                'request_type' => 'Vaccination',
                'request_date' => '2026-11-23',
                'preferred_time' => '14:00:00',
                'message' => 'None',
                'status' => 'Approved',
                'reviewed_by' => 13,
                'reviewed_at' => '2026-08-31 06:52:57',
                'created_at' => '2026-08-31 06:52:57',
                'updated_at' => '2026-08-31 06:52:57',
            ],
        ], ['request_id'], ['parent_id', 'child_id', 'hospital_id', 'hospital_vaccine_id', 'request_type', 'request_date', 'preferred_time', 'message', 'status', 'reviewed_by', 'reviewed_at', 'created_at', 'updated_at']);

        // 10. Bookings
        DB::table('bookings')->upsert([
            [
                'booking_id' => 1,
                'parent_id' => 8,
                'child_id' => 6,
                'hospital_id' => 5,
                'vaccine_id' => 5,
                'vaccinator_id' => 3,
                'booking_date' => '2026-08-31',
                'booking_time' => '15:00:00',
                'status' => 'Completed',
                'created_at' => '2026-08-31 15:00:00',
                'updated_at' => '2026-08-31 15:00:00',
            ],
            [
                'booking_id' => 2,
                'parent_id' => 8,
                'child_id' => 7,
                'hospital_id' => 5,
                'vaccine_id' => 6,
                'vaccinator_id' => 3,
                'booking_date' => '2026-11-23',
                'booking_time' => '14:00:00',
                'status' => 'Completed',
                'created_at' => '2026-11-23 14:00:00',
                'updated_at' => '2026-11-23 14:00:00',
            ],
        ], ['booking_id'], ['parent_id', 'child_id', 'hospital_id', 'vaccine_id', 'vaccinator_id', 'booking_date', 'booking_time', 'status', 'created_at', 'updated_at']);

        // 11. Vaccinations
        DB::table('vaccinations')->upsert([
            [
                'vaccination_id' => 1,
                'child_id' => 6,
                'vaccine_id' => 5,
                'hospital_id' => 5,
                'vaccinator_id' => 3,
                'vaccination_date' => '2026-08-31',
                'vaccination_time' => '15:00:00',
                'status' => 'Completed',
                'notes' => 'vaccinated',
                'created_at' => '2026-08-30 09:08:29',
                'updated_at' => '2026-08-30 09:08:29',
            ],
            [
                'vaccination_id' => 2,
                'child_id' => 7,
                'vaccine_id' => 6,
                'hospital_id' => 5,
                'vaccinator_id' => 3,
                'vaccination_date' => '2026-11-23',
                'vaccination_time' => '14:00:00',
                'status' => 'Completed',
                'notes' => 'None',
                'created_at' => '2026-08-31 06:53:45',
                'updated_at' => '2026-08-31 06:53:45',
            ],
        ], ['vaccination_id'], ['child_id', 'vaccine_id', 'hospital_id', 'vaccinator_id', 'vaccination_date', 'vaccination_time', 'status', 'notes', 'created_at', 'updated_at']);

        // 12. Notifications
        DB::table('notifications')->upsert([
            [
                'notification_id' => 1,
                'recipient_type' => 'admin',
                'recipient_id' => 0,
                'title' => 'Welcome to VacciCare Admin Panel',
                'message' => 'Notification system is active. You will receive real-time updates for new bookings, child registrations, and hospital updates.',
                'type' => 'info',
                'link' => 'admin-dashboard.php',
                'is_read' => 1,
                'created_at' => '2026-09-06 11:44:11',
                'updated_at' => '2026-09-06 11:44:11',
            ],
            [
                'notification_id' => 2,
                'recipient_type' => 'admin',
                'recipient_id' => 0,
                'title' => 'System Status: All Services Operational',
                'message' => 'Database connectivity and notification dispatcher are functioning normally.',
                'type' => 'success',
                'link' => 'admin-dashboard.php',
                'is_read' => 1,
                'created_at' => '2026-09-06 11:44:11',
                'updated_at' => '2026-09-06 11:44:11',
            ],
            [
                'notification_id' => 3,
                'recipient_type' => 'hospital',
                'recipient_id' => 0,
                'title' => 'Welcome to Hospital Portal',
                'message' => 'You will receive notifications here when parents book appointments or update vaccination status.',
                'type' => 'info',
                'link' => 'hospital-appointments.php',
                'is_read' => 1,
                'created_at' => '2026-09-06 11:44:11',
                'updated_at' => '2026-09-06 11:44:11',
            ],
            [
                'notification_id' => 4,
                'recipient_type' => 'parent',
                'recipient_id' => 0,
                'title' => 'Welcome to VacciCare Parent Portal',
                'message' => 'Keep track of your children vaccination schedules, bookings, and hospital approvals right here.',
                'type' => 'info',
                'link' => 'vaccination-schedule.php',
                'is_read' => 0,
                'created_at' => '2026-09-06 11:44:11',
                'updated_at' => '2026-09-06 11:44:11',
            ],
        ], ['notification_id'], ['recipient_type', 'recipient_id', 'title', 'message', 'type', 'link', 'is_read', 'created_at', 'updated_at']);
    }
}
