# CI-01 Expected Finding

- **Gate:** `Workflow Security / Audit GitHub Actions`
- **What the failure means:** a third-party Action uses a moving version label instead of a full
  commit SHA
- **Other checks:** application, secrets, dependencies, and Semgrep remain green

The tool wording may change. The important result is that the workflow does not
name one exact reviewed commit.
