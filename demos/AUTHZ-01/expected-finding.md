# AUTHZ-01 Expected Finding

- **Gate:** `Quality / Laravel tests`
- **Semantic result:** the valid-non-owner request receives `200` instead of
  the required `404`
- **Proof:** the owner test remains valid while the two-user denial and
  indistinguishability tests fail
- **Unrelated gates:** secret, dependency, static-analysis, and workflow checks
  remain green

The exact line number and test-output formatting may change. The durable
finding is that authentication succeeded while object ownership was not
enforced.
