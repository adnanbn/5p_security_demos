# Next.js Examples

This directory translates server permission and safe-rendering decisions
to a Next.js or React code review.

## Server-Owned Identity

[`route.ts`](route.ts) obtains identity from the server session, scopes the
database lookup by both booking ID and user ID, and selects only response fields
the caller may receive. This is the Next.js translation of `AUTHZ-01`.

## Safe Rendering

For `XSS-01`, render untrusted comments through normal JSX text interpolation.
Treat `dangerouslySetInnerHTML` as a security-sensitive exception that requires
reviewed sanitization and a focused test.

## Review Questions

1. Does identity come from trusted server context?
2. Does the query enforce ownership instead of trusting a body or route field?
3. Is the response limited to intended fields?
4. Is untrusted content rendered as text?
5. Is a valid non-owner or malicious-content case required in CI?

The files are teaching extracts, not a complete Next.js application. See
[`AUTHZ-01`](../../demos/AUTHZ-01/README.md) and
[`XSS-01`](../../demos/XSS-01/README.md) for the canonical lessons.
