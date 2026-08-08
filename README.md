# 5% Security Demos

This repository contains practical security examples for software engineers.
The working application uses Laravel, but the security decisions apply to any
backend, frontend, or mobile stack.

The repository is intentionally small. Start with one risk, see the secure
code, then compare it with a pull request where one protection is removed.

## What Is Here

- Login and per-user access checks
- Tests that use two different users
- Protection for fields that only the server may change
- A credential-protected API with rate limiting
- Signed webhooks with time and replay checks
- Outbound requests limited to approved destinations
- Useful security logs with request IDs
- Checks for secrets, vulnerable packages, risky code, and GitHub Actions
- Small examples for Django, Next.js, Angular, and mobile applications
- One fictional incident with logs, questions, root cause, and action items
- A practical AI-assisted review guide

## Start Here

- [`docs/repository-tour.md`](docs/repository-tour.md) explains how the pieces fit.
- [`demos/README.md`](demos/README.md) lists the security demos.
- [`incidents/README.md`](incidents/README.md) contains the booking-access incident.
- [`docs/demo-guide.md`](docs/demo-guide.md) gives a short path through the examples.
- [`docs/scanner-cheatsheet.md`](docs/scanner-cheatsheet.md) explains what each check can catch.
- [`.github/pull_request_template.md`](.github/pull_request_template.md) shows
  how to document change, risk, proof, and the required check.
- [`examples/angular-mobile/client-boundary.md`](examples/angular-mobile/client-boundary.md)
  is the cancellation design-review exercise used in the session.
- [`.agents/skills/mcp-security-review/SKILL.md`](.agents/skills/mcp-security-review/SKILL.md)
  is a repository-owned, evidence-based AI review workflow.

## Local Setup

Requirements: PHP 8.3 or later, Composer, and SQLite.

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan test
```

The partner API expects a SHA-256 hash instead of a plain-text credential:

```bash
php -r "echo hash('sha256', 'your-local-demo-key'), PHP_EOL;"
```

Place the result in `PARTNER_API_KEY_HASH` in your local `.env`. Use only a
test value. SHA-256 is used here for a long, random API key. Passwords require
the framework's password hasher, which is intentionally slow and salted.

## Rebuild the Incident Files

```bash
php artisan masterclass:replay
```

This command recreates the fictional files in
`incidents/01-cross-user-access/`. A test confirms that the committed files
still match the generator.

## Safety

All users, records, credentials, hosts, and incident details are fictional.
The unsafe branches use harmless test data. Vulnerable package examples are
never installed, and outbound-request tests block real network calls.

The repository is private. Complete
[`docs/public-release-checklist.md`](docs/public-release-checklist.md) before
making it public.
