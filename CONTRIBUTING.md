# Contributing

This is a small teaching repository. The secure examples live on `main`, and
each `demo/*` branch deliberately removes one protection so a check fails.

## Before Proposing a Change

1. Read [`README.md`](README.md) and the README beside the example.
2. Use only fictional data, credentials, hosts, and incident evidence.
3. Keep the change focused on one lesson.
4. Add a test that proves the expected behavior, including a denied or failure
   case when the change affects permissions or trust.
5. Complete the pull request template in short, plain language.

Do not merge a `demo/*` branch. Its failure is part of the lesson.

## Review and Merge

Pull requests require review from `@adnanbn`. Automated checks answer narrow
questions; passing checks do not replace engineering review.

## Security Reports

The documented failures on `demo/*` branches are intentional. For any other
security concern, follow [`SECURITY.md`](SECURITY.md).
