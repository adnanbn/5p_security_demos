# Demo Guide

This is a suggested path through the repository. Each example also works on its
own.

## 1. Confirm the Secure Version

```bash
composer install
php artisan test --display-warnings
vendor/bin/pint --test
```

All checks should pass on `main`.

## 2. Read the Incident

Open [`incidents/01-cross-user-access`](../incidents/01-cross-user-access/README.md)
and follow its reading order. The files move from the first report to the logs,
root cause, fix, and action items.

To recreate the generated files:

```bash
php artisan masterclass:replay
```

## 3. Compare Five Core Pull Requests

1. [`AUTHZ-01`](../demos/AUTHZ-01/README.md): a valid user opens another user's record.
2. [`SECRETS-01`](../demos/SECRETS-01/README.md): a test credential enters Git history.
3. [`DEPS-01`](../demos/DEPS-01/README.md): a locked package has a known vulnerability.
4. [`LOG-01`](../demos/LOG-01/README.md): application logs include complete request headers.
5. [`CI-01`](../demos/CI-01/README.md): a GitHub Action uses a moving version tag.

For each pull request:

1. Predict which check should fail.
2. Read the code change.
3. Read the first useful failure.
4. Compare it with `main`.
5. Read the demo's `expected-finding.md`.

## 4. Explore More Application Examples

- [`INPUT-01`](../demos/INPUT-01/README.md): changing server-owned fields.
- [`WEBHOOK-01`](../demos/WEBHOOK-01/README.md): replaying a valid webhook.
- [`SSRF-01`](../demos/SSRF-01/README.md): making the server request an unapproved URL.
- [`XSS-01`](../demos/XSS-01/README.md): rendering untrusted HTML in the browser.

## 5. Try AI-Assisted Review

Use the prompt in
[`ai-assisted-security-review.md`](ai-assisted-security-review.md) on one unsafe
branch. Verify every AI claim with the code, tests, scanner result, or official
documentation.

Unsafe demo branches are for learning only and must not be merged.
