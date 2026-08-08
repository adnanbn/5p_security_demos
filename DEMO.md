# SECRETS-01: Synthetic Secret In Git History

This branch is an intentionally failing Security Masterclass fixture.
**Do not merge it.**

## Unsafe Change

The branch commits a harmless token matching the repository's custom canary
rule. Gitleaks fails even if a later commit deletes the visible file because
the value remains in Git history.

## Expected Evidence

- **Red gate:** `Security / Secret scanning`
- **Rule:** `masterclass-demo-canary`
- **Durable finding:** [`demos/SECRETS-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/SECRETS-01/expected-finding.md)
- **Secure baseline:** [`demos/SECRETS-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/SECRETS-01/README.md)

Other gates should remain green. Deleting a real credential is not containment:
revoke, rotate, deploy, verify, and investigate.

## Safety

The token is synthetic and grants no access.
