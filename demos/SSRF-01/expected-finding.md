# SSRF-01 Expected Finding

- **Gate:** `Quality / Laravel tests`
- **What the failure means:** the backend sends a request to a user-selected
  fictional internal address instead of the configured preview service
- **Safety:** Laravel's HTTP client is fully faked and stray requests are
  prohibited
- **Other checks:** secrets, dependencies, Semgrep, Composer, and workflow
  checks remain green

The test proves destination selection for this code path. Outbound network
rules remain a separate protection.
