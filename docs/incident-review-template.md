# Flexible Incident Review Template

> [!IMPORTANT]
> This is a guide, not a required process or a form that must always be completed
> in full. Use the smallest version that preserves the important facts,
> decisions, evidence limits, and follow-up work.

Keep sensitive evidence in an access-controlled location and link to it. Do not
copy customer data, credentials, or unnecessary exploit details into the review.

## 1. Status

- **Incident:**
- **Unsafe behavior began:** Known time or Unknown
- **Discovered:**
- **Confirmed in production:**
- **Declared:**
- **Contained:**
- **Service restored:**
- **Review owner:**
- **Current state:**

## 2. Summary

In three to five sentences:

- What happened?
- What was the user or business impact?
- How was the harm stopped?
- What is the current state?

## 3. Impact and Evidence

### Confirmed

- What does the evidence prove?
- Which users, data, services, or operations were affected?

### Possible but Not Confirmed

- What may have happened but is not yet proven?

### Unknown

- What can the available evidence not answer?

Missing evidence does not prove that there was no impact.

## 4. Detection

- **First signal:**
- **What made the report or alert useful:**
- **What should have detected it earlier:**
- **Evidence that was missing or too noisy:**

## 5. Timeline and Decisions

Use one timezone. Separate confirmed facts from guesses.

| Time | Confirmed fact | Decision or action | Owner |
| --- | --- | --- | --- |
| HH:MM |  |  |  |

## 6. How Was This Possible?

Ask how the incident became possible without reducing the answer to one person's
mistake. Use as many rows as useful. It does not need to be exactly five.

| Step | How was this possible? | Evidence | Missing protection |
| --- | --- | --- | --- |
| Impact | How did the user-visible or security impact happen? |  |  |
| Request or change | How did the request or change reach the unsafe path? |  |  |
| Guard | Which permission, validation, or isolation control was missing? |  |  |
| Test or review | Why did normal engineering checks not stop it? |  |  |
| Detection | Why was it not found or scoped sooner? |  |  |

## 7. Contain, Fix, Recover, and Communicate

- **Containment:** What stopped the ongoing harm? Why was this scope chosen?
- **Repair:** What permanent change removed the unsafe condition?
- **Restore proof:** Which staging and production checks proved safe behavior?
- **Monitoring:** Which signals were watched after restoration?
- **Communication:** Who needed an update, what did they need to do, and when was
  the next update?
- **Remaining uncertainty:** What still could not be proven?

Restoring the service and closing the incident are separate decisions.

## 8. Action Items

Prefer a few specific improvements over a long wish list.

| ID | Risk or problem | Action | Owner | Due | Proof | Status |
| --- | --- | --- | --- | --- | --- | --- |
| ACTION-01 |  |  |  |  |  | Open |

An action is not complete because code was written. Define the test, check,
alert, exercise, or review that proves the improvement works.

## 9. Closure

- **Service restored at:**
- **Communication decision:**
- **Remaining risk and approver:**
- **Open actions and follow-up date:**
- **Review approved by:**
- **Lessons shared with:**

The incident may close with open actions when the immediate risk is controlled,
the remaining risk is understood, and every action is tracked with an owner,
date, and proof.

## 10. Evidence

- Reports or tickets:
- Logs, traces, and queries:
- Relevant code changes and pull requests:
- Tests and CI runs:
- Dashboards or alerts:
- Communication decisions:
- Related incidents:

## Influences

This teaching template is informed by
[Google SRE postmortem guidance](https://sre.google/workbook/postmortem-culture/)
and the
[PagerDuty postmortem template](https://response.pagerduty.com/after/post_mortem_template/).
It is intentionally smaller and focused on decisions software engineers can
turn into verified changes.
