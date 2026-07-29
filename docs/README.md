# Documentation Index

This directory explains how to use the repository as a security teaching tool.
The shortest useful path is:

1. Read the [repository tour](repository-tour.md).
2. Choose a lesson from the [control catalog](control-catalog.md).
3. Read its canonical page in the [demo catalog](../demos/README.md).
4. Compare secure `main` with the linked deliberate failure branch.
5. Use the durable `expected-finding.md` before relying on a live CI page.

## Find What You Need

| Goal | Start here |
| --- | --- |
| Understand the repository | [Repository tour](repository-tour.md) |
| Find a risk, guard, proof, and gate | [Control catalog](control-catalog.md) |
| Run a teaching sequence | [Demo runbook](demo-runbook.md) |
| Investigate a synthetic incident | [Incident index](../incidents/README.md) |
| Review an incident without treating the format as law | [Flexible incident review template](incident-review-template.md) |
| Translate a lesson to another stack | [Framework examples](../examples/README.md) |
| Find deliberate branches and pull requests | [Branch catalog](branch-catalog.md) |
| Run scanners locally | [Scanner cheatsheet](scanner-cheatsheet.md) |
| Review with AI carefully | [AI-assisted security review](ai-assisted-security-review.md) |
| Discuss software supply-chain controls | [Supply-chain hardening](supply-chain-hardening.md) |
| Connect repository artifacts to the lecture | [Lecture map](lecture-map.md) |
| Plan one practical improvement | [Security week objective](security-week-objective.md) |
| Review source material | [Reference links](reference-links.md) |
| Evaluate a future public release | [Public release checklist](public-release-checklist.md) |

## Repository Conventions

- `main` is the secure baseline.
- Deliberate failure branches are teaching fixtures and must never be merged.
- All users, incidents, credentials, hosts, requests, and findings are synthetic.
- Live CI run URLs and annotations are ephemeral.
- Each demo's `expected-finding.md` is the durable description of the intended
  signal, its meaning, and its limits.
- A green pipeline is evidence for specific controls, not proof that the
  application is secure.

The repository is private until the public release checklist is completed
intentionally.
