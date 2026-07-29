# Security Demo Catalog

This directory is the permanent entry point for the repository's teaching
demos. The secure implementation lives on `main`. A linked draft pull request
may deliberately regress one behavior so a single CI gate can demonstrate the
finding.

The demos are defensive engineering exercises, not exploit tooling. All data,
credentials, hosts, and requests are synthetic.

| ID | Lesson | Secure baseline | Unsafe variant |
| --- | --- | --- | --- |
| [`AUTHZ-01`](AUTHZ-01/README.md) | Authentication does not prove ownership | Owner-scoped query, policy, and two-user test | `demo/01-authz-cross-user`, PR #1 |
| [`SECRETS-01`](SECRETS-01/README.md) | Deleting a secret does not revoke it | History scanning and rotation response | `demo/02-secret-in-history`, PR #2 |
| [`DEPS-01`](DEPS-01/README.md) | Dependency findings require context and action | Locked dependencies and OSV scanning | `demo/03-vulnerable-dependency`, PR #3 |
| [`LOG-01`](LOG-01/README.md) | Logs can become a second exposure | Selected structured security fields | `demo/04-sensitive-logging`, PR #4 |
| [`CI-01`](CI-01/README.md) | CI dependencies execute trusted code | Full-SHA Action pins and minimal permissions | `demo/05-unpinned-action`, PR #5 |
| [`AVAILABILITY-01`](AVAILABILITY-01/README.md) | A denied request can still consume capacity | Cheap unknown-route fallback | `scenario/incident-02-rejection-outage`, PR #6 |
| [`INPUT-01`](INPUT-01/README.md) | Valid input is not automatically writable input | Validated allowlist of user-editable fields | [`demo/06-over-posting`](https://github.com/adnanbn/5p_security_demos/tree/demo/06-over-posting), [PR #8](https://github.com/adnanbn/5p_security_demos/pull/8) |
| [`WEBHOOK-01`](WEBHOOK-01/README.md) | A valid signature does not prevent replay | Signature, freshness, and idempotency checks | [`demo/07-webhook-replay`](https://github.com/adnanbn/5p_security_demos/tree/demo/07-webhook-replay), [PR #9](https://github.com/adnanbn/5p_security_demos/pull/9) |
| [`SSRF-01`](SSRF-01/README.md) | Outbound requests cross a network boundary | Configured destinations and outbound policy | [`demo/08-ssrf-outbound`](https://github.com/adnanbn/5p_security_demos/tree/demo/08-ssrf-outbound), [PR #10](https://github.com/adnanbn/5p_security_demos/pull/10) |
| [`XSS-01`](XSS-01/README.md) | Framework escaping can be bypassed deliberately | Render untrusted content as text | [`demo/09-unsafe-html`](https://github.com/adnanbn/5p_security_demos/tree/demo/09-unsafe-html), [PR #11](https://github.com/adnanbn/5p_security_demos/pull/11) |

## How To Read A Demo

1. Read the demo README on `main`.
2. Inspect the secure source and proof linked from that README.
3. Open the deliberate branch or draft PR.
4. Predict the expected red gate.
5. Inspect the semantic finding, then compare the branch with `main`.
6. Read what the evidence proves and what it cannot prove.

Do not merge a deliberate failure branch.
