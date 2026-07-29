# Branch Catalog

`main` is the secure baseline. Every `demo/*` branch introduces one deliberate
failure. The remaining `scenario/*` branch represents a fuller incident
condition.

| ID | Branch | Draft PR | Expected red gate | Lesson |
| --- | --- | --- | --- | --- |
| `AUTHZ-01` | [`demo/01-authz-cross-user`](https://github.com/adnanbn/5p_security_demos/tree/demo/01-authz-cross-user) | [PR #1](https://github.com/adnanbn/5p_security_demos/pull/1) | Laravel tests | Authentication versus authorization; generic scanners stay green |
| `SECRETS-01` | [`demo/02-secret-in-history`](https://github.com/adnanbn/5p_security_demos/tree/demo/02-secret-in-history) | [PR #2](https://github.com/adnanbn/5p_security_demos/pull/2) | Secret scanning | A committed credential must be revoked, not merely deleted |
| `DEPS-01` | [`demo/03-vulnerable-dependency`](https://github.com/adnanbn/5p_security_demos/tree/demo/03-vulnerable-dependency) | [PR #3](https://github.com/adnanbn/5p_security_demos/pull/3) | OSV dependency scan | Known vulnerable dependency evidence |
| `LOG-01` | [`demo/04-sensitive-logging`](https://github.com/adnanbn/5p_security_demos/tree/demo/04-sensitive-logging) | [PR #4](https://github.com/adnanbn/5p_security_demos/pull/4) | Semgrep security rules | Logs can become the second leak |
| `CI-01` | [`demo/05-unpinned-action`](https://github.com/adnanbn/5p_security_demos/tree/demo/05-unpinned-action) | [PR #5](https://github.com/adnanbn/5p_security_demos/pull/5) | Audit GitHub Actions | CI is an executable supply-chain boundary |
| `AVAILABILITY-01` | [`scenario/incident-02-rejection-outage`](https://github.com/adnanbn/5p_security_demos/tree/scenario/incident-02-rejection-outage) | [PR #6](https://github.com/adnanbn/5p_security_demos/pull/6) | Rejection-path test | A correct denial can still consume unsafe capacity |
| `INPUT-01` | `demo/06-over-posting` | Pending rollout | Laravel tests | Valid input is not automatically writable input |
| `WEBHOOK-01` | `demo/07-webhook-replay` | Pending rollout | Laravel tests | A valid signature does not prevent replay |
| `SSRF-01` | `demo/08-ssrf-outbound` | Pending rollout | Laravel tests | The backend must not fetch arbitrary caller-selected URLs |
| `XSS-01` | `demo/09-unsafe-html` | Pending rollout | Semgrep security rules | Raw HTML APIs bypass framework escaping |

Do not merge the demo or scenario branches. The draft pull requests are teaching
fixtures and intentionally remain red.

## Demonstration Pattern

1. Open the draft pull request and predict which gate should fail.
2. Inspect only the first actionable failure.
3. Compare the branch with `main`.
4. Explain what the gate proves and what it cannot prove.
5. Never merge the branch.
