# INCIDENT-02: Expensive Rejection

Public probes request common secret, configuration, backup, and debug paths.
The application denies them, yet legitimate partner traffic begins timing out.
The exercise asks the group to explain how correct-looking failures became an
availability incident before application-level evidence is revealed.

Everything in this directory is synthetic.

## Participant Reading Order

1. [`evidence-manifest.json`](evidence-manifest.json)
2. [`timeline.md`](timeline.md)
3. [`edge-access.jsonl`](edge-access.jsonl)
4. [`path-frequency.csv`](path-frequency.csv)
5. [`php-fpm-metrics.csv`](php-fpm-metrics.csv)
6. [`database-metrics.csv`](database-metrics.csv)
7. [`participant-prompts.md`](participant-prompts.md)

Read the manifest before comparing counts. The JSONL files are a deterministic
sample. The PHP-FPM and database CSVs model a larger production-scale effect
and are not measurements from the local SQLite test.

After the group forms initial hypotheses, reveal
[`laravel-denials.jsonl`](laravel-denials.jsonl) and correlate its request IDs
with the edge sample.

Do not open [`facilitator-findings.md`](facilitator-findings.md) until the group
has discussed likely causes, containment, evidence limits, and communication.

## What Each File Is

| Category | Files | Interpretation |
| --- | --- | --- |
| Generated incident evidence | `edge-access.jsonl`, `laravel-denials.jsonl`, `path-frequency.csv` | Deterministic sampled synthetic request evidence |
| Evidence scope | `evidence-manifest.json` | Sample rate, seed, modeled scale, and execution limits |
| Modeled metrics | `php-fpm-metrics.csv`, `database-metrics.csv` | Plausible teaching model, not observed output from the local test |
| Participant material | `timeline.md`, `participant-prompts.md` | Scenario context and investigation questions |
| Facilitator-only reveal | `facilitator-findings.md` | Designed root cause, contributing conditions, and corrective layers |
| Proposed follow-up | `proposed-alert.md`, `proposed-denial-event.json`, `public-communication-draft.md` | Remediation and communication exercises, not incident evidence |

## Replay

```bash
php artisan masterclass:replay 2 --requests=120 --seed=20260808
```

The secure implementation and proof are cataloged under
[`AVAILABILITY-01`](../../demos/AVAILABILITY-01/README.md). The deliberate
scenario branch is teaching material and must never be merged.
