# DEPS-01: Vulnerable Dependency Evidence

This branch is an intentionally failing Security Masterclass fixture.
**Do not merge it.**

## Unsafe Change

The branch adds an isolated `package-lock.json` describing `lodash` 4.17.19.
OSV-Scanner discovers the nested lockfile and reports current advisory data for
that affected version.

## Expected Evidence

- **Red gate:** `Security / OSV dependency scan`
- **Fixture:** `fixtures/vulnerable-dependency/package-lock.json`
- **Durable finding:** [`demos/DEPS-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/DEPS-01/expected-finding.md)
- **Secure baseline:** [`demos/DEPS-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/DEPS-01/README.md)

Other gates should remain green. Advisory counts and severity labels can change
as vulnerability data is corrected; the durable result is that the locked
version is affected and needs triage.

## Safety

The package is represented only as lockfile evidence. It is never installed,
imported, or executed.
