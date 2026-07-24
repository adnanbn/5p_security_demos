# Branch Catalog

`main` is the secure baseline. Every `demo/*` branch introduces one deliberate
failure. Every `scenario/*` branch represents a fuller incident condition.

| Branch | Expected red gate | Lecture connection |
| --- | --- | --- |
| [`demo/01-authz-cross-user`](https://github.com/adnanbn/5p_security_demos/tree/demo/01-authz-cross-user) | Laravel tests | Authentication versus authorization; generic scanners stay green |
| [`demo/02-secret-in-history`](https://github.com/adnanbn/5p_security_demos/tree/demo/02-secret-in-history) | Secret scanning | A committed credential must be revoked, not merely deleted |
| [`demo/03-vulnerable-dependency`](https://github.com/adnanbn/5p_security_demos/tree/demo/03-vulnerable-dependency) | OSV dependency scan | Known vulnerable dependency evidence |
| [`demo/04-sensitive-logging`](https://github.com/adnanbn/5p_security_demos/tree/demo/04-sensitive-logging) | Semgrep security rules | Logs can become the second leak |
| [`demo/05-unpinned-action`](https://github.com/adnanbn/5p_security_demos/tree/demo/05-unpinned-action) | Audit GitHub Actions | CI is an executable supply-chain boundary |
| [`scenario/incident-01-cross-user`](https://github.com/adnanbn/5p_security_demos/tree/scenario/incident-01-cross-user) | Laravel tests | First incident retrospective |
| [`scenario/incident-02-rejection-outage`](https://github.com/adnanbn/5p_security_demos/tree/scenario/incident-02-rejection-outage) | Rejection-path test | Second incident retrospective |

Do not merge these branches. Their draft pull requests are teaching fixtures.

## Demonstration Pattern

1. Open the draft pull request and predict which gate should fail.
2. Inspect only the first actionable failure.
3. Compare the branch with `main`.
4. Explain what the gate proves and what it cannot prove.
5. Never merge the branch.
