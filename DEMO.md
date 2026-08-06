# INPUT-01: Over-Posting Server-Owned Fields

This branch is an intentionally failing Security Masterclass fixture.
**Do not merge it.**

## Unsafe Change

The booking update endpoint replaces an explicit writable-field allowlist with
`$request->all()`. The model permits mass assignment of fields used by trusted
server workflows, so a valid booking owner can now choose `reference`,
`user_id`, `status`, and `private_notes`.

## Expected Evidence

- **Red gate:** `Quality / Laravel tests`
- **Focused proof:** `BookingUpdateSecurityTest`
- **Durable finding:** [`demos/INPUT-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/INPUT-01/expected-finding.md)
- **Secure baseline:** [`demos/INPUT-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/INPUT-01/README.md)

Other gates should remain green. Generic scanners do not know which booking
fields belong to the caller and which belong to server workflows.

## Safety

The request, users, and bookings exist only in the in-memory test database.
