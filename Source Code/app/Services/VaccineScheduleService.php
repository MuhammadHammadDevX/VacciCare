<?php

namespace App\Services;

use App\Models\Child;
use App\Models\Vaccination;
use Carbon\Carbon;

class VaccineScheduleService
{
    /**
     * Standard WHO / Pakistan EPI Immunization Guidelines.
     */
    public const MILESTONES = [
        [
            'key' => 'birth',
            'title' => 'At Birth',
            'days' => 0,
            'description' => 'Immediate newborn protection',
            'vaccines' => [
                ['name' => 'BCG', 'target' => 'Tuberculosis', 'dose' => 'Single Dose'],
                ['name' => 'OPV-0', 'target' => 'Polio', 'dose' => 'Dose 0'],
                ['name' => 'Hepatitis-B', 'target' => 'Hepatitis B', 'dose' => 'Birth Dose'],
            ],
        ],
        [
            'key' => '6_weeks',
            'title' => '6 Weeks',
            'days' => 42,
            'description' => 'First foundational immunization round',
            'vaccines' => [
                ['name' => 'OPV-1', 'target' => 'Polio', 'dose' => 'Dose 1'],
                ['name' => 'Pentavalent-1', 'target' => 'Diphtheria, Tetanus, Pertussis, HepB, Hib', 'dose' => 'Dose 1'],
                ['name' => 'PCV-1', 'target' => 'Pneumonia / Meningitis', 'dose' => 'Dose 1'],
                ['name' => 'Rotavirus-1', 'target' => 'Severe Diarrhea', 'dose' => 'Dose 1'],
            ],
        ],
        [
            'key' => '10_weeks',
            'title' => '10 Weeks',
            'days' => 70,
            'description' => 'Second immunization round',
            'vaccines' => [
                ['name' => 'OPV-2', 'target' => 'Polio', 'dose' => 'Dose 2'],
                ['name' => 'Pentavalent-2', 'target' => 'Diphtheria, Tetanus, Pertussis, HepB, Hib', 'dose' => 'Dose 2'],
                ['name' => 'PCV-2', 'target' => 'Pneumonia / Meningitis', 'dose' => 'Dose 2'],
                ['name' => 'Rotavirus-2', 'target' => 'Severe Diarrhea', 'dose' => 'Dose 2'],
            ],
        ],
        [
            'key' => '14_weeks',
            'title' => '14 Weeks',
            'days' => 98,
            'description' => 'Third primary immunization round',
            'vaccines' => [
                ['name' => 'OPV-3', 'target' => 'Polio', 'dose' => 'Dose 3'],
                ['name' => 'Pentavalent-3', 'target' => 'Diphtheria, Tetanus, Pertussis, HepB, Hib', 'dose' => 'Dose 3'],
                ['name' => 'PCV-3', 'target' => 'Pneumonia / Meningitis', 'dose' => 'Dose 3'],
                ['name' => 'IPV-1', 'target' => 'Inactivated Polio', 'dose' => 'Dose 1'],
            ],
        ],
        [
            'key' => '9_months',
            'title' => '9 Months',
            'days' => 270,
            'description' => 'Measles & Typhoid protection',
            'vaccines' => [
                ['name' => 'Measles-1', 'target' => 'Measles', 'dose' => 'Dose 1'],
                ['name' => 'TCV (Typhoid)', 'target' => 'Typhoid Fever', 'dose' => 'Single Dose'],
            ],
        ],
        [
            'key' => '15_months',
            'title' => '15 Months',
            'days' => 450,
            'description' => 'Booster and final infant round',
            'vaccines' => [
                ['name' => 'Measles-2', 'target' => 'Measles Booster', 'dose' => 'Dose 2'],
            ],
        ],
    ];

    /**
     * Generate customized schedule milestones for a given Child.
     */
    public function generateForChild(Child $child): array
    {
        $dob = Carbon::parse($child->date_of_birth ?? now());
        $now = Carbon::now()->startOfDay();

        // Fetch completed vaccinations for this child
        $completedVaccinations = Vaccination::with('vaccine')
            ->where('child_id', $child->child_id)
            ->where('status', 'Completed')
            ->get();

        $completedVaccineNames = $completedVaccinations->map(function ($v) {
            return strtolower(trim($v->vaccine?->vaccine_name ?? ''));
        })->filter()->toArray();

        $schedule = [];
        $totalVaccinesCount = 0;
        $completedCount = 0;

        foreach (self::MILESTONES as $milestone) {
            $dueDate = (clone $dob)->addDays($milestone['days']);
            $isPastDue = $dueDate->isPast() && !$dueDate->isToday();
            $isToday = $dueDate->isToday();

            $milestoneVaccines = [];
            $allMilestoneDone = true;

            foreach ($milestone['vaccines'] as $vac) {
                $totalVaccinesCount++;
                $vacNameLower = strtolower($vac['name']);

                // Check if recorded as completed
                $isDone = false;
                $matchingCompleted = null;
                foreach ($completedVaccinations as $cv) {
                    $cvName = strtolower(trim($cv->vaccine?->vaccine_name ?? ''));
                    if (str_contains($cvName, $vacNameLower) || str_contains($vacNameLower, $cvName)) {
                        $isDone = true;
                        $matchingCompleted = $cv;
                        break;
                    }
                }

                if ($isDone) {
                    $completedCount++;
                    $status = 'Completed';
                } elseif ($isPastDue) {
                    $status = 'Overdue';
                    $allMilestoneDone = false;
                } elseif ($dueDate->diffInDays($now, false) >= -14 && $dueDate->diffInDays($now, false) <= 0) {
                    $status = 'Due Soon';
                    $allMilestoneDone = false;
                } else {
                    $status = 'Upcoming';
                    $allMilestoneDone = false;
                }

                $milestoneVaccines[] = array_merge($vac, [
                    'status' => $status,
                    'is_completed' => $isDone,
                    'administered_at' => $matchingCompleted ? $matchingCompleted->vaccination_date : null,
                ]);
            }

            if ($allMilestoneDone && count($milestoneVaccines) > 0) {
                $milestoneStatus = 'Completed';
            } elseif ($isPastDue) {
                $milestoneStatus = 'Overdue';
            } elseif ($dueDate->diffInDays($now, false) >= -14 && $dueDate->diffInDays($now, false) <= 0) {
                $milestoneStatus = 'Due Soon';
            } else {
                $milestoneStatus = 'Upcoming';
            }

            $schedule[] = [
                'key' => $milestone['key'],
                'title' => $milestone['title'],
                'description' => $milestone['description'],
                'due_date' => $dueDate->format('Y-m-d'),
                'due_date_formatted' => $dueDate->format('d M Y'),
                'days_relative' => $dueDate->diffForHumans(),
                'status' => $milestoneStatus,
                'vaccines' => $milestoneVaccines,
            ];
        }

        $progressPercentage = $totalVaccinesCount > 0
            ? round(($completedCount / $totalVaccinesCount) * 100)
            : 0;

        return [
            'child' => $child,
            'dob' => $dob->format('d M Y'),
            'total_vaccines' => $totalVaccinesCount,
            'completed_count' => $completedCount,
            'progress_percentage' => $progressPercentage,
            'milestones' => $schedule,
        ];
    }
}
