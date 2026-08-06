# LOG-01 Expected Finding

- **Gate:** `Security / Semgrep security rules`
- **Rule:** `laravel-log-entire-request`
- **What the failure means:** application code passes all request headers to
  the logger
- **Other checks:** behavior, dependency, secret, and workflow checks remain
  green

The finding identifies a risky data flow. A reviewer still decides which
individual fields are necessary, sensitive, and permitted.
