# WEBHOOK-01: Signed Webhook Freshness And Replay Protection

## Why This Exists

A keyed hash called HMAC can show that a sender knew the shared secret and that
the body was not changed. It does not prove that the request is new or prevent
the same valid event from being processed repeatedly.

## Developer Lesson

Webhook handling needs a valid signature, a recent timestamp, replay
protection, and a safe response when a check fails.

## What Are We Protecting?

- **Data:** trusted booking status changes
- **Who sends the request?** a partner integration
- **Where is access checked?** the webhook receiver
- **What must not happen?** accepting changed, old, or repeated events

## Secure Baseline

[`PartnerWebhookVerifier`](../../app/Security/PartnerWebhookVerifier.php)
verifies the raw body with `hash_equals`, checks the timestamp, and saves the
fictional event ID only if it is new. The feature tests use a fixed
test-only secret and make no external requests.

## Intentional Failure

- **Branch:** `demo/07-webhook-replay`
- **Draft PR:** [PR #9](https://github.com/adnanbn/5p_security_demos/pull/9)
- **Expected red gate:** Laravel tests
- **Expected finding:** an unconditional cache write accepts the same correctly
  signed event more than once

## Reproduce Safely

```bash
php artisan test --filter=PartnerWebhookSecurityTest
```

## Evidence

- [Expected finding](expected-finding.md)
- Repeatable signed test requests generated inside the feature test

## Repository Relationships

- [Signature, freshness, and replay verifier](../../app/Security/PartnerWebhookVerifier.php)
- [Webhook controller](../../app/Http/Controllers/PartnerWebhookController.php)
- [API routes](../../routes/api.php)
- [Signed-request feature test](../../tests/Feature/PartnerWebhookSecurityTest.php)
- [Required quality gate](../../.github/workflows/quality.yml)

## What The Evidence Proves

It proves the receiver verifies the exact body, checks freshness, and accepts a
given event ID once within the replay window.

## What It Does Not Prove

It does not prove that every later service prevents the same action from
happening twice or that the shared secret is stored safely.

## Cross-Stack Translation

The same sequence applies to Django views and Next.js route handlers: read the
raw body, verify before parsing, enforce time bounds, and make event processing
safe to repeat without repeating the action.
