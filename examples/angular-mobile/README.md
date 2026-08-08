# Angular And Mobile Examples

[`client-boundary.md`](client-boundary.md) is a review exercise for frontend and
mobile engineers.

## Decision Being Taught

The client can improve the experience, but it cannot prove identity,
permission, current state, refund amount, or that a retry is safe. The
[`cancellation exercise`](client-boundary.md) asks reviewers to separate client
input from server decisions and choose tests for ownership, time-based rules,
stale state, and duplicate requests. This extends the client-side view of
`AUTHZ-01`.

For `XSS-01`, use normal Angular interpolation for untrusted text. Bypassing
Angular sanitization or assigning raw HTML creates a security risk that needs
explicit review and a focused test.

## Review Questions

1. What can an older, modified, or scripted client send?
2. Which identity, permission, policy, and state decisions must the server make?
3. Does a valid non-owner request leave state unchanged?
4. Can a timeout retry repeat an important side effect?
5. Is untrusted content kept on the framework's escaped rendering path?

These are teaching extracts, not complete Angular or mobile applications. See
[`AUTHZ-01`](../../demos/AUTHZ-01/README.md) and
[`XSS-01`](../../demos/XSS-01/README.md) for the canonical lessons.
