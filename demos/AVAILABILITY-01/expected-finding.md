# AVAILABILITY-01 Expected Finding

- **Gate:** `Quality / Laravel tests`
- **Semantic result:** the unknown-path query log is not empty
- **Observed teaching failure:** count users, check the database-backed cache,
  and insert the denial record
- **Response status:** the request still returns the correct `404`
- **Unrelated gates:** secrets, dependencies, Semgrep, Composer, and workflow
  checks remain green

The finding is request-cost evidence, not a production load benchmark.
