# Repository Tour

This repository is a small defensive engineering lab, not a complete security
framework. It connects application rules, tests, CI gates, incident evidence,
and review habits in one place.

## 1. Start From Secure `main`

The Laravel booking API under `app/` is the executable reference. Its tests
under `tests/` prove selected product and security boundaries. Begin on `main`
before opening any deliberate failure branch.

## 2. Pick One Stable Demo ID

The [demo catalog](../demos/README.md) is the permanent index:

- `AUTHZ-01`, `INPUT-01`, `WEBHOOK-01`, `SSRF-01`, and `XSS-01` cover
  application boundaries.
- `SECRETS-01`, `DEPS-01`, `LOG-01`, and `CI-01` cover delivery and operational
  controls.
- `AVAILABILITY-01` connects secure rejection behavior to service reliability.

Each demo page names the risk, secure guard, proof, gate, deliberate regression,
and durable expected finding.

## 3. Compare Proof With Automation

Application-specific tests can express rules that a generic scanner cannot
infer. Scanners are still valuable for repeatable patterns such as exposed
credentials, known vulnerable dependencies, unsafe logging, raw HTML sinks,
and mutable CI dependencies.

The workflow definitions live under [`.github/workflows`](../.github/workflows/README.md).
Their live run pages may expire or move. Use the demo's `expected-finding.md` as
the lasting explanation of what the red gate is intended to catch.

## 4. Investigate Before Reading The Answer

The [incident index](../incidents/README.md) contains two synthetic cases:

- `INCIDENT-01`: an authenticated user crosses an ownership boundary.
- `INCIDENT-02`: hostile probing makes an expensive rejection path consume
  service capacity.

Read participant material first. Keep `facilitator-findings.md` closed until
the group has formed and tested hypotheses.

Incident artifacts are labeled by role. Generated logs are deterministic
synthetic evidence. Modeled metrics illustrate a production-scale effect and
are not measurements. Prompts guide discussion. Facilitator files reveal the
designed root cause.

## 5. Translate The Boundary

The [examples directory](../examples/README.md) shows how the same decisions
look in Django, Next.js, Angular, and mobile work. These are focused teaching
extracts, not standalone applications. The server still owns identity,
authorization, validation, and state changes.

## 6. Use Failure Branches Carefully

A deliberate branch changes one behavior so one expected gate turns red. It is
safe teaching material only because the data and findings are synthetic.

1. Predict the failed gate.
2. Read the diff.
3. Inspect the first actionable finding.
4. Compare with secure `main`.
5. State what the evidence proves and what it does not prove.

Never merge a deliberate failure branch.
