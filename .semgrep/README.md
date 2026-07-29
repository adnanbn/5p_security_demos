# Local Semgrep Policy

[`security.yml`](security.yml) contains a small, reviewable policy for risky
patterns used in the teaching demos. It is intentionally focused instead of
claiming broad vulnerability coverage.

The policy covers:

- Logging an entire Laravel request payload or header collection (`LOG-01`).
- Reading environment values directly from application code instead of Laravel
  configuration.
- Explicit frontend raw-HTML escape hatches used by `XSS-01`.

## Run Locally

Use the same paths configured in the Security workflow:

```bash
semgrep scan --config .semgrep/security.yml --error --metrics=off app routes config examples
```

## Maintaining A Rule

- Match the narrow unsafe shape used by the lesson.
- Give the finding an actionable message.
- Keep a secure example on `main`.
- Put the unsafe specimen only on its deliberate failure branch.
- Document the semantic result in the demo's `expected-finding.md`.
- Check for noisy matches before making the gate required.

The frontend rule is deliberately lexical. It catches the named escape hatches
in this teaching repository, but may also match text in a comment or string and
will miss custom wrapper APIs.

Semgrep identifies code shapes. It cannot infer product ownership,
authorization intent, exploitability, or complete data flow by itself. Treat a
finding as review evidence, not a verdict.

All specimens are synthetic. Deliberate failure branches must never be merged.
