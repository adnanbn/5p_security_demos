# CI-01: Mutable GitHub Action

This branch is an intentionally failing Security Masterclass fixture.
**Do not merge it.**

## Unsafe Change

The quality workflow references `actions/checkout` by a movable major-version
tag. Workflow dependencies execute inside CI and may receive repository
contents, tokens, artifacts, and deployment access.

## Expected Evidence

- **Red gate:** `Workflow Security / Audit GitHub Actions`
- **Semantic finding:** mutable third-party Action reference
- **Durable finding:** [`demos/CI-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/CI-01/expected-finding.md)
- **Secure baseline:** [`demos/CI-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/CI-01/README.md)

Other gates should remain green. A full commit SHA makes the reviewed reference
immutable; it does not by itself prove the Action is trustworthy.

## Safety

The mutable reference exists only on this deliberately failing branch.
