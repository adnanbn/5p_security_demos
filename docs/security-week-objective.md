# Security Week Objective

Find one risk. Add one guard. Prove it. Add one gate.

1. Choose one meaningful boundary involving user data, privileged actions,
   uploads, shared links, reports, payments, or service availability.
2. Write the risk as: "A [type of actor] could [unsafe action] because
   [missing or weak control]."
3. Add one application guard at the trusted boundary.
4. Add one negative automated test proving the unsafe behavior is blocked.
5. Add one relevant security check to the pull-request pipeline.
6. Submit one focused pull request with the risk, evidence, and remaining risk.

Work only in the mentorship project and authorized test environments. Never
probe production, third-party services, or real user data for this exercise.
