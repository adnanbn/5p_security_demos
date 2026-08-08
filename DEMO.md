# XSS-01: Unsafe Client-Side HTML Rendering

This branch is an intentionally failing Security Masterclass fixture.
**Do not merge it.**

## Unsafe Change

The Next.js example replaces ordinary escaped text interpolation with
`dangerouslySetInnerHTML`. The component now treats its caller-provided
`body` as markup.

## Expected Evidence

- **Red gate:** `Security / Semgrep security rules`
- **Rule:** `frontend-untrusted-html-sink`
- **Durable finding:** [`demos/XSS-01/expected-finding.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/XSS-01/expected-finding.md)
- **Secure baseline:** [`demos/XSS-01/README.md`](https://github.com/adnanbn/5p_security_demos/blob/main/demos/XSS-01/README.md)

Other gates should remain green. The lexical rule is a review guardrail for
named escape hatches, not a complete XSS or data-flow analysis.

## Safety

The example is inert source text. It is not built, served, or opened in a
browser.
