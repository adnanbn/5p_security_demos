# Demo Runbook

## Secure Baseline

```bash
composer install
php artisan test --display-warnings
vendor/bin/pint --test
```

Expected result: every check passes.

Start from the [demo catalog](../demos/README.md). Each stable ID explains the
risk, secure baseline, proof, expected red gate, and evidence limits.

## Incident 1

```bash
php artisan masterclass:replay 1
```

Start with `incidents/01-cross-user-access/support-report.md`, then inspect the
three log files. Do not open `facilitator-findings.md` until after discussion.
After the reveal, walk through the completed
[`incident-review.md`](../incidents/01-cross-user-access/incident-review.md)
and ask which action item contains the strongest proof.

## Incident 2

```bash
php artisan masterclass:replay 2 --requests=120 --seed=20260808
```

Read the
[`evidence-manifest.json`](../incidents/02-expensive-rejection/evidence-manifest.json)
first so the deterministic 2% request sample is not compared directly with the
modeled full-stream metrics. Then begin with the timeline, edge logs, and
infrastructure metrics. Reveal the Laravel denial logs after participants have
formed initial hypotheses.
After the reveal, use the completed
[`incident-review.md`](../incidents/02-expensive-rejection/incident-review.md)
to connect the Five Hows, layered resolution, communication, and action items.

The reviews use the
[flexible incident review template](incident-review-template.md). Treat it as
a set of prompts, not a form that must be completed during active response.

## CI Demonstrations

Each `demo/*` branch introduces one deliberate problem. Open its draft pull
request, identify the red check, inspect the finding, and compare with `main`.

Never merge an intentionally failing branch.

Suggested sequence:

1. `AUTHZ-01` on `demo/01-authz-cross-user`: show that a product-specific test
   catches what generic scanners cannot infer.
2. `SECRETS-01` on `demo/02-secret-in-history`: show a harmless canary and
   discuss revoke, rotate, deploy, verify, and investigate.
3. `DEPS-01` on `demo/03-vulnerable-dependency`: inspect the isolated OSV
   fixture without installing or executing it.
4. `LOG-01` on `demo/04-sensitive-logging`: inspect the Semgrep rule and the
   unsafe header logging call.
5. `CI-01` on `demo/05-unpinned-action`: compare a mutable tag with a full
   commit SHA.
6. `AVAILABILITY-01` on `scenario/incident-02-rejection-outage`: connect a
   correct denial to an unsafe amount of work.

Repository-only extensions use the same pattern:

- `INPUT-01` on `demo/06-over-posting`
- `WEBHOOK-01` on `demo/07-webhook-replay`
- `SSRF-01` on `demo/08-ssrf-outbound`
- `XSS-01` on `demo/09-unsafe-html`

These are optional follow-up material. Use them to answer participant questions
or let students explore after the session; they do not need extra lecture
slides.

## AI-Assisted Review

Use [`ai-assisted-security-review.md`](ai-assisted-security-review.md) on one
of the deliberate branches. Ask the AI to identify the asset, boundary,
forbidden behavior, and missing evidence. Then verify its claims using the
diff, test result, and workflow output.

## Durable Evidence

Live Actions URLs and tool wording change. The `expected-finding.md` beside each
demo records the intended semantic signal. Use the live PR to demonstrate the
gate and the expected-finding file to preserve the lesson.
