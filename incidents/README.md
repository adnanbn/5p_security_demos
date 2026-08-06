# Fictional Incident Lab

This folder contains one fictional incident. It uses no employer, customer, or
production data.

[`INCIDENT-01`](01-cross-user-access/README.md) follows a simple case: a
logged-in user opens another user's booking.

The incident includes:

- The original support report
- A timeline
- Fictional access and application logs
- Investigation questions
- The root cause and lessons
- A completed incident review with action items

The [incident review template](../docs/incident-review-template.md) is a
flexible guide. Teams can shorten, reorder, or skip sections that do not help
them learn and improve.

## File Labels

| Label | Meaning |
| --- | --- |
| Generated evidence | Fictional logs produced by the local replay command |
| Investigation material | The report, timeline, logs, and questions |
| Root cause and lessons | The designed cause, evidence limits, and fixes |
| Completed review | A worked example using the flexible template |

## Replay Locally

```bash
php artisan masterclass:replay
```

The replay output is fictional and produces the same files every time. Keep
real logs, credentials, customer records, and private incident details out of
this repository.
