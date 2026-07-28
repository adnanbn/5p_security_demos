# Security Week Objective

Identify one risk, one guard, one proof, and one gate. Implement at least one
meaningful improvement.

1. Choose one meaningful boundary involving user data, privileged actions,
   uploads, shared links, reports, payments, or service availability.
2. Write the risk as: "A [type of actor] could [unsafe action] because
   [missing or weak control]."
3. Describe the guard that belongs at the trusted boundary.
4. Name the proof that would show the unsafe behavior is blocked.
5. Name the repeatable CI/CD gate that should run before merge.
6. Implement at least one of those improvements in a focused pull request.
7. Record the remaining risk and the next step.

If repository access is limited, submit an issue or a short documented proposal
with the same four fields. The goal is a real improvement, not four unrelated
changes.

Work only in the mentorship project and authorized test environments. Never
probe production, third-party services, or real user data for this exercise.
