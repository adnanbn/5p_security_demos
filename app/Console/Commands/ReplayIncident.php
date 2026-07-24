<?php

namespace App\Console\Commands;

use App\Incidents\IncidentEvidenceGenerator;
use Illuminate\Console\Command;

class ReplayIncident extends Command
{
    protected $signature = 'masterclass:replay
        {incident : Incident number: 1 or 2}
        {--output=incidents : Output directory, relative to the project root}
        {--requests=120 : Number of synthetic requests for incident 2}
        {--seed=20260808 : Seed for deterministic evidence}';

    protected $description = 'Generate deterministic, synthetic evidence for a masterclass incident';

    public function handle(IncidentEvidenceGenerator $generator): int
    {
        $incident = filter_var(
            $this->argument('incident'),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'max_range' => 2]],
        );
        $requests = filter_var(
            $this->option('requests'),
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 10, 'max_range' => 5000]],
        );
        $seed = filter_var($this->option('seed'), FILTER_VALIDATE_INT);

        if ($incident === false || $requests === false || $seed === false) {
            $this->error('Use incident 1 or 2, 10-5000 requests, and an integer seed.');

            return self::FAILURE;
        }

        $output = (string) $this->option('output');
        $outputPath = str_starts_with($output, DIRECTORY_SEPARATOR)
            ? $output
            : base_path($output);

        $directory = $generator->generate($incident, $outputPath, $requests, $seed);

        $this->info("Incident {$incident} evidence written to {$directory}");

        return self::SUCCESS;
    }
}
