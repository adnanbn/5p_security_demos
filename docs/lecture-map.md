# Lecture Map

| Repository demonstration | Slides | Exact source |
| --- | --- | --- |
| Cross-account booking incident | 4-13 | [`incidents/01-cross-user-access`](../incidents/01-cross-user-access) |
| Vulnerable global lookup | 8, 11 | [`demo/01-authz-cross-user`](https://github.com/adnanbn/5p_security_demos/tree/demo/01-authz-cross-user) |
| Secure scoped query and policy | 8-10 | [`BookingController.php`](../app/Http/Controllers/BookingController.php), [`BookingPolicy.php`](../app/Policies/BookingPolicy.php) |
| Valid-non-owner feature test | 10-11 | [`BookingAuthorizationTest.php`](../tests/Feature/BookingAuthorizationTest.php) |
| Pull-request evidence pattern | 15 | [Pull request template](../.github/pull_request_template.md) |
| Synthetic secret canary | 16 | [`demo/02-secret-in-history`](https://github.com/adnanbn/5p_security_demos/tree/demo/02-secret-in-history) |
| Nested vulnerable dependency fixture | 17 | [`demo/03-vulnerable-dependency`](https://github.com/adnanbn/5p_security_demos/tree/demo/03-vulnerable-dependency) |
| Credential-safe logging rule | 18 | [`demo/04-sensitive-logging`](https://github.com/adnanbn/5p_security_demos/tree/demo/04-sensitive-logging) |
| CI workflow supply chain | 23 | [`demo/05-unpinned-action`](https://github.com/adnanbn/5p_security_demos/tree/demo/05-unpinned-action) |
| AI incident primary references | 24-26 | [`reference-links.md`](reference-links.md) |
| Frontend and mobile trust exercise | 27 | [`client-boundary.md`](../examples/angular-mobile/client-boundary.md) |
| Expensive fallback incident | 30-39 | [`incidents/02-expensive-rejection`](../incidents/02-expensive-rejection) |
| Vulnerable fallback middleware | 35 | [`scenario/incident-02-rejection-outage`](https://github.com/adnanbn/5p_security_demos/tree/scenario/incident-02-rejection-outage) |
| Before/after edge configuration | 36 | [`infrastructure/nginx`](../infrastructure/nginx) |
| Proposed structured event and alert | 38 | [`incidents/02-expensive-rejection`](../incidents/02-expensive-rejection) |
| Public communication exercise | 39 | [`public-communication-draft.md`](../incidents/02-expensive-rejection/public-communication-draft.md) |
| Security Upgrade PR | 41 | [`security-week-objective.md`](security-week-objective.md) |

The repository intentionally demonstrates that generic scanners cannot prove
object ownership. The valid-non-owner feature test expresses that product rule.

The GitHub links remain private until the repository release checklist is
completed. Keep the links in the shared deck only if the repository will be
released to participants.
