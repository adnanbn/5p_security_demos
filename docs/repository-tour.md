# Repository Tour

This is a small practice repository, not a complete security framework. It
connects code, tests, automated checks, logs, and incident review.

## 1. Start on `main`

The Laravel booking API in `app/` is the working example. The tests in `tests/`
show the expected behavior. Read the secure version before opening an unsafe
demo branch.

## 2. Choose One Demo

The [demo catalog](../demos/README.md) groups the examples:

- `AUTHZ-01`, `INPUT-01`, `WEBHOOK-01`, `SSRF-01`, and `XSS-01` cover application code.
- `SECRETS-01`, `DEPS-01`, `LOG-01`, and `CI-01` cover source control and delivery.

Every demo explains:

1. The risk.
2. The secure code.
3. The unsafe change.
4. The check that fails.
5. What that result proves and what it does not prove.

## 3. Compare Tests and Scanners

Tests can express rules that are specific to the application, such as “User B
must not read User A's booking.” Scanners can catch repeated patterns such as
secrets, known vulnerable packages, risky logging, raw HTML, and unsafe
workflow references.

Use both. Neither one replaces engineering review.

## 4. Explore the Incident

The [incident files](../incidents/README.md) describe one fictional case: a
logged-in user opened another user's booking.

The folder contains the report, timeline, logs, investigation questions, root
cause, and completed review. All investigation and answer files are clearly
labeled.

## 5. Apply the Same Ideas to Other Stacks

The [examples directory](../examples/README.md) shows the same decisions in
Django, Next.js, Angular, and mobile code. The syntax changes, but the core
rules stay the same: the server verifies identity, permission, input, and state
changes.

## 6. Use Unsafe Branches Carefully

Each demo branch removes one protection so a check fails.

1. Predict which check should fail.
2. Read the code change.
3. Read the first useful error.
4. Compare the change with `main`.
5. Explain what the result proves.

These branches contain teaching examples and must not be merged.

## 7. Reuse The AI Review Method

[`AGENTS.md`](../AGENTS.md) defines the shared repository rules. The
[`security-review Skill`](../.agents/skills/mcp-security-review/SKILL.md) turns
those rules into a repeatable review that can use local commands, CI, or an
approved MCP connection. Tool-specific instruction files stay small and point
back to the same reviewed method.
