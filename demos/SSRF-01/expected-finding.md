# SSRF-01 Expected Finding

- **Gate:** `Quality / Laravel tests`
- **Semantic result:** the backend sends a request to a caller-selected
  synthetic link-local address instead of the configured preview service
- **Safety:** Laravel's HTTP client is fully faked and stray requests are
  prohibited
- **Unrelated gates:** secrets, dependencies, Semgrep, Composer, and workflow
  checks remain green

The test proves destination selection for this code path. Network egress policy
remains a separate defensive layer.
