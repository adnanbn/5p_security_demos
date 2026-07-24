# Demo Threat Model

## Assets

- Per-user booking data
- Partner API availability
- API credentials
- Security and audit evidence
- CI credentials and repository integrity

## Trust Boundaries

- Browser or mobile client to Laravel
- Public internet to Nginx and PHP-FPM
- Laravel to the database and logging system
- Developer changes to GitHub Actions
- Package registries and third-party actions to CI

## Safety Constraints

- All users, bookings, domains, IP addresses, and credentials are synthetic.
- Demo secrets use a custom canary pattern and grant no access.
- Vulnerable dependencies are isolated evidence and are never executed.
- Traffic replay is bounded and targets only the local application.
- Incident evidence must never be replaced with employer or customer data.
