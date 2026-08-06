<?php

namespace App\Console\Commands;

use App\Incidents\IncidentEvidenceGenerator;
use Illuminate\Console\Command;

class ReplayIncident extends Command
{
    protected $signature = 'masterclass:replay
        {--output=incidents : Output directory, relative to the project root}';

    protected $description = 'Generate fictional evidence for the booking-access incident';

    public function handle(IncidentEvidenceGenerator $generator): int
    {
        $output = (string) $this->option('output');
        $outputPath = str_starts_with($output, DIRECTORY_SEPARATOR)
            ? $output
            : base_path($output);

        $directory = $generator->generate($outputPath);

        $this->info("Incident evidence written to {$directory}");

        return self::SUCCESS;
    }
}
