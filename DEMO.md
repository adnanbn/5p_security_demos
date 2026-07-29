# AVAILABILITY-01: Expensive Rejection Path

This branch is an intentionally failing Security Masterclass scenario.
**Do not merge it.**

## Unsafe Change

Only the unknown-route fallback receives denial middleware that performs
database reads, a durable write, and synchronous security logging. Every request
still returns the correct `404`, but hostile repetition can consume shared
workers, database connections, and logging throughput.

## Expected Evidence

- **Red gate:** `Quality / Laravel tests`
- **Focused proof:** unknown-path query-log assertion
- **Durable finding:** [`demos/AVAILABILITY-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/AVAILABILITY-01/expected-finding.md)
- **Incident packet:** [`incidents/02-expensive-rejection`](https://github.com/adnanbn/5p_security_demos/tree/main/incidents/02-expensive-rejection)
- **Secure baseline:** [`demos/AVAILABILITY-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/AVAILABILITY-01/README.md)

Other gates should remain green. The failure is request-cost behavior, not a
production load benchmark or evidence of successful unauthorized access.

## Safety

The traffic, credentials, logs, and modeled service effects are synthetic.
