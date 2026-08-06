# XSS-01: Unsafe Client-Side HTML Rendering

## Why This Exists

React, Next.js, and Angular escape ordinary text rendering. The protection is
bypassed when code deliberately introduces a raw-HTML or trust-bypass API.
This can allow cross-site scripting (XSS), where untrusted content runs in a
user's browser.

## Developer Lesson

Treat API, CMS, and user content as text by default. Allow HTML only through a
reviewed sanitization and content policy.

## What Are We Protecting?

- **Data or service:** the user's browser session and page
- **Who supplies the content?** any API, CMS, or user that can affect displayed text
- **Where is it checked?** the frontend rendering code
- **What must not happen?** treating untrusted content as executable HTML

## Secure Baseline

The framework examples render a fictional comment through normal escaped text
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

The test input is inactive text and is never opened in a browser.

## Evidence

- [Expected finding](expected-finding.md)
- [Next.js secure rendering example](../../examples/nextjs/secure-comment.tsx)
- [Angular secure rendering example](../../examples/angular-mobile/secure-comment.component.ts)

## Repository Relationships

- [Local Semgrep policy](../../.semgrep/security.yml)
- [Security workflow](../../.github/workflows/security.yml)
- [Framework example index](../../examples/README.md)

## What The Evidence Proves

It proves that a scanned example contains one of the named raw-HTML patterns.

## What It Does Not Prove

It cannot determine whether every HTML value is controlled by an attacker,
whether HTML-cleaning code is correct, or whether browser security headers are
effective. The narrow rule can match comments or strings and can miss
project-specific wrapper functions.

## Secure Response

Render text as text and remove unnecessary bypasses. When HTML is truly
required, pass it through one reviewed HTML-cleaning function and keep browser
security headers as another layer.
