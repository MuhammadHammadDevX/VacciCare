<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ParentModel;
use App\Models\ParentRequest;
use App\Models\Notification as AppNotification;
use App\Notifications\VaccinationReminderNotification;
use App\Services\VaccineScheduleService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendVaccinationReminders extends Command
{
    protected $signature = 'reminders:send {--days=2 : Days ahead to scan for appointments}';
    protected $description = 'Send automated email, SMS, and in-app reminders for upcoming and due vaccinations';

    public function handle(VaccineScheduleService $scheduleService)
    {
        $daysAhead = (int) $this->option('days');
        $this->info("Scanning vaccination appointments within the next {$daysAhead} days...");

        $targetDateMax = Carbon::today()->addDays($daysAhead)->toDateString();
        $today = Carbon::today()->toDateString();

        $remindersCount = 0;

        // 1. Process Approved Upcoming Parent Requests / Bookings
        $upcomingRequests = ParentRequest::with(['parent.user', 'child', 'hospital', 'hospitalVaccine'])
            ->where('status', 'Approved')
            ->whereBetween('request_date', [$today, $targetDateMax])
            ->get();

        foreach ($upcomingRequests as $req) {
            $parent = $req->parent;
            $user = $parent?->user;
            $child = $req->child;
            $hospital = $req->hospital;
            $vaccineName = $req->hospitalVaccine?->vaccine_name ?? 'Scheduled Vaccination';
            $dateFormatted = Carbon::parse($req->request_date)->format('d M Y');
            $childName = $child?->child_name ?? 'Your Child';
            $hospitalName = $hospital?->hospital_name ?? 'Selected Hospital';
            $contactPhone = $child?->contact ?: ($parent?->phone ?: 'N/A');

            // 1.1 In-App Notification (Database)
            $existingNotice = AppNotification::where('recipient_type', 'parent')
                ->where('recipient_id', $parent->parent_id ?? 0)
                ->where('title', 'LIKE', "%{$childName}%")
                ->where('created_at', '>=', Carbon::today()->startOfDay())
                ->first();

            if (!$existingNotice && $parent) {
                AppNotification::create([
                    'recipient_type' => 'parent',
                    'recipient_id' => $parent->parent_id,
                    'title' => "Reminder: {$vaccineName} for {$childName}",
                    'message' => "Upcoming vaccination dose scheduled for {$childName} on {$dateFormatted} at {$hospitalName}.",
                    'type' => 'warning',
                    'link' => '/parent/vaccination-schedule',
                    'is_read' => 0,
                ]);
            }

            // 1.2 SMS Logging (Simulated SMS Gateway)
            Log::info("[SMS Gateway] SENT to {$contactPhone}: VacciCare Alert: {$vaccineName} for {$childName} is scheduled on {$dateFormatted} at {$hospitalName}. Ref #REQ-{$req->request_id}");

            // 1.3 Email Notification
            if ($user && $user->email) {
                try {
                    $user->notify(new VaccinationReminderNotification($childName, $vaccineName, $dateFormatted, $hospitalName));
                } catch (\Throwable $e) {
                    Log::warning("Could not dispatch email to {$user->email}: " . $e->getMessage());
                }
            }

            $remindersCount++;
            $this->line(" - Reminder processed for {$childName} ({$vaccineName} on {$dateFormatted})");
        }

        // 2. Scan Overdue & Due-Soon Children WHO/EPI Milestones
        $parents = ParentModel::with(['children', 'user'])->get();
        foreach ($parents as $parent) {
            foreach ($parent->children as $child) {
                $sched = $scheduleService->generateForChild($child);
                foreach ($sched['milestones'] as $m) {
                    if (in_array($m['status'], ['Due Soon', 'Overdue'])) {
                        foreach ($m['vaccines'] as $vac) {
                            if (!$vac['is_completed']) {
                                $existing = AppNotification::where('recipient_type', 'parent')
                                    ->where('recipient_id', $parent->parent_id)
                                    ->where('title', 'LIKE', "%{$vac['name']}%")
                                    ->where('created_at', '>=', Carbon::today()->subDays(3))
                                    ->first();

                                if (!$existing) {
                                    AppNotification::create([
                                        'recipient_type' => 'parent',
                                        'recipient_id' => $parent->parent_id,
                                        'title' => "EPI Alert: {$vac['name']} is {$m['status']}",
                                        'message' => "According to WHO/EPI guidelines, {$child->child_name} needs {$vac['name']} ({$vac['dose']}). Target due date was {$m['due_date_formatted']}.",
                                        'type' => $m['status'] === 'Overdue' ? 'danger' : 'info',
                                        'link' => '/parent/vaccination-schedule',
                                        'is_read' => 0,
                                    ]);

                                    $remindersCount++;
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->info("Completed! Processed {$remindersCount} reminders.");
        return Command::SUCCESS;
    }
}
