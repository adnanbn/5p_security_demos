<?php

namespace App\Incidents;

use Illuminate\Filesystem\Filesystem;

class IncidentEvidenceGenerator
{
    public function __construct(
        private readonly Filesystem $files,
    ) {}

    public function generate(string $outputPath): string
    {
        $directory = $outputPath.'/01-cross-user-access';
        $this->files->ensureDirectoryExists($directory);

        $requests = [
            ['09:07:11', 'i1-req-001', '/api/bookings/8412', 200, 34],
            ['09:07:28', 'i1-req-002', '/api/bookings/8411', 200, 31],
            ['09:08:03', 'i1-req-003', '/api/bookings/8413', 404, 19],
            ['09:09:44', 'i1-req-004', '/api/bookings/8412', 200, 29],
            ['09:12:17', 'i1-req-005', '/api/bookings/8411', 200, 33],
            ['09:18:51', 'i1-req-006', '/api/bookings/8412', 200, 30],
        ];

        $edge = [];
        $application = [];

        foreach ($requests as [$time, $requestId, $path, $status, $duration]) {
            $timestamp = "2026-08-08T{$time}-07:00";
            $edge[] = [
                'timestamp' => $timestamp,
                'request_id' => $requestId,
                'source_ip' => '192.0.2.10',
                'method' => 'GET',
                'path' => $path,
                'status' => $status,
                'duration_ms' => $duration,
            ];
            $application[] = [
                'timestamp' => $timestamp,
                'level' => 'info',
                'event' => 'http_request_completed',
                'request_id' => $requestId,
                'method' => 'GET',
                'path' => $path,
                'status' => $status,
                'duration_ms' => $duration - 4,
            ];
        }

        $this->writeJsonLines($directory.'/edge-access.jsonl', $edge);
        $this->writeJsonLines($directory.'/application.jsonl', $application);
        $this->writeJsonLines($directory.'/security-events.jsonl', [
            [
                'timestamp' => '2026-08-08T09:06:54-07:00',
                'event' => 'authentication_succeeded',
                'actor_id' => 17,
                'request_id' => 'i1-login-001',
            ],
            [
                'timestamp' => '2026-08-08T09:08:46-07:00',
                'event' => 'authentication_succeeded',
                'actor_id' => 23,
                'request_id' => 'i1-login-002',
            ],
        ]);
        $this->files->put(
            $directory.'/evidence-manifest.json',
            json_encode([
                'synthetic' => true,
                'incident_id' => 'INCIDENT-01',
                'purpose' => 'masterclass incident simulation',
                'generation_command' => 'php artisan masterclass:replay',
                'file_roles' => [
                    'generated_evidence' => [
                        'edge-access.jsonl',
                        'application.jsonl',
                        'security-events.jsonl',
                    ],
                    'investigation_materials' => [
                        'support-report.md',
                        'investigation-questions.md',
                        'timeline.md',
                    ],
                    'root_cause_and_lessons' => [
                        'root-cause-and-lessons.md',
                    ],
                ],
                'safety_note' => 'All identities, records, addresses, and events are synthetic. Do not replace them with customer or employer evidence.',
            ], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n",
        );

        $this->files->put($directory.'/support-report.md', <<<'MARKDOWN'
# Support Report

At 09:21, QA reported a repeatable access problem in the test environment.

QA opened booking `8412` while signed in as fictional Account A, copied the URL,
and pasted it into a second browser signed in as fictional Account B. The second
browser returned `200` and displayed Account A's booking.

Both accounts were ordinary authenticated users. No elevated role, stolen
password, or real customer data was involved. QA reproduced the behavior in
staging. The team later confirmed the same behavior in production using approved
test accounts and the minimum number of requests.

Do not include real customer information in the investigation channel.
MARKDOWN."\n");

        $this->files->put($directory.'/investigation-questions.md', <<<'MARKDOWN'
# Investigation Questions

1. What is confirmed, and what is still unknown?
2. What is the smallest action that stops more exposure?
3. What can the supplied logs prove about timing and scope?
4. Would you roll back or fix forward, and why?
5. What proof is required before restoring the endpoint?
6. What work must be owned before closing the incident?
MARKDOWN."\n");

        $this->files->put($directory.'/timeline.md', <<<'MARKDOWN'
# Timeline

- **09:06** - QA starts a controlled two-account test in staging.
- **09:09** - Account B receives Account A's booking data. QA preserves the steps.
- **09:21** - QA reports the repeatable cross-account response.
- **09:25** - The team confirms the same behavior in production with approved test accounts.
- **09:28** - The team declares a security incident and assigns an incident lead.
- **09:34** - The endpoint is disabled. Investigation and communication continue.
- **09:41** - The team confirms the missing ownership and authorization checks.
- **09:48** - The team chooses a tested fix-forward because the change is small and isolated.
- **10:05** - Staging verification passes: owner `200`, non-owner `404`, no protected data.
- **10:18** - The fix is deployed. The controlled production verification also passes.
- **10:22** - The endpoint is restored and the team monitors permission events.
- **10:35** - Historical scope remains unknown because the old logs lack actor and authorization details.
- **11:00** - The incident review assigns follow-up actions and records the communication decision.
MARKDOWN."\n");

        $this->files->put($directory.'/root-cause-and-lessons.md', <<<'MARKDOWN'
# Root Cause and Lessons

## Root Cause

The endpoint confirmed that the user was logged in, then loaded a booking only
by its ID. It did not check whether the booking belonged to that user.

Authentication succeeded. Authorization never happened.

## What the Evidence Shows

- Requests for booking identifiers `8411` and `8412` returned `200`.
- Login succeeded for users 17 and 23.
- The access logs do not connect either user to a specific booking request.

## What the Evidence Cannot Show

- Which user received booking `8412` on each request.
- Whether booking `8412` belonged to that user.
- Which booking fields were returned.
- Whether other users exercised the same path.
- When the unsafe behavior first reached production.

Missing evidence does not prove that no broader exposure occurred.

## Response Decisions

- Declare an incident after controlled production confirmation. Do not wait for
  the root cause before stopping the harm.
- Disable the affected endpoint rather than the whole platform because the team
  could isolate the unsafe route.
- Fix forward because the change was small, understood, and covered by a
  two-account test.
- Restore the endpoint only after staging and production verification passed.
- Keep the incident open until impact limits, communication, and follow-up
  ownership were recorded.

## Fixes

- Limit the query to the signed-in user's bookings.
- Keep a second server-side permission check. This demo implements it with a
  Laravel policy, but the rule applies to any server stack.
- Add a two-user feature test.
- Log the permission result without logging the booking contents.
MARKDOWN."\n");

        return $directory;
    }

    /**
     * @param  list<array<string, mixed>>  $records
     */
    private function writeJsonLines(string $path, array $records): void
    {
        $lines = array_map(
            fn (array $record): string => json_encode(
                $record,
                JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES,
            ),
            $records,
        );

        $this->files->put($path, implode("\n", $lines)."\n");
    }
}
