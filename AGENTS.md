# Repository Instructions For AI Agents

This is a defensive security teaching repository. `main` contains the secure
baseline. Every `demo/*` branch deliberately removes one protection so an
expected check fails. Never merge a deliberate demo branch.

## Safety

- Use only the fictional users, credentials, hosts, logs, and requests already
  provided here.
- Do not probe production systems, public services, or third-party targets.
- Do not place real credentials, customer data, employer data, or private
  incident evidence in prompts, code, tests, logs, or pull requests.
- Do not merge, deploy, publish, or change repository visibility automatically.

## Working Method

1. Read the requirement, the actual diff, and the related demo README.
2. Name the data or service being protected and the actor making the request.
3. Identify where the server must authenticate, authorize, validate, limit, and
   record the action.
4. Add or run a focused denied-case test for product-specific rules.
5. Run the relevant scanners for secrets, dependencies, source patterns, and
   workflow changes.
6. Separate confirmed evidence from assumptions and remaining risk.

Use [the repository security-review skill](.agents/skills/mcp-security-review/SKILL.md)
for a repeatable review. A scanner finding is evidence about one narrow check,
not proof that the application is secure.

## Local Validation

```bash
composer check
composer audit --locked
semgrep scan --config .semgrep/security.yml --error --metrics=off app routes config examples
```

Use Gitleaks, OSV-Scanner, and Zizmor when they are available. Never display a
detected secret value.
