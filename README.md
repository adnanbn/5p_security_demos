# 5% Security Masterclass Demos

Private teaching repository for the 5% Security Masterclass.

The executable example is a Laravel 13 booking API. It connects two fictional
incidents to secure coding, tests, CI gates, software supply-chain controls,
observability, and incident response.

## What Is Here

- Sanctum authentication and owner-scoped booking access
- Laravel policy and two-user authorization tests
- Credential-protected partner API with rate limiting
- Structured security events with correlation IDs
- Sensitive logging and serialization guards
- Deterministic evidence for both masterclass incidents
- GitHub Actions gates and isolated failing demonstration branches
- Short translations for Django, Next.js, Angular, and mobile teams
- AI-assisted security review and supply-chain hardening guides
- A security-focused pull-request template and week-ahead exercise

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

The partner API expects a SHA-256 hash, not a plaintext credential:

```bash
php -r "echo hash('sha256', 'your-local-demo-key'), PHP_EOL;"
```

Place the output in `PARTNER_API_KEY_HASH` in your local `.env`. Never commit
the plaintext key or a production credential.

## Replaying the Incidents

```bash
php artisan masterclass:replay 1
php artisan masterclass:replay 2 --requests=120 --seed=20260808
```

Evidence is generated under `incidents/`. Participant prompts and facilitator
findings are deliberately separate.

## Guided Demonstrations

- [`docs/demo-runbook.md`](docs/demo-runbook.md) - local incident and CI flow
- [`docs/branch-catalog.md`](docs/branch-catalog.md) - one deliberate failure per branch
- [`docs/ai-assisted-security-review.md`](docs/ai-assisted-security-review.md) - use AI without treating its output as trusted
- [`docs/supply-chain-hardening.md`](docs/supply-chain-hardening.md) - connect packages, actions, credentials, and publishing
- [`docs/security-week-objective.md`](docs/security-week-objective.md) - one risk, guard, proof, and gate
- [`docs/reference-links.md`](docs/reference-links.md) - primary sources used by the lecture

## Safety

Everything in this repository is synthetic. The demo branches contain only
harmless canary secrets and non-executed vulnerable dependency fixtures.

This repository is private. Do not change its visibility until
[`docs/public-release-checklist.md`](docs/public-release-checklist.md) has been
completed intentionally.
