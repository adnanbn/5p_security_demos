# Security Control Catalog

Each row connects a practical risk to a guard, proof, and repeatable gate.
Follow the demo link for exact source locations and the durable expected
finding.

| ID | Risk | Secure guard and proof | Primary gate |
| --- | --- | --- | --- |
| [`AUTHZ-01`](../demos/AUTHZ-01/README.md) | A valid user reads another user's record | Owner-scoped lookup, policy, and valid-non-owner test | Laravel tests |
| [`SECRETS-01`](../demos/SECRETS-01/README.md) | A credential enters Git history | Canary detection plus revoke-and-rotate response | Gitleaks |
| [`DEPS-01`](../demos/DEPS-01/README.md) | A locked dependency has a known vulnerability | Reviewed lockfile and isolated advisory evidence | Composer Audit and OSV-Scanner |
| [`LOG-01`](../demos/LOG-01/README.md) | Logs capture credentials or sensitive payloads | Selected structured fields and negative logging rules | Semgrep |
| [`CI-01`](../demos/CI-01/README.md) | Mutable or over-privileged CI code executes in a trusted environment | Full-SHA Action pins and least-privilege permissions | Zizmor |
| [`AVAILABILITY-01`](../demos/AVAILABILITY-01/README.md) | Correctly denied requests still exhaust capacity | Cheap rejection path and bounded-cost regression test | Laravel tests |
| [`INPUT-01`](../demos/INPUT-01/README.md) | Valid but protected fields are mass assigned | Explicit writable-field allowlist and protected-field test | Laravel tests |
| [`WEBHOOK-01`](../demos/WEBHOOK-01/README.md) | A captured valid webhook is replayed | Signature, freshness, and atomic replay protection | Laravel tests |
| [`SSRF-01`](../demos/SSRF-01/README.md) | User input selects an internal or untrusted outbound destination | Configured destination policy and fake-HTTP negative tests | Laravel tests |
| [`XSS-01`](../demos/XSS-01/README.md) | Raw HTML APIs bypass framework escaping | Text rendering by default and review of explicit HTML sinks | Semgrep |

## How To Use The Catalog

1. Name the protected asset and trusted boundary.
2. Describe one forbidden behavior in plain language.
3. Find the guard closest to that boundary.
4. Run the smallest proof that exercises the forbidden behavior.
5. Keep the matching gate required before merge.

The deliberate branches are intentionally unsafe and must never merge. Live CI
annotations are useful during a demonstration but are ephemeral. The
`expected-finding.md` beside each demo is the durable semantic record.

All evidence, credentials, identities, hosts, and incident data are synthetic.
These controls demonstrate selected layers; they do not certify the repository
or any other application as secure.
