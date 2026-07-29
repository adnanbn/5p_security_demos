# DEPS-01: Vulnerable Dependency Evidence

## Why This Exists

Dependency scanners identify packages associated with known advisories. They
provide evidence to triage, not automatic proof that an application is
exploitable.

## Secure Baseline

Composer metadata is validated, locked PHP dependencies are audited, and OSV
recursively scans supported manifests and lockfiles.

## Intentional Failure

- **Branch:** `demo/03-vulnerable-dependency`
- **Draft PR:** [PR #3](https://github.com/adnanbn/5p_security_demos/pull/3)
- **Expected red gate:** OSV dependency scan
- **Expected finding:** at least one current advisory applies to the isolated
  `lodash@4.17.19` lockfile fixture

The package is never installed or executed.

## Reproduce Safely

```bash
osv-scanner scan source --recursive .
```

## Evidence

- [Expected finding](expected-finding.md)
- [Security workflow](../../.github/workflows/security.yml)
- [Live draft PR](https://github.com/adnanbn/5p_security_demos/pull/3)

## What The Evidence Proves

The locked version matches current advisory data.

## What It Does Not Prove

It does not prove the vulnerable code is shipped, reachable, exploitable in
context, or free of compensating controls. Advisory counts and severities may
change as the database is updated.

## Secure Response

Confirm reachability and shipped artifacts, review the advisory, upgrade or
remove the package, test the result, and time-box any exception.

## Lecture Status

Core PR demonstration.
