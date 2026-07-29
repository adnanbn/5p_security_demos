# Demo Threat Model

## Assets

- Per-user booking data
- Server-owned booking state
- Partner API availability
- API credentials
- Trusted webhook state transitions
- Internal network reachability and outbound service identity
- Browser sessions and rendered content
- Security and audit evidence
- CI credentials and repository integrity

## Trust Boundaries

- Browser or mobile client to Laravel
- Partner webhook sender to Laravel
- Public internet to Nginx and PHP-FPM
- Laravel to the database and logging system
- Laravel to configured outbound HTTP services
- API or CMS content to the browser rendering sink
- Developer changes to GitHub Actions
- Package registries and third-party actions to CI

## Safety Constraints

- All users, bookings, domains, IP addresses, and credentials are synthetic.
- Demo secrets use a custom canary pattern and grant no access.
- Vulnerable dependencies are isolated evidence and are never executed.
- Traffic replay is bounded and targets only the local application.
- Webhook credentials and events are synthetic test values.
- Outbound tests fake every URL and reject stray network requests.
- Client-side XSS fixtures are inert source text and are never rendered.
- Incident evidence must never be replaced with employer or customer data.
