# Demo Runbook

## Secure Baseline

```bash
composer install
php artisan test
vendor/bin/pint --test
```

Expected result: every check passes.

## Incident 1

```bash
php artisan masterclass:replay 1
```

Start with `incidents/01-cross-user-access/support-report.md`, then inspect the
three log files. Do not open `facilitator-findings.md` until after discussion.

## Incident 2

```bash
php artisan masterclass:replay 2 --requests=120 --seed=20260808
```

Begin with the timeline, edge logs, and infrastructure metrics. Reveal the
Laravel denial logs after participants have formed initial hypotheses.

## CI Demonstrations

Each `demo/*` branch introduces one deliberate problem. Open its draft pull
request, identify the red check, inspect the finding, and compare with `main`.

Never merge an intentionally failing branch.
