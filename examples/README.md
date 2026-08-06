# Framework Translation Examples

These focused examples translate repository lessons to other stacks. They are
review aids, not complete applications.
Imports, schema, authentication setup, and surrounding framework code may be
omitted deliberately.

| Stack | Lessons | Entry point |
| --- | --- | --- |
| Django | Owner-limited lookup and valid non-owner test (`AUTHZ-01`) | [`django/README.md`](django/README.md) |
| Next.js | Server-owned identity and safe text rendering (`AUTHZ-01`, `XSS-01`) | [`nextjs/README.md`](nextjs/README.md) |
| Angular and mobile | Client trust boundaries and safe rendering (`AUTHZ-01`, `XSS-01`) | [`angular-mobile/README.md`](angular-mobile/README.md) |

## Shared Rules

- The server session or credential supplies identity.
- A client-provided identifier selects a resource, not its owner.
- Hidden buttons and client-side validation improve experience but do not
  authorize an action.
- Framework escaping is the default; raw-HTML APIs require explicit review and
  a focused test.
- Negative tests should use a valid user attempting a forbidden action.

The main risks, protections, tests, and automated checks live in the
[demo catalog](../demos/README.md). All identities, payloads, and hosts are
fictional. Deliberate failure branches must never be merged.
