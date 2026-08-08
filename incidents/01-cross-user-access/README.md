# INCIDENT-01: One User Opens Another User's Booking

A normal logged-in user can open another user's booking by copying its URL into
a second signed-in account. This incident separates login from permission and
shows the limits of incomplete logs.

Everything in this directory is fictional.

## Reading Order

1. [`support-report.md`](support-report.md)
2. [`timeline.md`](timeline.md)
3. [`edge-access.jsonl`](edge-access.jsonl)
4. [`application.jsonl`](application.jsonl)
5. [`security-events.jsonl`](security-events.jsonl)
6. [`investigation-questions.md`](investigation-questions.md)
7. [`root-cause-and-lessons.md`](root-cause-and-lessons.md)
8. [`incident-review.md`](incident-review.md)

For a challenge, answer the investigation questions before reading the root
cause. For a quick review, read the files in order.

## What Each File Is

| Category | Files | What they contain |
| --- | --- | --- |
| Generated evidence | `edge-access.jsonl`, `application.jsonl`, `security-events.jsonl` | Fictional logs for request tracking and evidence limits |
| Context | `support-report.md`, `timeline.md` | The first report and the known sequence of events |
| Questions | `investigation-questions.md` | Short questions for the investigation |
| Root cause and lessons | `root-cause-and-lessons.md` | The cause, what the logs cannot prove, and the fixes |
| Completed review | `incident-review.md` | A worked example that follows the evidence, decisions, causes, and action items |

## Replay

```bash
php artisan masterclass:replay
```

The secure implementation and test are listed under
[`AUTHZ-01`](../../demos/AUTHZ-01/README.md). The deliberate failure branch is
teaching material and must never be merged.
