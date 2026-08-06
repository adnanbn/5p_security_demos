# SSRF-01: Server-Side Request Forgery

## Why This Exists

When application code fetches a caller-provided URL, the backend becomes a
network client with access that may differ from the caller's. That can expose
internal, link-local, or privileged services.

## Developer Lesson

Prefer configured destinations and constrained paths over arbitrary URLs. Pair
application validation with redirect controls, timeouts, and outbound network
rules.

## What Are We Protecting?

- **Data or service:** internal services and the server's network access
- **Who sends the request?** a logged-in API user
- **Where is access checked?** the backend HTTP client
- **What must not happen?** selecting any outbound destination

## Secure Baseline

[`OutboundUrlPolicy`](../../app/Security/OutboundUrlPolicy.php) builds preview
requests from a configured HTTPS base URL and a numeric booking-preview path.
The endpoint is rate limited per authenticated user, refuses redirects, and
uses strict timeouts. Tests call `Http::preventStrayRequests()` and fake every
destination, so no real network traffic occurs.

## Intentional Failure

- **Branch:** `demo/08-ssrf-outbound`
- **Draft PR:** [PR #10](https://github.com/adnanbn/5p_security_demos/pull/10)
- **Expected red gate:** Laravel tests
- **Expected finding:** a user-supplied absolute URL selects a fictional
  link-local destination

## Reproduce Safely

```bash
php artisan test --filter=OutboundRequestSecurityTest
```

## Evidence

- [Expected finding](expected-finding.md)
- Laravel HTTP-client assertions proving which fictional host was selected

## Repository Relationships

- [Outbound destination policy](../../app/Security/OutboundUrlPolicy.php)
- [Preview controller and restricted HTTP client](../../app/Http/Controllers/PreviewController.php)
- [API routes](../../routes/api.php)
- [Fake-HTTP feature test](../../tests/Feature/OutboundRequestSecurityTest.php)
- [Required quality gate](../../.github/workflows/quality.yml)

## What The Evidence Proves

It proves the tested endpoint derives its destination from trusted
configuration rather than caller-controlled absolute URLs.

## What It Does Not Prove

It does not cover every way a hostname, redirect, or proxy can change the final
destination. Those protections also belong in shared HTTP and deployment
configuration. The tests prove destination and path selection for this
endpoint, not every HTTP-client setting.

## Cross-Stack Translation

Apply the same destination policy to Django requests, Node fetch clients,
document processors, webhook callbacks, and AI tools that can reach a network.
