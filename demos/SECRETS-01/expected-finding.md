# SECRETS-01 Expected Finding

- **Gate:** `Security / Secret scanning`
- **Rule:** `masterclass-demo-canary`
- **What the failure means:** a fictional credential pattern exists in Git history
- **Safety:** the value grants no access and is redacted from CI output
- **Other checks:** application, dependency, static-analysis, and workflow
  checks remain green

The file path is useful. There is no need to display the test secret value.
