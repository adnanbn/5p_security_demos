# INPUT-01: Over-Posting Server-Owned Fields

## Why This Exists

CRUD endpoints often validate types but still accept fields the caller should
never control. Ownership, approval state, price, role, and internal notes are
server decisions even when their values are syntactically valid.

## Developer Lesson

Validation answers whether input is well formed. An explicit writable-field
allowlist answers whether the caller may change it.

## Asset And Trust Boundary

- **Protected asset:** booking ownership and internal state
- **Actor:** the authenticated booking owner
- **Trusted boundary:** the Laravel update endpoint
- **Forbidden behavior:** changing `reference`, `user_id`, `status`, or
  `private_notes`

## Secure Baseline

[`UpdateBookingRequest`](../../app/Http/Requests/UpdateBookingRequest.php)
allows only the user-editable title and start time. The controller maps those
validated fields explicitly. The
[`BookingUpdateSecurityTest`](../../tests/Feature/BookingUpdateSecurityTest.php)
proves protected fields remain unchanged.

## Intentional Failure

- **Branch:** `demo/06-over-posting`
- **Draft PR:** created as part of the demo rollout
- **Expected red gate:** Laravel tests
- **Expected finding:** a valid owner can over-post server-owned fields

Generic scanners remain green because they do not know which booking fields are
product-owned.

## Reproduce Safely

```bash
php artisan test --filter=BookingUpdateSecurityTest
```

## Evidence

- [Expected finding](expected-finding.md)
- Synthetic request and database-state assertions in the feature test

## Repository Relationships

- [Update request allowlist](../../app/Http/Requests/UpdateBookingRequest.php)
- [Booking update controller](../../app/Http/Controllers/BookingController.php)
- [API routes](../../routes/api.php)
- [Protected-field feature test](../../tests/Feature/BookingUpdateSecurityTest.php)
- [Required quality gate](../../.github/workflows/quality.yml)

## What The Evidence Proves

The endpoint changes allowed fields while refusing or ignoring fields reserved
for server workflows.

## What It Does Not Prove

It does not prove every serializer, admin endpoint, import, or background job
uses the same writable-field policy.

## Cross-Stack Translation

Use explicit serializer fields in Django, explicit input schemas in Next.js,
and treat Angular or mobile form models as untrusted request data.

## Lecture Status

Repository-only extension.
