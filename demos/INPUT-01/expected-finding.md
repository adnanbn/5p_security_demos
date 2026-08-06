# INPUT-01 Expected Finding

- **Gate:** `Quality / Laravel tests`
- **What the failure means:** a logged-in owner changes at least one
  server-owned field by including it in an otherwise valid update request
- **Protected fields:** `reference`, `user_id`, `status`, and `private_notes`
- **Other checks:** secret, dependency, Semgrep, Composer, and workflow
  checks remain green

The test names the product rule. A generic `$request->all()` match alone cannot
determine which fields the caller is allowed to change.
