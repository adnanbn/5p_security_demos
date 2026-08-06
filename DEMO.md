# SSRF-01: Caller-Selected Outbound Destination

This branch is an intentionally failing Security Masterclass fixture.
**Do not merge it.**

## Unsafe Change

The preview endpoint accepts an optional absolute `url` and prefers it over the
configured preview service. A valid authenticated caller can now make the
backend select a synthetic link-local destination.

## Expected Evidence

- **Red gate:** `Quality / Laravel tests`
- **Focused proof:** `OutboundRequestSecurityTest`
- **Durable finding:** [`demos/SSRF-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/SSRF-01/expected-finding.md)
- **Secure baseline:** [`demos/SSRF-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/SSRF-01/README.md)

Other gates should remain green. The failure is destination selection at a
trusted network boundary, which the fake-HTTP test expresses directly.

## Safety

Laravel fakes every HTTP destination and prohibits stray requests. The
link-local URL is assertion data; no network connection is attempted.
