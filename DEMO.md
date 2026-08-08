# WEBHOOK-01: Valid Webhook Replay

This branch is an intentionally failing Security Masterclass fixture.
**Do not merge it.**

## Unsafe Change

Replay protection changes from atomic `Cache::add`, which inserts only when an
event ID is absent, to unconditional `Cache::put`, which overwrites the same
key. Signature and timestamp validation still pass, but the same valid event is
accepted more than once.

## Expected Evidence

- **Red gate:** `Quality / Laravel tests`
- **Focused proof:** `PartnerWebhookSecurityTest`
- **Durable finding:** [`demos/WEBHOOK-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/WEBHOOK-01/expected-finding.md)
- **Secure baseline:** [`demos/WEBHOOK-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/WEBHOOK-01/README.md)

Other gates should remain green. The failure is a behavioral contract around
idempotency, not a known secret, dependency, or generic source signature.

## Safety

The secret, clock, event ID, payload, and cache are synthetic test fixtures.
