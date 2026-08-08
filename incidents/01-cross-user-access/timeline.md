# Timeline

- **09:06** - QA starts a controlled two-account test in staging.
- **09:09** - Account B receives Account A's booking data. QA preserves the steps.
- **09:21** - QA reports the repeatable cross-account response.
- **09:25** - The team confirms the same behavior in production with approved test accounts.
- **09:28** - The team declares a security incident and assigns an incident lead.
- **09:34** - The endpoint is disabled. Investigation and communication continue.
- **09:41** - The team confirms the missing ownership and authorization checks.
- **09:48** - The team chooses a tested fix-forward because the change is small and isolated.
- **10:05** - Staging verification passes: owner `200`, non-owner `404`, no protected data.
- **10:18** - The fix is deployed. The controlled production verification also passes.
- **10:22** - The endpoint is restored and the team monitors permission events.
- **10:35** - Historical scope remains unknown because the old logs lack actor and authorization details.
- **11:00** - The incident review assigns follow-up actions and records the communication decision.
