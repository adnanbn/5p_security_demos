# SECRETS-01: Secret In Git History

## Why This Exists

A credential remains usable until it is revoked, even after the visible line is
deleted. Git history, forks, caches, CI logs, and developer clones may retain
the original value.

## Secure Baseline

The repository uses a custom harmless canary pattern and scans complete Git
history with Gitleaks. No real credential is committed.

## Intentional Failure

- **Branch:** `demo/02-secret-in-history`
- **Draft PR:** [PR #2](https://github.com/adnanbn/5p_security_demos/pull/2)
- **Expected red gate:** Secret scanning
- **Expected finding:** `masterclass-demo-canary` identifies the synthetic
  token in `fixtures/synthetic-secret.env`

## Reproduce Safely

```bash
gitleaks git .
```

The canary grants no access and exists only on the deliberate branch.

## Evidence

- [Expected finding](expected-finding.md)
- [Gitleaks policy](../../.gitleaks.toml)
- [Live draft PR](https://github.com/adnanbn/5p_security_demos/pull/2)

## What The Evidence Proves

It proves a credential-shaped value entered reachable history.

## What It Does Not Prove

It does not establish whether a real credential was active, used, copied, or
exposed outside the repository.

## Secure Response

Revoke, rotate, deploy the replacement, verify the old value no longer works,
investigate its use, then remove it from current code and history where
appropriate.

## Lecture Status

Core PR demonstration.
