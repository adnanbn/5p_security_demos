# WEBHOOK-01 Expected Finding

- **Gate:** `Quality / Laravel tests`
- **What the failure means:** the receiver processes the same valid event ID more than
  once after atomic insert-if-absent is replaced by an unconditional cache write
- **Safety:** the secret, request body, event ID, and clock are fictional test data
- **Other checks:** secret, dependency, static-analysis, Composer, and
  workflow checks remain green

A successful signature check is only one part of the receiver's protection.
