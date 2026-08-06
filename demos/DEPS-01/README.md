# DEPS-01: Vulnerable Dependency Evidence

## Why This Exists

Dependency scanners identify packages with published security reports. A
finding needs investigation; it does not automatically prove the application
can be attacked through that package.

## Secure Baseline

Composer metadata is validated, locked PHP dependencies are audited, and OSV
recursively scans supported manifests and lockfiles.

## Intentional Failure

- **Branch:** `demo/03-vulnerable-dependency`
- **Draft PR:** [PR #3](https://github.com/adnanbn/5p_security_demos/pull/3)
- **Expected red gate:** OSV dependency scan
- **Expected finding:** at least one current advisory applies to the isolated
  small `lodash@4.17.19` lockfile

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

The locked version matches a current published security report.

## What It Does Not Prove

It does not prove the vulnerable code is included in the released application,
used by this code path, or exploitable here. Results may change as the security
database is updated.

## Secure Response

Check whether the package is shipped and used, read the security report,
upgrade or remove the package, test the result, and give any temporary
exception a clear owner and end date.
