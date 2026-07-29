# Synthetic Incident Lab

These incident packets support discussion before the root cause is revealed.
They contain no employer, customer, or production data.

| ID | Scenario | Start here | Related demo |
| --- | --- | --- | --- |
| [`INCIDENT-01`](01-cross-user-access/README.md) | Authenticated cross-user booking access | Support report, timeline, then logs | [`incident-review.md`](01-cross-user-access/incident-review.md), [`AUTHZ-01`](../demos/AUTHZ-01/README.md) |
| [`INCIDENT-02`](02-expensive-rejection/README.md) | Hostile probes make rejection consume capacity | Manifest, timeline, sampled logs, then metrics | [`incident-review.md`](02-expensive-rejection/incident-review.md), [`AVAILABILITY-01`](../demos/AVAILABILITY-01/README.md) |

After participants investigate an incident and the facilitator reveals the
designed cause, use the
[flexible incident review template](../docs/incident-review-template.md) to
connect impact, timeline, causal analysis, resolution, communication, and owned
action items. The completed reviews are facilitator material and should not be
opened before the group forms its own hypotheses.

## Artifact Labels

| Label | Meaning |
| --- | --- |
| Generated incident evidence | Deterministic synthetic logs or summaries produced by the local replay command |
| Modeled metrics | Teaching values that illustrate a plausible service effect; they are not measurements from a test or production system |
| Participant material | Context and questions intended for investigation and discussion |
| Facilitator-only reveal | Designed root cause and corrective layers; keep closed until hypotheses have been discussed |
| Completed incident review | Synthetic post-investigation example using the flexible template; facilitator material |
| Proposed follow-up | Example alerting, event design, or communication created after the investigation; not incident evidence |

## Replay Locally

```bash
php artisan masterclass:replay 1
php artisan masterclass:replay 2 --requests=120 --seed=20260808
```

Replay output is synthetic and bounded. The incident README explains which
files can be compared and which values are modeled. Do not replace these files
with real logs, credentials, customer records, or private incident details.
