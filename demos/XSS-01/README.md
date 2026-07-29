# XSS-01: Unsafe Client-Side HTML Rendering

## Why This Exists

React, Next.js, and Angular escape ordinary text rendering. The protection is
bypassed when code deliberately introduces a raw-HTML or trust-bypass API.

## Developer Lesson

Treat API, CMS, and user content as text by default. Allow HTML only through a
reviewed sanitization and content policy.

## Asset And Trust Boundary

- **Protected asset:** the user's browser session and rendered page
- **Actor:** any source able to influence displayed content
- **Trusted boundary:** the client-side rendering sink
- **Forbidden behavior:** interpreting untrusted content as executable markup

## Secure Baseline

The framework examples render a synthetic comment through normal escaped text
binding. The local Semgrep rules scan example TypeScript alongside the Laravel
application.

## Intentional Failure

- **Branch:** `demo/09-unsafe-html`
- **Draft PR:** [PR #11](https://github.com/adnanbn/5p_security_demos/pull/11)
- **Expected red gate:** Semgrep security rules
- **Expected finding:** `frontend-untrusted-html-sink` identifies a deliberate
  raw-HTML or trust-bypass API

## Reproduce Safely

```bash
semgrep scan --config .semgrep/security.yml --error --metrics=off app routes config examples
```

The fixture is inert text and is never opened in a browser.

## Evidence

- [Expected finding](expected-finding.md)
- [Next.js secure rendering example](../../examples/nextjs/secure-comment.tsx)
- [Angular secure rendering example](../../examples/angular-mobile/secure-comment.component.ts)

## Repository Relationships

- [Local Semgrep policy](../../.semgrep/security.yml)
- [Security workflow](../../.github/workflows/security.yml)
- [Framework example index](../../examples/README.md)

## What The Evidence Proves

It proves one of the named lexical sink patterns entered a scanned example.

## What It Does Not Prove

It cannot determine whether every HTML value is attacker-controlled, whether a
sanitizer is correctly configured, or whether CSP and browser policy are
effective. The intentionally narrow rule can match comments or strings and can
miss project-specific wrapper APIs.

## Secure Response

Render text as text, remove unnecessary bypasses, sanitize through one reviewed
boundary when HTML is truly required, and keep CSP as defense in depth.

## Lecture Status

Repository-only extension.
