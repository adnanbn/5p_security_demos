# DEPS-01 Expected Finding

- **Gate:** `Security / OSV dependency scan`
- **What the failure means:** current OSV data reports at least one known vulnerability for the
  isolated `lodash@4.17.19` lockfile
- **Safety:** the dependency is not installed or executed
- **Other checks:** application, secret, Semgrep, Composer, and workflow checks
  remain green

The number and severity can change when the security database is updated.
