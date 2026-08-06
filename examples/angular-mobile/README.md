# Angular And Mobile Examples

[`client-boundary.md`](client-boundary.md) is a review exercise for frontend and
mobile engineers.

## Decision Being Taught

The client can hide or disable a button, but a valid user can repeat and modify
the API request. The server must get identity from the login credential, check
permission for the requested record, validate the requested change, and prove
the denial with a negative test. This is the client-side view of
`AUTHZ-01`.

For `XSS-01`, use normal Angular interpolation for untrusted text. Bypassing
Angular sanitization or assigning raw HTML creates a security risk that needs
explicit review and a focused test.

## Review Questions

1. What can an older, modified, or scripted client send?
2. Which decision must the server repeat?
3. Does a valid non-owner request leave state unchanged?
4. Is untrusted content kept on the framework's escaped rendering path?

These are teaching extracts, not complete Angular or mobile applications. See
[`AUTHZ-01`](../../demos/AUTHZ-01/README.md) and
[`XSS-01`](../../demos/XSS-01/README.md) for the canonical lessons.
