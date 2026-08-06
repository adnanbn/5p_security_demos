# AUTHZ-01: Cross-User Booking Access

This branch is an intentionally failing Security Masterclass fixture.
**Do not merge it.**

## Unsafe Change

The booking read endpoint loads a record globally by identifier and treats
authentication as authorization. The new booking update path remains secure;
only `show()` is deliberately vulnerable.

## Expected Evidence

- **Red gate:** `Quality / Laravel tests`
- **Focused proof:** `BookingAuthorizationTest`
- **Durable finding:** [`demos/AUTHZ-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/AUTHZ-01/expected-finding.md)
- **Secure baseline:** [`demos/AUTHZ-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/AUTHZ-01/README.md)

Other gates should remain green. Generic scanners cannot infer the product rule
that one valid user must not read another user's booking.

## Safety

All users, bookings, logs, and identifiers are synthetic test fixtures.
