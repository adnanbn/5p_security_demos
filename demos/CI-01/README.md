# CI-01: GitHub Action Uses a Moving Version

## Why This Exists

Workflow dependencies execute inside CI and can receive repository contents,
tokens, build files, and deployment access. A version label such as `v4` can
later point to different code without changing this repository.

## Secure Baseline

All third-party Actions use reviewed full commit hashes, readable version
comments, minimal token permissions, and job timeouts.

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

It proves a workflow dependency uses a version label that can later point to
different code instead of one exact commit.

## What It Does Not Prove

A full SHA does not prove the referenced code is trustworthy. Review,
permissions, isolation, and controlled updates remain necessary.

## Secure Response

Pin the reviewed commit, minimize permissions, treat workflow changes as code
that will run, and update pins through reviewed automation.
