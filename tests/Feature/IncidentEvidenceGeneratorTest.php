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

    public function test_the_incident_generator_creates_the_expected_files(): void
    {
        $this->artisan('masterclass:replay', [
            '--output' => $this->output,
        ])->assertSuccessful();

        $directory = $this->output.'/01-cross-user-access';

        $this->assertFileExists($directory.'/support-report.md');
        $this->assertFileExists($directory.'/edge-access.jsonl');
        $this->assertFileExists($directory.'/root-cause-and-lessons.md');
        $this->assertStringContainsString(
            'Authorization never happened',
            File::get($directory.'/root-cause-and-lessons.md'),
        );
        $this->assertStringContainsString(
            'copied the URL',
            File::get($directory.'/support-report.md'),
        );
    }

    public function test_committed_incident_evidence_matches_the_default_replay(): void
    {
        $this->artisan('masterclass:replay', [
            '--output' => $this->output,
        ])->assertSuccessful();

        $generatedFiles = [
            '01-cross-user-access/application.jsonl',
            '01-cross-user-access/edge-access.jsonl',
            '01-cross-user-access/evidence-manifest.json',
            '01-cross-user-access/investigation-questions.md',
            '01-cross-user-access/root-cause-and-lessons.md',
            '01-cross-user-access/security-events.jsonl',
            '01-cross-user-access/support-report.md',
            '01-cross-user-access/timeline.md',
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
