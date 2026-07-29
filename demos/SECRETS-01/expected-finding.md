# SECRETS-01 Expected Finding

- **Gate:** `Security / Secret scanning`
- **Rule:** `masterclass-demo-canary`
- **Semantic result:** a synthetic credential pattern exists in Git history
- **Safety:** the value grants no access and is redacted from CI output
- **Unrelated gates:** application, dependency, static-analysis, and workflow
  checks remain green

The file path is useful context. The secret value itself is never required as
teaching evidence.
