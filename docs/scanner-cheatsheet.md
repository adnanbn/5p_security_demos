# Scanner Cheatsheet

| Question | Gate |
| --- | --- |
| Did a credential pattern enter Git history? | Gitleaks |
| Does a locked dependency have a known vulnerability? | Composer Audit and OSV-Scanner |
| Does source match a risky application pattern? | Local Semgrep rules |
| Are GitHub Actions mutable or over-privileged? | Zizmor |
| Does the booking enforce the ownership rule? | Laravel two-user feature test |

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
semgrep scan --config .semgrep/security.yml --error --metrics=off app routes config
zizmor .
```
