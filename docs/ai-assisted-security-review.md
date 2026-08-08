# AI-Assisted Security Review

AI can make review faster, but an AI answer is still a suggestion until code,
tests, or trusted documentation support it.

## A Practical Flow

1. **Plan:** Start from one clear rule. Ask one session to name the expected
   behavior, failure cases, and tests.
2. **Implement:** Use a second session to implement the plan and run the tests.
3. **Review:** Give a fresh session the original rule and actual diff. Ask it to
   challenge assumptions and identify missing negative tests.
4. **Verify:** The engineer reads the diff, checks the cited evidence, and owns
   the decision.
5. **Repeat:** Required CI runs the selected tests and scanners before merge.

Different models may provide useful variety, but three confident answers are
still not evidence.

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

## Repository-Owned Instructions

This repository includes three layers of reusable guidance:

- [`AGENTS.md`](../AGENTS.md) contains the shared repository rules.
- [`mcp-security-review/SKILL.md`](../.agents/skills/mcp-security-review/SKILL.md)
  contains the repeatable security-review workflow.
- [`CLAUDE.md`](../CLAUDE.md) and
  [Copilot instructions](../.github/copilot-instructions.md) are small wrappers
  for tools that use their own instruction files.

Tool support and discovery paths differ. These files do not guarantee that
every AI client loads the same instructions. Keep the underlying checklist,
commands, evidence format, and safety rules consistent, then verify which files
each client actually uses.

MCP is optional. It can connect an AI client to an approved scanner or source
of context, but the MCP server and its permissions still need review. Direct
local commands and CI jobs are often simpler.

## Verify The Answer

1. Read the exact diff and dependency lockfile changes.
2. Run the proposed negative test.
3. Run the normal quality and security workflows.
4. Confirm any cited framework behavior in official documentation.
5. Record what is still unknown instead of asking the model for certainty.

## Practice

Run the prompt or the repository Skill against `demo/01-authz-cross-user`. The
important result is not whether the AI notices the bug. It is whether the team
can turn the claim into a repeatable two-user test and a reviewable fix.

Then try the [frontend and mobile cancellation exercise](../examples/angular-mobile/client-boundary.md).
Ask the reviewer to separate client input from server decisions and propose
proof for ownership, current policy, stale state, and safe retries.
