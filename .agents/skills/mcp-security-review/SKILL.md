---
name: mcp-security-review
description: Review a code change for application-security, data-handling, dependency, CI, and operational risks. Use for pull requests, diffs, security reviews, or when selecting focused tests and scanners. Works with direct local commands, CI, or approved MCP tool connections.
---

# Evidence-Based Security Review

Review the requirement and actual diff. Do not treat model agreement as proof.

## Safety Boundary

- Use only this repository and authorized test environments.
- Do not use production credentials, customer data, or private incident data.
- Prefer read-only access. Never merge, deploy, publish, or change visibility
  automatically.
- Treat MCP as a connection to tools, not as a security control. Review the MCP
  server, permissions, inputs, and outputs before use.

## Review Workflow

1. State what behavior changed and why.
2. Name the data or service, the actor, and the action being requested.
3. Trace where identity, permission, input, state, resource limits, and logging
   decisions are made.
4. Describe one realistic abuse or failure case in plain language.
5. Add or run the smallest test that attempts the denied action and verifies no
   protected state changed.
6. Run the narrow checks that match the diff.
7. Read the results and inspect the code. Record what remains unknown.

## Check Selection

- Application behavior: `php artisan test`
- PHP formatting: `vendor/bin/pint --test`
- PHP dependencies: `composer audit --locked`
- Secrets in Git history: `gitleaks git .`
- Supported dependency manifests: `osv-scanner scan source --recursive .`
- Repository source patterns: `semgrep scan --config .semgrep/security.yml --error --metrics=off app routes config examples`
- GitHub Actions: `zizmor .`

Do not run every tool without a reason. Choose checks that can answer a question
raised by the diff, then use required CI to repeat the important checks.

## Review Output

Report:

- **Change:** What behavior changed?
- **Risk:** How could it fail or be abused?
- **Evidence:** Which test, scanner result, or source supports the conclusion?
- **Gate:** Which check must pass before merge?
- **Remaining risk:** What did the available evidence not prove?

If there is no actionable finding, say so and name the tests or evidence gaps
that still remain.
