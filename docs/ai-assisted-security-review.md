# AI-Assisted Security Review

AI can accelerate review, but its output is a hypothesis until the repository
provides evidence.

## Safe Review Contract

- Treat generated code and advice as an untrusted change.
- Treat the agent as a privileged automation identity.
- Give it only the repository, network access, and credentials the task needs.
- Do not paste production data, active credentials, private incident details,
  or customer records into prompts.
- Require a human owner for the merge and deployment decision.

## A Useful Review Prompt

```text
Review this diff as a security-minded engineer.

1. Name the protected asset and trust boundary.
2. Describe one action a valid user must not be able to perform.
3. Identify risky data flows, dependency changes, logging, and CI changes.
4. Propose the smallest negative test that would prove the boundary.
5. Separate facts visible in the diff from assumptions that need verification.
6. Do not add dependencies or change workflows without explaining the trust cost.
```

## Verify The Answer

1. Read the exact diff and dependency lockfile changes.
2. Run the proposed negative test.
3. Run the normal quality and security workflows.
4. Confirm any cited framework behavior in official documentation.
5. Record remaining risk instead of asking the model for certainty.

## Masterclass Exercise

Run the prompt against `demo/01-authz-cross-user`. The important result is not
whether the AI notices the bug. It is whether the team can turn the claim into
a deterministic two-user test and a reviewable fix.
