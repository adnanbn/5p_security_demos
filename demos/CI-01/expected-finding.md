# CI-01 Expected Finding

- **Gate:** `Workflow Security / Audit GitHub Actions`
- **Semantic result:** a third-party Action uses a mutable tag instead of a full
  commit SHA
- **Unrelated gates:** Laravel, secrets, dependencies, and Semgrep remain green

The version label may change. The durable finding is the mutable trust
reference.
