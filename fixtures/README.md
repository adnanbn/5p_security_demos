# Synthetic Security Fixtures

This directory is reserved for inert inputs used to prove a scanner or test
behavior. A fixture is evidence for a narrow lesson, not an application
dependency or an exploit.

## Safety Rules

- Use only synthetic credentials, identities, hosts, payloads, and package
  metadata.
- Never copy production logs, customer data, private incident details, or an
  active credential.
- Never install, import, execute, publish, or make a request from a vulnerable
  dependency fixture.
- Keep deliberately unsafe fixtures on the matching failure branch unless a
  harmless secure baseline belongs on `main`.
- Make the smallest fixture that produces the intended deterministic signal.
- Link the fixture from its demo README and durable `expected-finding.md`.

Live scanner output and advisory wording can change. The expected-finding
document should explain what the gate is meant to catch, why it matters, and
what it cannot prove.

`main` remains the secure baseline. Deliberate failure branches are teaching
artifacts and must never be merged.
