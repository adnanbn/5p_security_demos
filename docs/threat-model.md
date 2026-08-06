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

## Places Where Trust Changes

- Browser or mobile client to the server API
- Partner webhook sender to the server API
- Public internet to the web server and application
- Application to the database and logging system
- Application to approved outbound HTTP services
- API or CMS content to the browser rendering code
- Developer changes to GitHub Actions
- Package registries and third-party actions to CI

## Safety Constraints

- All users, bookings, domains, IP addresses, and credentials are fictional.
- Demo secrets use a custom canary pattern and grant no access.
- Vulnerable dependencies are isolated evidence and are never executed.
- Test traffic is small and targets only the local application.
- Webhook credentials and events are fictional test values.
- Outbound tests fake every URL and reject stray network requests.
- Client-side XSS test files are inactive source text and are never rendered.
- Incident evidence must never be replaced with employer or customer data.
