# Security Control Catalog

Each row connects a risk to a protection, a test, and an automated check.

| ID | Risk | Protection and proof | Automated check |
| --- | --- | --- | --- |
| [`AUTHZ-01`](../demos/AUTHZ-01/README.md) | A valid user reads another user's record | Owner-limited query, second permission check, and two-user test | Application tests |
| [`SECRETS-01`](../demos/SECRETS-01/README.md) | A credential enters Git history | Canary detection plus revoke-and-rotate response | Gitleaks |
| [`DEPS-01`](../demos/DEPS-01/README.md) | A locked dependency has a known vulnerability | Reviewed lockfile and isolated advisory evidence | Composer Audit and OSV-Scanner |
| [`LOG-01`](../demos/LOG-01/README.md) | Logs capture credentials or sensitive payloads | Selected structured fields and negative logging rules | Semgrep |
| [`CI-01`](../demos/CI-01/README.md) | A GitHub Action can change without a visible workflow change | Full commit references and minimal permissions | Zizmor |
| [`INPUT-01`](../demos/INPUT-01/README.md) | A request changes fields only the server should control | Explicit list of allowed fields and protected-field test | Application tests |
| [`WEBHOOK-01`](../demos/WEBHOOK-01/README.md) | A captured valid webhook is repeated | Signature, timestamp, and duplicate-event protection | Application tests |
| [`SSRF-01`](../demos/SSRF-01/README.md) | User input selects an internal or untrusted outbound destination | Approved destination and fake-HTTP negative tests | Application tests |
| [`XSS-01`](../demos/XSS-01/README.md) | Raw HTML APIs bypass framework escaping | Text rendering by default and review of raw-HTML calls | Semgrep |

## How to Use This Catalog

1. Name what needs protection.
2. Describe one action that must be blocked.
3. Put the protection where the server makes the decision.
4. Write the smallest test that tries the blocked action.
5. Run that test automatically before merge.

The demo branches are intentionally unsafe and must not be merged. GitHub may
change how a failed check is displayed. Each `expected-finding.md` explains the
important result without depending on a specific CI screen.

All evidence, credentials, identities, hosts, and incident data are fictional.
These examples cover selected protections. They do not prove that this or any
other application is fully secure.
