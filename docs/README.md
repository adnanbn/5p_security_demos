# Documentation

Use this page to find the right starting point.

| Goal | Start here |
| --- | --- |
| Understand the repository | [Repository tour](repository-tour.md) |
| Explore the examples in a useful order | [Demo guide](demo-guide.md) |
| Find a risk and its protection | [Security control catalog](control-catalog.md) |
| Investigate the booking-access incident | [Incident files](../incidents/README.md) |
| Run a simple incident review | [Incident review template](incident-review-template.md) |
| Find the unsafe branches and pull requests | [Branch catalog](branch-catalog.md) |
| Run checks locally | [Scanner cheatsheet](scanner-cheatsheet.md) |
| Review a change with AI | [AI-assisted security review](ai-assisted-security-review.md) |
| Review package and CI risks | [Supply-chain guide](supply-chain-hardening.md) |
| See the same ideas in other frameworks | [Framework examples](../examples/README.md) |
| Plan one practical improvement | [Security upgrade exercise](security-week-objective.md) |
| Review source material | [Reference links](reference-links.md) |
| Check readiness for a public release | [Public release checklist](public-release-checklist.md) |

## Important Rules

- `main` contains the secure examples.
- The demo branches are intentionally unsafe. They must not be merged.
- All users, credentials, hosts, requests, and incident details are fictional.
- A passing pipeline proves only that its configured checks passed.
- Each `expected-finding.md` explains what a failed check means in plain language.
