# AUTHZ-01 Expected Finding

- **Gate:** `Quality / Laravel tests`
- **What the failure means:** the valid non-owner request receives `200` instead of
  the required `404`
- **Proof:** the owner test remains valid while the two-user denial and
  indistinguishability tests fail
- **Other checks:** secret, dependency, static-analysis, and workflow checks
  remain green

The exact line number and test output may change. The important result is that
login succeeded but the server did not enforce ownership.
