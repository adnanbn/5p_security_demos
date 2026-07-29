# AUTHZ-01: Cross-User Booking Authorization

## Why This Exists

Application code often authenticates a caller and then loads a record by a
global identifier. That proves who the caller is, not whether the caller may
read that record.

## Developer Lesson

Express ownership in the data-access path and keep a negative two-user test as
the repeatable proof.

## Asset And Trust Boundary

- **Protected asset:** per-user booking data
- **Actor:** a valid authenticated user
- **Trusted boundary:** the Laravel API
- **Forbidden behavior:** reading another user's booking

## Secure Baseline

[`BookingController`](../../app/Http/Controllers/BookingController.php) loads
the booking through the authenticated user's relationship and then applies the
[`BookingPolicy`](../../app/Policies/BookingPolicy.php). The
[`BookingAuthorizationTest`](../../tests/Feature/BookingAuthorizationTest.php)
proves anonymous, owner, valid-non-owner, and missing-record behavior.

## Intentional Failure

- **Branch:** `demo/01-authz-cross-user`
- **Draft PR:** [PR #1](https://github.com/adnanbn/5p_security_demos/pull/1)
- **Expected red gate:** Laravel tests
- **Expected finding:** a valid non-owner receives `200` where the product rule
  requires an indistinguishable `404`

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

The focused request tests prove the current endpoint denies a valid
authenticated non-owner and does not serialize the protected booking.

## What It Does Not Prove

It does not prove every endpoint, background job, export, cache, or search path
uses the same ownership rule.

## Secure Response

Contain the exposed route, scope the query to the actor, retain the policy, add
the negative test, and record the authorization decision without logging the
record contents.

## Cross-Stack Translation

The same rule appears in the
[`examples`](../../examples/README.md) for Django, Next.js, Angular, and mobile.

## Lecture Status

Core incident and PR demonstration.
