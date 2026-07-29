# CI-01: Mutable GitHub Action

## Why This Exists

Workflow dependencies execute inside CI and can receive repository contents,
tokens, artifacts, and deployment access. A movable tag can resolve to
different code later without changing the workflow diff.

## Secure Baseline

All third-party Actions use reviewed full commit SHAs, human-readable version
comments, minimal token permissions, and bounded job timeouts.

## Intentional Failure

- **Branch:** `demo/05-unpinned-action`
- **Draft PR:** [PR #5](https://github.com/adnanbn/5p_security_demos/pull/5)
- **Expected red gate:** Audit GitHub Actions
- **Expected finding:** Zizmor reports an unpinned Action reference

## Reproduce Safely

```bash
zizmor .
```

## Evidence

- [Expected finding](expected-finding.md)
- [Workflow security gate](../../.github/workflows/workflow-security.yml)
- [Live draft PR](https://github.com/adnanbn/5p_security_demos/pull/5)

## What The Evidence Proves

It proves a workflow dependency is referenced through a mutable name instead
of an immutable commit.

## What It Does Not Prove

A full SHA does not prove the referenced code is trustworthy. Review,
permissions, isolation, and controlled updates remain necessary.

## Secure Response

Pin the reviewed commit, minimize permissions, review workflow changes as
executable supply-chain changes, and update pins through reviewed automation.

## Lecture Status

Core PR demonstration.
