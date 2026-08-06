# XSS-01 Expected Finding

- **Gate:** `Security / Semgrep security rules`
- **Rule:** `frontend-untrusted-html-sink`
- **What the failure means:** a named raw-HTML or trust-bypass pattern appears in a
  scanned frontend example
- **Safety:** no browser executes the fictional content
- **Other checks:** application, secrets, dependencies, Composer, and workflow
  checks remain green

The finding is a review prompt. A human still determines data origin,
sanitization, and whether HTML rendering is justified.
