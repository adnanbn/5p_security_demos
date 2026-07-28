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
}
