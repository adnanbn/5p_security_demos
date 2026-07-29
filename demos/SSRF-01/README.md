# SSRF-01: Outbound Request Policy

## Why This Exists

When application code fetches a caller-provided URL, the backend becomes a
network client with access that may differ from the caller's. That can expose
internal, link-local, or privileged services.

## Developer Lesson

Prefer configured destinations and constrained paths over arbitrary URLs. Pair
application validation with redirect controls, timeouts, and infrastructure
egress policy.

## Asset And Trust Boundary

- **Protected asset:** internal network reachability and service identity
- **Actor:** an authenticated API caller
- **Trusted boundary:** the backend HTTP client
- **Forbidden behavior:** selecting an arbitrary outbound destination

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
- **Expected finding:** a user-supplied absolute URL selects a synthetic
  link-local destination

## Reproduce Safely

```bash
php artisan test --filter=OutboundRequestSecurityTest
```

## Evidence

- [Expected finding](expected-finding.md)
- Laravel HTTP-client assertions proving which synthetic host was selected

## Repository Relationships

- [Outbound destination policy](../../app/Security/OutboundUrlPolicy.php)
- [Preview controller and bounded HTTP client](../../app/Http/Controllers/PreviewController.php)
- [API routes](../../routes/api.php)
- [Fake-HTTP feature test](../../tests/Feature/OutboundRequestSecurityTest.php)
- [Required quality gate](../../.github/workflows/quality.yml)

## What The Evidence Proves

It proves the tested endpoint derives its destination from trusted
configuration rather than caller-controlled absolute URLs.

## What It Does Not Prove

It does not fully solve DNS rebinding, redirect revalidation, proxy behavior,
or cloud-network egress. Those controls belong in shared HTTP infrastructure
and deployment policy. The tests prove destination and path selection; they do
not pin every HTTP-client timeout or redirect option against future changes.

## Cross-Stack Translation

Apply the same destination policy to Django requests, Node fetch clients,
document processors, webhook callbacks, and AI tools that can reach a network.

## Lecture Status

Repository-only extension.
