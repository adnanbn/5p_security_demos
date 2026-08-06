# LOG-01: Sensitive Request Logging

This branch is an intentionally failing Security Masterclass fixture.
**Do not merge it.**

## Unsafe Change

The partner authentication middleware logs every request header after a
credential denial. That can copy authorization values, cookies, and tracing
metadata into a second system with different access and retention rules.

## Expected Evidence

- **Red gate:** `Security / Semgrep security rules`
- **Rule:** `laravel-log-entire-request`
- **Durable finding:** [`demos/LOG-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/LOG-01/expected-finding.md)
- **Secure baseline:** [`demos/LOG-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/LOG-01/README.md)

Other gates should remain green. Application behavior still works; the finding
is the newly introduced data flow into logs.

## Safety

All request values and credentials are synthetic test fixtures.
