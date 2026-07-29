# Synthetic Incident Lab

These incident packets support discussion before the root cause is revealed.
They contain no employer, customer, or production data.

| ID | Scenario | Start here | Related demo |
| --- | --- | --- | --- |
| [`INCIDENT-01`](01-cross-user-access/README.md) | Authenticated cross-user booking access | Support report, timeline, then logs | [`AUTHZ-01`](../demos/AUTHZ-01/README.md) |
| [`INCIDENT-02`](02-expensive-rejection/README.md) | Hostile probes make rejection consume capacity | Manifest, timeline, sampled logs, then metrics | [`AVAILABILITY-01`](../demos/AVAILABILITY-01/README.md) |

## Artifact Labels

| Label | Meaning |
| --- | --- |
| Generated incident evidence | Deterministic synthetic logs or summaries produced by the local replay command |
| Modeled metrics | Teaching values that illustrate a plausible service effect; they are not measurements from a test or production system |
| Participant material | Context and questions intended for investigation and discussion |
| Facilitator-only reveal | Designed root cause and corrective layers; keep closed until hypotheses have been discussed |
| Proposed follow-up | Example alerting, event design, or communication created after the investigation; not incident evidence |

## Replay Locally

```bash
php artisan masterclass:replay 1
php artisan masterclass:replay 2 --requests=120 --seed=20260808
```

Replay output is synthetic and bounded. The incident README explains which
files can be compared and which values are modeled. Do not replace these files
with real logs, credentials, customer records, or private incident details.
