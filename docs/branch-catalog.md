# Branch Catalog

`main` is the secure baseline. Every `demo/*` branch introduces one deliberate
failure. Every `scenario/*` branch represents a fuller incident condition.

| Branch | Expected red gate | Lecture connection |
| --- | --- | --- |
| `demo/01-authz-cross-user` | Laravel tests | Authentication versus authorization |
| `demo/02-secret-in-history` | Secret scanning | Secrets are not configuration |
| `demo/03-vulnerable-dependency` | OSV dependency scan | Software supply chain |
| `demo/04-sensitive-logging` | Semgrep security rules | Logs can become the second leak |
| `demo/05-unpinned-action` | Audit GitHub Actions | CI is an executable trust boundary |
| `scenario/incident-01-cross-user` | Multiple application checks | First incident retrospective |
| `scenario/incident-02-rejection-outage` | Rejection-path test | Second incident retrospective |

Do not merge these branches. Their draft pull requests are teaching fixtures.
