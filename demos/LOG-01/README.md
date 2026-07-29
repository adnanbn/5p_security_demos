# LOG-01: Sensitive Request Logging

## Why This Exists

Debugging code can copy credentials, cookies, personal data, and request
contents into a logging system with different access and retention rules.

## Secure Baseline

[`SecurityEventRecorder`](../../app/Security/SecurityEventRecorder.php) records
selected decision fields and correlation context. Its unit test proves headers
and credentials are absent.

## Intentional Failure

- **Branch:** `demo/04-sensitive-logging`
- **Draft PR:** [PR #4](https://github.com/adnanbn/5p_security_demos/pull/4)
- **Expected red gate:** Semgrep security rules
- **Expected finding:** `laravel-log-entire-request` matches a complete header
  map passed to the logger

## Reproduce Safely

```bash
semgrep scan --config .semgrep/security.yml --error --metrics=off app routes config
php artisan test --filter=SecurityEventRecorderTest
```

## Evidence

- [Expected finding](expected-finding.md)
- [Semgrep policy](../../.semgrep/security.yml)
- [Safe recorder test](../../tests/Unit/SecurityEventRecorderTest.php)
- [Live draft PR](https://github.com/adnanbn/5p_security_demos/pull/4)

## What The Evidence Proves

The static rule proves a known risky logging shape entered the scanned paths.

## What It Does Not Prove

It cannot identify every sensitive field, prove production retention controls,
or replace review of the event schema.

## Secure Response

Log the decision, reason, request ID, and bounded actor/resource context.
Redact credentials, minimize personal data, and set access and retention
controls.

## Lecture Status

Core PR demonstration.
