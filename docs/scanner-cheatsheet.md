# Scanner Cheatsheet

| Question | Gate |
| --- | --- |
| Did a credential pattern enter Git history? | Gitleaks |
| Does a locked dependency have a known vulnerability? | Composer Audit and OSV-Scanner |
| Does source match a risky application pattern? | Local Semgrep rules |
| Are GitHub Actions mutable or over-privileged? | Zizmor |
| Does the booking enforce the ownership rule? | Laravel two-user feature test |
| Can an owner change server-owned fields? | Laravel protected-field feature test |
| Can a valid webhook be stale or replayed? | Laravel signed-request feature test |
| Can a caller select an outbound destination? | Laravel fake-HTTP feature test |
| Does frontend code introduce an explicit HTML sink? | Local Semgrep rules |

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

The outbound-request tests call `Http::preventStrayRequests()` and fake all
destinations. The synthetic link-local URL is assertion data, not a network
target.

Tool output and advisory counts can change. Use each demo's
`expected-finding.md` for the durable meaning of the gate.
