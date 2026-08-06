# Scanner Cheatsheet

| Question | Gate |
| --- | --- |
| Did a credential pattern enter Git history? | Gitleaks |
| Does a locked dependency have a known vulnerability? | Composer Audit and OSV-Scanner |
| Does source match a risky application pattern? | Local Semgrep rules |
| Do GitHub Actions use moving versions or excessive permissions? | Zizmor |
| Does the booking enforce the ownership rule? | Two-user application test |
| Can an owner change server-owned fields? | Protected-field application test |
| Can a valid webhook be old or replayed? | Signed-request application test |
| Can a user select an outbound destination? | Fake-HTTP application test |
| Does frontend code use a raw-HTML API? | Local Semgrep rules |

## Important Limitation

A scanner can identify known vulnerabilities, credential patterns, and risky
code shapes. It cannot infer that a valid user must not read another user's
booking. The feature test is the security gate for that product rule.

## Local Commands

```bash
php artisan test
vendor/bin/pint --test
composer audit --locked
gitleaks git .
osv-scanner scan source --recursive .
semgrep scan --config .semgrep/security.yml --error --metrics=off app routes config examples
zizmor .
```

The outbound-request tests use Laravel's `Http::preventStrayRequests()` and fake
all destinations. The fictional internal URL is test data, not a network target.

Tool output and vulnerability counts can change. Each `expected-finding.md`
explains the important result in stable language.
