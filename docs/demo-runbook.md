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

Suggested sequence:

1. `demo/01-authz-cross-user`: show that a product-specific test catches what
   generic scanners cannot infer.
2. `demo/02-secret-in-history`: show a harmless canary and discuss revoke,
   rotate, deploy, verify, and investigate.
3. `demo/03-vulnerable-dependency`: inspect the isolated OSV fixture without
   installing or executing it.
4. `demo/04-sensitive-logging`: inspect the Semgrep rule and the unsafe header
   logging call.
5. `demo/05-unpinned-action`: compare a mutable tag with a full commit SHA.

## AI-Assisted Review

Use [`ai-assisted-security-review.md`](ai-assisted-security-review.md) on one
of the deliberate branches. Ask the AI to identify the asset, boundary,
forbidden behavior, and missing evidence. Then verify its claims using the
diff, test result, and workflow output.
