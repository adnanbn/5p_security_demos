# GitHub Actions Gates

The workflows make selected security expectations repeatable on pull requests
and on `main`. They are examples of practical gates, not a security
certification.

| Workflow | Gate | Demo connections |
| --- | --- | --- |
| [`quality.yml`](quality.yml) | Composer validation, formatting, and application tests | `AUTHZ-01`, `INPUT-01`, `WEBHOOK-01`, `SSRF-01` |
| [`security.yml`](security.yml) | Gitleaks, Composer Audit, Semgrep, and OSV-Scanner | `SECRETS-01`, `DEPS-01`, `LOG-01`, `XSS-01` |
| [`workflow-security.yml`](workflow-security.yml) | Zizmor review of GitHub Actions | `CI-01` |

## Baseline Practices

- Workflow permissions default to read-only.
- Third-party Actions are pinned to full commit SHAs.
- Checkout does not persist credentials unless a job explicitly needs them.
- Jobs have timeouts and pull-request runs use concurrency cancellation.
- Deliberate findings use fictional test files; dependency and workflow checks
  also inspect the repository's actual locked graph and configuration.

## Reading A Deliberate Failure

1. Start from the linked demo README on secure `main`.
2. Predict which check should fail.
3. Read the first useful error or log line.
4. Compare the branch with `main`.
5. Read the demo's `expected-finding.md`.

Live run URLs, messages, and vulnerability counts can change. The
expected-finding document explains the important result without depending on
one CI run.

Deliberate failure branches must never be merged. Green checks show that the
configured tests and scanners passed at that revision; they do not prove the
application is secure.
