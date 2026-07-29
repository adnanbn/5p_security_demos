# AVAILABILITY-01: Expensive Rejection Path

## Why This Exists

A request can be denied correctly and still consume enough worker, database,
and logging capacity to take valid traffic down.

## Secure Baseline

Unknown API paths return `404` without database work. The partner endpoint
authenticates and rate-limits valid route traffic, while the proposed Nginx
configuration rejects common probes before PHP where practical.

## Intentional Failure

- **Branch:** `scenario/incident-02-rejection-outage`
- **Draft PR:** [PR #6](https://github.com/adnanbn/5p_security_demos/pull/6)
- **Expected red gate:** Laravel tests
- **Expected finding:** one unknown path performs three database queries before
  returning `404`

## Reproduce Safely

```bash
php artisan test --filter=PartnerApiSecurityTest
php artisan masterclass:replay 2 --requests=120 --seed=20260808
```

The replay is bounded and local. Production-scale FPM and PostgreSQL metrics are
explicitly modeled, not measurements from the SQLite test.

## Evidence

- [Expected finding](expected-finding.md)
- [Incident 2 evidence](../../incidents/02-expensive-rejection)
- [Before and after edge examples](../../infrastructure/nginx)
- [Live draft PR](https://github.com/adnanbn/5p_security_demos/pull/6)

## What The Evidence Proves

The executable test proves the unknown-route fallback touches the database.
The deterministic request sample and modeled service metrics explain a
plausible production-scale consequence.

## What It Does Not Prove

The local test does not benchmark PHP-FPM or PostgreSQL and does not establish
the exact capacity of another deployment.

## Secure Response

Contain at the edge, keep application fallback paths cheap, bound request cost,
sample repetitive denials, and alert on customer impact and shared-resource
pressure.

## Lecture Status

Core incident and PR demonstration.
