# Lecture Map

| Repository demonstration | Slide key | Exact source |
| --- | --- | --- |
| Cross-user booking evidence | `incident-cold-open` through `incident-uncertainty` | [`incidents/01-cross-user-access`](../incidents/01-cross-user-access) |
| Vulnerable global lookup | `incident-vulnerable-query` | [`demo/01-authz-cross-user`](https://github.com/adnanbn/5p_security_demos/tree/demo/01-authz-cross-user) |
| Scoped Eloquent query and policy | `secure-scoped-query`, `secure-framework-anchors` | [`BookingController.php`](../app/Http/Controllers/BookingController.php), [`BookingPolicy.php`](../app/Policies/BookingPolicy.php) |
| Two-user feature test | `testing-security-behavior`, `testing-two-user-example` | [`BookingAuthorizationTest.php`](../tests/Feature/BookingAuthorizationTest.php) |
| CI tests and scanner gates | `ci-pull-request-evidence` through `ci-scanner-limits` | [Quality](../.github/workflows/quality.yml), [security](../.github/workflows/security.yml), and [workflow security](../.github/workflows/workflow-security.yml) |
| Deliberately red gates | `ci-demo-playground` | [`docs/branch-catalog.md`](branch-catalog.md) |
| Vulnerable dependency fixture | `ai-supply-chain` | [`demo/03-vulnerable-dependency`](https://github.com/adnanbn/5p_security_demos/tree/demo/03-vulnerable-dependency) |
| Mutable action reference | `ai-supply-chain` | [`demo/05-unpinned-action`](https://github.com/adnanbn/5p_security_demos/tree/demo/05-unpinned-action) |
| AI-assisted review workflow | `ai-trust-model` | [`docs/ai-assisted-security-review.md`](ai-assisted-security-review.md) |
| Expensive denied-request evidence | `api-outage-cold-open` through `api-outage-reveal` | [`incidents/02-expensive-rejection`](../incidents/02-expensive-rejection) |
| Vulnerable rejection path | `api-outage-reveal` | [`scenario/incident-02-rejection-outage`](https://github.com/adnanbn/5p_security_demos/tree/scenario/incident-02-rejection-outage) |
| Nginx, rate limit, and cheap rejection | `api-outage-controls` | [`secure-api.conf`](../infrastructure/nginx/secure-api.conf), [`PartnerApiSecurityTest.php`](../tests/Feature/PartnerApiSecurityTest.php) |
| Structured security events | `observability-security-event` | [`SecurityEventRecorder.php`](../app/Security/SecurityEventRecorder.php) |
| Credential-safe logging | `observability-second-leak` | [`demo/04-sensitive-logging`](https://github.com/adnanbn/5p_security_demos/tree/demo/04-sensitive-logging) |
| Request IDs across evidence | `observability-correlation` | [`AssignRequestId.php`](../app/Http/Middleware/AssignRequestId.php) |
| Week-ahead objective | `week-ahead` | [`docs/security-week-objective.md`](security-week-objective.md) |

The repository intentionally demonstrates that generic scanners cannot prove
object ownership. The two-user feature test expresses that product rule.

The GitHub links remain private until the repository release checklist is
completed. Keep the links in the shared deck only if the repository will be
released to participants.
