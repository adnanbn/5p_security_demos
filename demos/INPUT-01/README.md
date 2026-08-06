# INPUT-01: Over-Posting Server-Owned Fields

## Why This Exists

CRUD endpoints often validate types but still accept fields the caller should
never control. Ownership, approval state, price, role, and internal notes are
server decisions even when their values are syntactically valid.

## Developer Lesson

Validation answers whether input is well formed. An explicit writable-field
list of allowed fields answers whether the user may change it.

## What Are We Protecting?

- **Data:** booking ownership and internal state
- **Who sends the request?** the logged-in booking owner
- **Where is access checked?** the server update endpoint
- **What must not happen?** changing `reference`, `user_id`, `status`, or
  `private_notes`

## Secure Baseline

[`UpdateBookingRequest`](../../app/Http/Requests/UpdateBookingRequest.php)
allows only the user-editable title and start time. The controller maps those
validated fields explicitly. The
[`BookingUpdateSecurityTest`](../../tests/Feature/BookingUpdateSecurityTest.php)
proves protected fields remain unchanged.

## Intentional Failure

- **Branch:** `demo/06-over-posting`
- **Draft PR:** [PR #8](https://github.com/adnanbn/5p_security_demos/pull/8)
- **Expected red gate:** Laravel tests
- **Expected finding:** a valid owner can over-post server-owned fields

Generic scanners remain green because they do not know which fields only the
server may change.

## Reproduce Safely

```bash
php artisan test --filter=BookingUpdateSecurityTest
```

## Evidence

- [Expected finding](expected-finding.md)
- Fictional request and database checks in the feature test

## Repository Relationships

- [List of allowed update fields](../../app/Http/Requests/UpdateBookingRequest.php)
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
