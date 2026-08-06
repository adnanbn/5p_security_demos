# Local Semgrep Policy

[`security.yml`](security.yml) contains a small, reviewable policy for risky
patterns used in the teaching demos. It is intentionally focused instead of
claiming broad vulnerability coverage.

The policy checks for:

- Logging an entire Laravel request payload or header collection (`LOG-01`).
- Reading environment values directly from application code instead of the
  framework configuration layer.
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
- Put the unsafe example only on its deliberate failure branch.
- Document what the failure means in the demo's `expected-finding.md`.
- Check for noisy matches before making the gate required.

The frontend rule looks for specific text patterns. It catches the named escape
hatches in this repository, but it may also match a comment or string and may
miss project-specific wrapper functions.

Semgrep identifies code shapes. It cannot infer product ownership,
the application's permission rules, whether a bug can be exploited, or every
data path. Treat a finding as a reason to review the code, not a final verdict.

All specimens are synthetic. Deliberate failure branches must never be merged.
