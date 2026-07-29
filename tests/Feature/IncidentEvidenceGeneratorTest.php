<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class IncidentEvidenceGeneratorTest extends TestCase
{
    private string $output;

    protected function setUp(): void
    {
        parent::setUp();

        $this->output = storage_path('framework/testing/incidents');
        File::deleteDirectory($this->output);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->output);

        parent::tearDown();
    }

    public function test_incident_one_generates_participant_and_facilitator_evidence(): void
    {
        $this->artisan('masterclass:replay', [
            'incident' => 1,
            '--output' => $this->output,
        ])->assertSuccessful();

        $directory = $this->output.'/01-cross-user-access';

        $this->assertFileExists($directory.'/support-report.md');
        $this->assertFileExists($directory.'/edge-access.jsonl');
        $this->assertFileExists($directory.'/facilitator-findings.md');
        $this->assertStringContainsString(
            'Authorization never happened',
            File::get($directory.'/facilitator-findings.md'),
        );
        $this->assertStringContainsString(
            'copied the URL',
            File::get($directory.'/support-report.md'),
        );
    }

    public function test_incident_two_is_deterministic_and_bounded(): void
    {
        $arguments = [
            'incident' => 2,
            '--output' => $this->output,
            '--requests' => 12,
            '--seed' => 20260808,
        ];

        $this->artisan('masterclass:replay', $arguments)->assertSuccessful();
        $first = File::get($this->output.'/02-expensive-rejection/edge-access.jsonl');

        File::deleteDirectory($this->output);
        $this->artisan('masterclass:replay', $arguments)->assertSuccessful();
        $second = File::get($this->output.'/02-expensive-rejection/edge-access.jsonl');

        $this->assertSame($first, $second);
        $edgeRecords = array_map(
            fn (string $line): array => json_decode($line, true, flags: JSON_THROW_ON_ERROR),
            array_filter(explode("\n", $second)),
        );
        $denialRecords = array_map(
            fn (string $line): array => json_decode($line, true, flags: JSON_THROW_ON_ERROR),
            array_filter(explode(
                "\n",
                File::get($this->output.'/02-expensive-rejection/laravel-denials.jsonl'),
            )),
        );

        $this->assertCount(12, $edgeRecords);
        $this->assertCount(12, $denialRecords);

        foreach ($edgeRecords as $index => $edgeRecord) {
            $denialRecord = $denialRecords[$index];
            $isPartnerCredentialAttempt = $edgeRecord['path'] === '/api/partner/catalog';

            $this->assertSame($isPartnerCredentialAttempt ? 401 : 404, $edgeRecord['status']);
            $this->assertSame(
                $isPartnerCredentialAttempt ? 'credential_denied' : 'unknown_route_denied',
                $denialRecord['event'],
            );
            $this->assertSame($isPartnerCredentialAttempt ? 0 : 3, $denialRecord['database_queries']);
        }

        $this->assertSame(
            0.02,
            json_decode(
                File::get($this->output.'/02-expensive-rejection/evidence-manifest.json'),
                true,
                flags: JSON_THROW_ON_ERROR,
            )['sample_rate'],
        );
        $this->assertStringContainsString(
            'teaching models',
            json_decode(
                File::get($this->output.'/02-expensive-rejection/evidence-manifest.json'),
                true,
                flags: JSON_THROW_ON_ERROR,
            )['runtime_note'],
        );
    }

    public function test_committed_incident_evidence_matches_the_default_replay(): void
    {
        $this->artisan('masterclass:replay', [
            'incident' => 1,
            '--output' => $this->output,
        ])->assertSuccessful();
        $this->artisan('masterclass:replay', [
            'incident' => 2,
            '--output' => $this->output,
            '--requests' => 120,
            '--seed' => 20260808,
        ])->assertSuccessful();

        $generatedFiles = [
            '01-cross-user-access/application.jsonl',
            '01-cross-user-access/edge-access.jsonl',
            '01-cross-user-access/evidence-manifest.json',
            '01-cross-user-access/facilitator-findings.md',
            '01-cross-user-access/participant-prompts.md',
            '01-cross-user-access/security-events.jsonl',
            '01-cross-user-access/support-report.md',
            '01-cross-user-access/timeline.md',
            '02-expensive-rejection/database-metrics.csv',
            '02-expensive-rejection/edge-access.jsonl',
            '02-expensive-rejection/evidence-manifest.json',
            '02-expensive-rejection/facilitator-findings.md',
            '02-expensive-rejection/laravel-denials.jsonl',
            '02-expensive-rejection/participant-prompts.md',
            '02-expensive-rejection/path-frequency.csv',
            '02-expensive-rejection/php-fpm-metrics.csv',
            '02-expensive-rejection/proposed-alert.md',
            '02-expensive-rejection/proposed-denial-event.json',
            '02-expensive-rejection/public-communication-draft.md',
            '02-expensive-rejection/timeline.md',
        ];

        foreach ($generatedFiles as $relativePath) {
            $this->assertSame(
                File::get($this->output.'/'.$relativePath),
                File::get(base_path('incidents/'.$relativePath)),
                "Committed incident evidence drifted: {$relativePath}",
            );
        }
    }
}
