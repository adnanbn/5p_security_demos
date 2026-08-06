# AUTHZ-01: Cross-User Booking Authorization

## Why This Exists

Application code often authenticates a caller and then loads a record by a
global identifier. That proves who the caller is, not whether the caller may
read that record.

## Developer Lesson

Limit data access by owner and keep a two-user test that tries the forbidden
request.

## What Are We Protecting?

- **Data:** per-user booking data
- **Who sends the request?** a valid logged-in user
- **Where is access checked?** the server API, implemented here with Laravel
- **What must not happen?** reading another user's booking

## Secure Baseline

[`BookingController`](../../app/Http/Controllers/BookingController.php) loads
the booking through the authenticated user's relationship and then applies the
[`BookingPolicy`](../../app/Policies/BookingPolicy.php). The
[`BookingAuthorizationTest`](../../tests/Feature/BookingAuthorizationTest.php)
proves logged-out, owner, valid non-owner, and missing-record behavior.

## Intentional Failure

- **Branch:** `demo/01-authz-cross-user`
- **Draft PR:** [PR #1](https://github.com/adnanbn/5p_security_demos/pull/1)
- **Expected red gate:** Laravel tests
- **Expected finding:** a valid non-owner receives `200` instead of the same
  `404` response used for a missing booking

Generic scanners remain green because they were never given the product rule.

## Reproduce Safely

```bash
php artisan test --filter=BookingAuthorizationTest
```

All users and bookings are generated test data.

## Evidence

- [Expected finding](expected-finding.md)
- [Incident 1 evidence](../../incidents/01-cross-user-access)
- [Live draft PR](https://github.com/adnanbn/5p_security_demos/pull/1)

## What The Evidence Proves

The focused request tests prove the current endpoint denies a valid logged-in
non-owner and does not return the protected booking.

## What It Does Not Prove

It does not prove every endpoint, background job, export, cache, or search path
uses the same ownership rule.

## Secure Response

Disable the unsafe route if needed, limit the query to the signed-in user's
records, keep the second permission check, add the negative test, and log the
permission result without logging record contents.

## Cross-Stack Translation

The same rule appears in the
[`examples`](../../examples/README.md) for Django, Next.js, Angular, and mobile.
