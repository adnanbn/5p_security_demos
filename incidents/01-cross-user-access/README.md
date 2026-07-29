# INCIDENT-01: Cross-User Booking Access

An ordinary authenticated user can retrieve another user's booking by changing
the identifier in the URL. The exercise asks the group to separate
authentication from authorization and decide what can be proven from incomplete
logs.

Everything in this directory is synthetic.

## Participant Reading Order

1. [`support-report.md`](support-report.md)
2. [`timeline.md`](timeline.md)
3. [`edge-access.jsonl`](edge-access.jsonl)
4. [`application.jsonl`](application.jsonl)
5. [`security-events.jsonl`](security-events.jsonl)
6. [`participant-prompts.md`](participant-prompts.md)

Do not open [`facilitator-findings.md`](facilitator-findings.md) until the group
has discussed containment, scope, missing evidence, and a regression test.

## What Each File Is

| Category | Files | Interpretation |
| --- | --- | --- |
| Generated incident evidence | `edge-access.jsonl`, `application.jsonl`, `security-events.jsonl` | Deterministic synthetic telemetry for correlation and evidence-limit discussion |
| Participant context | `support-report.md`, `timeline.md` | Generated scenario narrative, not independent telemetry |
| Participant prompts | `participant-prompts.md` | Questions for the investigation |
| Facilitator-only reveal | `facilitator-findings.md` | Designed root cause, evidence limits, and corrective layers |
| Modeled metrics | None | This incident does not use modeled infrastructure metrics |

## Replay

```bash
php artisan masterclass:replay 1
```

The secure implementation and proof are cataloged under
[`AUTHZ-01`](../../demos/AUTHZ-01/README.md). The deliberate failure branch is
teaching material and must never be merged.
