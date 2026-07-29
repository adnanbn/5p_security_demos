<?php

namespace App\Incidents;

use Carbon\CarbonImmutable;
use Illuminate\Filesystem\Filesystem;

class IncidentEvidenceGenerator
{
    public function __construct(
        private readonly Filesystem $files,
    ) {}

    public function generate(
        int $incident,
        string $outputPath,
        int $requestCount,
        int $seed,
    ): string {
        return $incident === 1
            ? $this->generateCrossUserIncident($outputPath)
            : $this->generateRejectionIncident($outputPath, $requestCount, $seed);
    }

    private function generateCrossUserIncident(string $outputPath): string
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
                'generation_command' => 'php artisan masterclass:replay 1',
                'file_roles' => [
                    'generated_evidence' => [
                        'edge-access.jsonl',
                        'application.jsonl',
                        'security-events.jsonl',
                    ],
                    'participant_materials' => [
                        'support-report.md',
                        'participant-prompts.md',
                        'timeline.md',
                    ],
                    'facilitator_reveal' => [
                        'facilitator-findings.md',
                    ],
                ],
                'safety_note' => 'All identities, records, addresses, and events are synthetic. Do not replace them with customer or employer evidence.',
            ], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n",
        );

        $this->files->put($directory.'/support-report.md', <<<'MARKDOWN'
# Support Report

At 09:21, QA reported a repeatable account-boundary failure in the test environment.

QA opened booking `8412` while signed in as synthetic Account A, copied the URL,
and pasted it into a second browser that was already signed in as synthetic
Account B. The second browser returned `200` and displayed Account A's booking.

Both accounts were ordinary authenticated users. No elevated role, stolen
password, or production customer data was involved.

Do not include real customer information in the investigation channel.
MARKDOWN);

        $this->files->put($directory.'/participant-prompts.md', <<<'MARKDOWN'
# Investigation Prompts

1. Is this a bug, a security incident, or both?
2. What would you contain in the first twenty minutes?
3. What can the supplied logs prove?
4. What evidence is missing?
5. Which test would have caught the defect before deployment?
MARKDOWN);

        $this->files->put($directory.'/timeline.md', <<<'MARKDOWN'
# Timeline

- **09:06** - QA signs into synthetic Account A as actor 17.
- **09:07** - Account A opens booking `8412` and copies its URL.
- **09:08** - QA signs into synthetic Account B as actor 23 in a second browser.
- **09:09** - The copied `8412` URL returns `200` in Account B's browser.
- **09:21** - QA reports the repeatable cross-account response.
- **09:34** - The endpoint is disabled while scope is investigated.
MARKDOWN);

        $this->files->put($directory.'/facilitator-findings.md', <<<'MARKDOWN'
# Facilitator Findings

## Root Cause

The endpoint authenticated the caller but fetched a booking by global identifier without enforcing ownership or an equivalent policy.

Authentication succeeded. Authorization never happened.

## What the Evidence Shows

- Requests for booking identifiers `8411` and `8412` returned `200`.
- Authentication succeeded for actors 17 and 23.
- The access logs do not connect either actor to an individual booking request.

## What the Evidence Cannot Show

- Which actor received booking `8412` on each request.
- Whether booking `8412` belonged to that actor.
- Which fields were serialized.
- Whether other users exercised the same path.

## Corrective Layers

- Scope the query to the authenticated user's relationship.
- Retain a Laravel policy as defense in depth.
- Add a two-user feature test.
- Record an authorization decision without logging booking contents.
MARKDOWN);

        return $directory;
    }

    private function generateRejectionIncident(
        string $outputPath,
        int $requestCount,
        int $seed,
    ): string {
        $directory = $outputPath.'/02-expensive-rejection';
        $this->files->ensureDirectoryExists($directory);

        mt_srand($seed);
        $sampleRate = 0.02;

        $base = CarbonImmutable::parse('2026-08-08T10:41:00-07:00');
        $paths = [
            '/.env',
            '/.git/config',
            '/api/partner/catalog',
            '/api/.env',
            '/api/backup.zip',
            '/api/config',
            '/api/debug',
            '/api/phpinfo.php',
            '/api/vendor/phpunit',
            '/wp-login.php',
        ];
        $sources = [
            '192.0.2.44',
            '198.51.100.27',
            '198.51.100.91',
            '203.0.113.18',
            '203.0.113.72',
        ];
        $edge = [];
        $denials = [];
        $pathCounts = array_fill_keys($paths, 0);

        for ($index = 0; $index < $requestCount; $index++) {
            $path = $paths[array_rand($paths)];
            $pathCounts[$path]++;
            $timestamp = $base->addMilliseconds($index * 180);
            $requestId = sprintf('i2-req-%05d', $index + 1);
            $isPartnerCredentialAttempt = $path === '/api/partner/catalog';
            $status = $isPartnerCredentialAttempt ? 401 : 404;
            $databaseQueries = $isPartnerCredentialAttempt ? 0 : 3;
            $duration = 18 + ($databaseQueries * 8) + mt_rand(0, 18);

            $edge[] = [
                'timestamp' => $timestamp->toIso8601String(),
                'request_id' => $requestId,
                'source_ip' => $sources[array_rand($sources)],
                'method' => 'GET',
                'path' => $path,
                'status' => $status,
                'upstream_ms' => $duration,
                'sample_rate' => $sampleRate,
            ];
            $denials[] = [
                'timestamp' => $timestamp->addMilliseconds($duration)->toIso8601String(),
                'event' => $isPartnerCredentialAttempt
                    ? 'credential_denied'
                    : 'unknown_route_denied',
                'request_id' => $requestId,
                'path' => $path,
                'decision' => 'denied',
                'database_queries' => $databaseQueries,
                'synchronous_audit_write' => true,
                'duration_ms' => $duration,
                'sample_rate' => $sampleRate,
            ];
        }

        $this->writeJsonLines($directory.'/edge-access.jsonl', $edge);
        $this->writeJsonLines($directory.'/laravel-denials.jsonl', $denials);

        arsort($pathCounts);
        $frequency = ['path,count'];
        foreach ($pathCounts as $path => $count) {
            $frequency[] = "{$path},{$count}";
        }
        $this->files->put($directory.'/path-frequency.csv', implode("\n", $frequency)."\n");

        $modeledRequestCount = (int) round($requestCount / $sampleRate);
        $sampleWindowSeconds = round(max(1, $requestCount - 1) * 0.18, 2);
        $this->files->put(
            $directory.'/evidence-manifest.json',
            json_encode([
                'synthetic' => true,
                'incident_id' => 'INCIDENT-02',
                'purpose' => 'masterclass incident simulation',
                'generation_command' => "php artisan masterclass:replay 2 --requests={$requestCount} --seed={$seed}",
                'jsonl_scope' => 'deterministic sampled slice of the hostile request stream',
                'sample_rate' => $sampleRate,
                'sampled_requests' => $requestCount,
                'modeled_requests' => $modeledRequestCount,
                'sample_window_seconds' => $sampleWindowSeconds,
                'metrics_scope' => 'modeled full-stream service metrics, not a sum of the JSONL sample',
                'execution_scope' => 'AVAILABILITY-01 executes the unknown-route failure; the FPM and Postgres CSVs model its production-scale effect',
                'runtime_note' => 'The local Laravel test uses SQLite. The FPM and Postgres values are teaching models, not measurements from that test run.',
                'file_roles' => [
                    'generated_sample' => [
                        'edge-access.jsonl',
                        'laravel-denials.jsonl',
                        'path-frequency.csv',
                    ],
                    'modeled_metrics' => [
                        'database-metrics.csv',
                        'php-fpm-metrics.csv',
                    ],
                    'participant_materials' => [
                        'participant-prompts.md',
                        'timeline.md',
                    ],
                    'facilitator_reveal' => [
                        'facilitator-findings.md',
                    ],
                    'follow_up_exercises' => [
                        'proposed-alert.md',
                        'proposed-denial-event.json',
                        'public-communication-draft.md',
                    ],
                ],
                'safety_note' => 'All hosts, addresses, traffic, credentials, and metrics are synthetic. The replay command makes no external requests.',
                'seed' => $seed,
            ], JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n",
        );

        $this->files->put($directory.'/database-metrics.csv', <<<'CSV'
timestamp,active_connections,write_ops_per_second,connection_wait_ms
2026-08-08T10:40:30-07:00,7,3,1
2026-08-08T10:41:00-07:00,18,41,12
2026-08-08T10:41:30-07:00,47,188,96
2026-08-08T10:42:00-07:00,80,322,481
2026-08-08T10:42:30-07:00,80,349,910
2026-08-08T10:43:00-07:00,76,301,744
2026-08-08T10:43:30-07:00,42,109,188
CSV);

        $this->files->put($directory.'/php-fpm-metrics.csv', <<<'CSV'
timestamp,active_processes,idle_processes,max_active,listen_queue
2026-08-08T10:40:30-07:00,6,18,24,0
2026-08-08T10:41:00-07:00,14,10,24,0
2026-08-08T10:41:30-07:00,23,1,24,31
2026-08-08T10:42:00-07:00,24,0,24,146
2026-08-08T10:42:30-07:00,24,0,24,311
2026-08-08T10:43:00-07:00,24,0,24,207
2026-08-08T10:43:30-07:00,17,7,24,38
CSV);

        $this->files->put($directory.'/participant-prompts.md', <<<'MARKDOWN'
# Investigation Prompts

1. Every suspicious request was denied. Why did availability still fail?
2. Which signal would you inspect first?
3. Is PostgreSQL the root cause or a victim?
4. What should be contained before the root cause is fully known?
5. Which evidence can be shared publicly?

The JSONL files are a deterministic sample. Read `evidence-manifest.json`
before comparing request counts with the modeled service metrics.
MARKDOWN);

        $this->files->put($directory.'/timeline.md', <<<'MARKDOWN'
# Timeline

- **10:40** - Normal partner API traffic and healthy worker capacity.
- **10:41** - Automated probes begin requesting common secret, backup, and debug paths.
- **10:42** - PHP-FPM reaches maximum active workers; database waits and the listen queue rise.
- **10:43** - Legitimate partner requests time out.
- **10:44** - Edge blocks are added for the probing paths and source patterns.
- **10:47** - Capacity recovers while the application rejection path is investigated.
MARKDOWN);

        $this->files->put($directory.'/facilitator-findings.md', <<<'MARKDOWN'
# Facilitator Findings

## Root Cause

Unknown paths reached Laravel's fallback route. Custom denial-audit middleware
queried the database and synchronously wrote an audit record before returning
each `404`. Valid partner requests failed as collateral when workers and database
connections saturated.

The protected partner route continued to reject missing credentials correctly.
The expensive fallback path made the service unavailable.

## Contributing Conditions

- Common hostile paths were not rejected at the edge.
- Per-IP limiting did not address distributed low-volume sources.
- Every unknown-path denial produced database work and a durable log write.
- Alerts focused on successful authentication failures rather than rejection cost.

## Corrective Layers

- Reject common sensitive and unknown paths before Laravel where practical.
- Rate limit by multiple dimensions and enforce bounded request cost.
- Sample repetitive denials while retaining representative evidence.
- Alert on worker saturation, queue depth, denial cost, and path cardinality.
- Keep incident communication factual and avoid claiming a breach without evidence.
MARKDOWN);

        $this->files->put($directory.'/public-communication-draft.md', <<<'MARKDOWN'
# Public Communication Exercise

We are investigating elevated errors affecting the partner API. Mitigations are
in place, and service recovery is being monitored.

Our investigation into unauthorized access is ongoing. We will provide the next
update by **[time]**, or sooner if material facts change.
MARKDOWN);

        $this->files->put($directory.'/proposed-denial-event.json', <<<'JSON'
{
  "event": "api.request_denied",
  "request_id": "req_7f3...",
  "route_family": "unknown_probe",
  "outcome": "denied",
  "reason_code": "unknown_path",
  "source_fingerprint": "src_91a...",
  "sample_rate": 0.02
}
JSON);

        $this->files->put($directory.'/proposed-alert.md', <<<'MARKDOWN'
# Proposed Alert: Expensive Rejection

Page the API on-call when valid partner success rate falls while the PHP-FPM
listen queue, database connection wait, and unknown-path cardinality rise.

- **Owner:** API on-call
- **First action:** apply the documented edge containment and preserve a sample
- **Runbook:** rejection-outage
- **Evidence:** no raw credentials, request bodies, or full headers
MARKDOWN);

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
