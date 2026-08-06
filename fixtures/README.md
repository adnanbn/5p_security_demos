# Safe Security Test Files

This directory contains small, inactive test files used by scanners and tests.
They are not application dependencies or working exploits.

## Safety Rules

- Use only fictional credentials, identities, hosts, request bodies, and package
  metadata.
- Never copy production logs, customer data, private incident details, or an
  active credential.
- Never install, import, execute, publish, or make a request from a vulnerable
  dependency test file.
- Keep deliberately unsafe test files on the matching failure branch unless a
  harmless secure baseline belongs on `main`.
- Make the smallest test file that produces the expected result.
- Link the test file from its demo README and `expected-finding.md`.

Scanner output and vulnerability wording can change. The expected-finding
document explains what the check catches, why it matters, and what it cannot
prove.

`main` remains the secure baseline. Deliberate failure branches are teaching
examples and must never be merged.
