# AI-Assisted Security Review

AI can make review faster, but an AI answer is still a suggestion until code,
tests, or trusted documentation support it.

## Safe Review Contract

- Treat generated code and advice as an untrusted change.
- Treat the AI tool like automation that may have powerful access.
- Give it only the repository, network access, and credentials the task needs.
- Do not paste production data, active credentials, private incident details,
  or customer records into prompts.
- Require a human owner for the merge and deployment decision.

## A Useful Review Prompt

```text
Review this diff as a security-minded engineer.

1. Name the data or service being protected and where the check belongs.
2. Describe one action a valid user must not be able to perform.
3. Identify risky data flow, package, logging, and CI changes.
4. Propose the smallest negative test that would prove the protection works.
5. Separate facts visible in the diff from assumptions that need verification.
6. Explain why any new package or workflow change needs to be trusted.
```

## Verify The Answer

1. Read the exact diff and dependency lockfile changes.
2. Run the proposed negative test.
3. Run the normal quality and security workflows.
4. Confirm any cited framework behavior in official documentation.
5. Record what is still unknown instead of asking the model for certainty.

## Practice

Run the prompt against `demo/01-authz-cross-user`. The important result is not
whether the AI notices the bug. It is whether the team can turn the claim into
a repeatable two-user test and a reviewable fix.
