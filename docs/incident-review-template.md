# Flexible Incident Review Template

> [!IMPORTANT]
> **This is a flexible guide, not a required template.**
> Use only the sections that help your team learn and act. This is not legal or
> compliance advice, and it does not replace your organization's incident
> process. Stop the ongoing harm before writing a perfect document. Keep real
> credentials, customer records, and private security details out of shared
> copies. Separate confirmed facts from guesses, and improve the system instead
> of blaming one person.

## How to Use It

- Write during the incident only when it does not slow the response.
- Update facts, guesses, and decisions as evidence changes.
- Use the smallest set of sections that helps the team learn and act.
- Ask "How was this possible?" until the team finds something it can improve.
- Give every follow-up task an owner, due date, and clear proof of completion.
- Remove sensitive details before sharing the review more widely.

---

## 1. Incident Details

- **Incident ID:**
- **Title:**
- **Status:** Investigating / Contained / Monitoring / Resolved
- **Severity:**
- **Started:**
- **Detected:**
- **Contained:**
- **Resolved:**
- **Services or data involved:**
- **Incident owner:**
- **Responders and roles:**
- **Review date:**
- **Private evidence location:**

## 2. Short Summary

In three to five sentences:

- What happened?
- What was the user or business impact?
- How was it detected and contained?
- What is the current state?

## 3. Impact

### Confirmed

- **Users or accounts affected:**
- **Services or features affected:**
- **Availability impact and duration:**
- **Data or security impact:**
- **Business or support impact:**

### Possible but Not Confirmed

- 

### Unknown

- 

Missing evidence does not prove that there was no impact.

## 4. How We Found It

- **First signal or report:**
- **Detection source:** User / QA / alert / log review / external report / other
- **What made the report useful?**
- **What should have detected the condition earlier?**
- **Which logs or data were missing or too noisy?**

## 5. Timeline

Use one timezone. Record known facts and evidence. Mark guesses clearly.

| Time | Observed fact or evidence | Decision or action | Owner |
| --- | --- | --- | --- |
| HH:MM |  |  |  |

## 6. Five Hows

"Five Whys" is the familiar name. This version asks **How was this possible?**
to keep the discussion focused on the system instead of blaming a person.

You do not need exactly five rows. Follow more than one path when needed. Link
each answer to evidence or mark it as a guess.

| Step | How was this possible? | Evidence | Missing protection |
| --- | --- | --- | --- |
| Impact | How did the user-visible or security impact happen? |  |  |
| 1 | How did the request, change, or event reach that path? |  |  |
| 2 | How did preventive controls allow it? |  |  |
| 3 | How did tests or review miss it? |  |  |
| 4 | How did detection or evidence affect the response? |  |  |
| 5 | What would allow the same problem to happen again? |  |  |

## 7. Other Factors

Most incidents have more than one cause. Record the important factors.

- **Technical design:**
- **Testing and review:**
- **Deployment or configuration:**
- **Dependencies and supply chain:**
- **Logs, metrics, and alerts:**
- **Operational process and ownership:**
- **Communication and coordination:**
- **External or environmental conditions:**

## 8. Stop, Fix, and Recover

### Stop the Ongoing Harm

- What reduced active harm?
- What was the tradeoff?
- How did the team verify that the harm stopped?

### Permanent Fix

- What changed in code, configuration, access, or process?
- Which unsafe condition was removed?

### Recovery

- How and when was normal service restored?
- What was monitored during recovery?

### Verification and Remaining Risk

- Which test, query, metric, or review proves the intended behavior?
- What remains unknown or accepted?
- What would trigger renewed investigation?

## 9. Communication

| Audience | Confirmed facts they need | Decision or action they need | Owner | Next update |
| --- | --- | --- | --- | --- |
| Responders |  |  |  |  |
| Internal stakeholders |  |  |  |  |
| Customers or partners |  |  |  |  |
| Public or regulators, if needed |  |  |  |  |

Do not publish guesses about who caused the incident, instructions that make
the bug easier to exploit, customer data, or claims that the evidence cannot
support.

## 10. What Helped, What Hurt, and Where We Were Lucky

### Helped

- 

### Hurt or Delayed the Response

- 

### Luck That Should Become a Control

- 

## 11. Action Items

Prefer a small number of specific improvements over a long wish list.

| ID | Risk or problem | Action | Type | Owner | Due | Proof | Test, alert, or guide | Status |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| AI-01 |  |  | Prevent / Detect / Respond |  |  |  |  | Open |

Writing code is not enough. Define the test, alert, or review that proves the
improvement works.

## 12. Closure

- **Review approved by:**
- **Follow-up date:**
- **Remaining risk and approver:**
- **Evidence required before closure:**
- **Lessons shared with:**

## 13. Evidence Links

Link evidence rather than copying sensitive material into this document.

- Logs and traces:
- Metrics and dashboards:
- Relevant changes and pull requests:
- Tests and CI runs:
- Customer or support reports:
- Communication:
- Related incidents:

## Influences

This teaching template is informed by the
[Google SRE postmortem guidance](https://sre.google/workbook/postmortem-culture/)
and the
[PagerDuty postmortem template](https://response.pagerduty.com/after/post_mortem_template/).
It is intentionally smaller, adaptable, and oriented toward application
developers.
