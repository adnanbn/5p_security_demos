# LOG-01 Expected Finding

- **Gate:** `Security / Semgrep security rules`
- **Rule:** `laravel-log-entire-request`
- **Semantic result:** application code passes an entire request header map to
  the logger
- **Unrelated gates:** behavior, dependency, secret, and workflow checks remain
  green

The finding identifies a risky data flow. A reviewer still decides which
individual fields are necessary, sensitive, and permitted.
