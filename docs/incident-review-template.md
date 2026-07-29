# Flexible Incident Review Template

> [!IMPORTANT]
> **This is a flexible teaching aid, not a strict or mandatory template.**
> Adapt, reorder, combine, or omit sections based on the incident, organization,
> severity, and audience. It is not a compliance document, legal checklist,
> breach-notification decision tree, or substitute for your organization's
> incident-response process. Never delay containment or recovery to complete a
> document. Never paste credentials, customer records, private vulnerability
> details, or unnecessary personal data into it. Keep confirmed facts separate
> from hypotheses and leave unknowns explicit. Incidents rarely have one root
> cause, one linear chain, or exactly five causal steps. Keep the review
> blameless and evidence-based: improve systems and decisions rather than
> assigning fault to an individual.

## How to Use It

- Start during the incident only when writing does not interfere with response.
- Update facts, hypotheses, and decisions as evidence changes.
- Use the smallest set of sections that helps the team learn and act.
- Ask "How was this possible?" until the team finds actionable system
  conditions. Stop before the exercise becomes forced or speculative.
- Convert follow-up work into owned, trackable items with verifiable end states.
- Prepare a separate sanitized version if the review will be shared more
  broadly than the incident evidence.

---

## 1. Incident Metadata

- **Incident ID:**
- **Title:**
- **Status:** Investigating / Contained / Monitoring / Resolved
- **Severity:**
- **Started:**
- **Detected:**
- **Contained:**
- **Resolved:**
- **Services or assets involved:**
- **Incident owner:**
- **Responders and roles:**
- **Review date and facilitator:**
- **Restricted evidence location:**

## 2. Executive Summary

In three to five sentences:

- What happened?
- What was the user or business impact?
- How was it detected and contained?
- What is the current state?

## 3. Impact and Scope

### Confirmed

- **Users or accounts affected:**
- **Services or features affected:**
- **Availability impact and duration:**
- **Data or security impact:**
- **Business or support impact:**

### Suspected but Unconfirmed

- 

### Unknown

- 

Do not turn absence of evidence into a claim of no impact.

## 4. Detection

- **First signal or report:**
- **Detection source:** User / QA / alert / log review / external report / other
- **What made the signal actionable?**
- **What should have detected the condition earlier?**
- **Which evidence was missing or too noisy?**

## 5. Timeline

Use one timezone. Record facts and evidence, not reconstructed certainty.

| Time | Observed fact or evidence | Decision or action | Owner |
| --- | --- | --- | --- |
| HH:MM |  |  |  |

## 6. Five Hows: Causal Analysis

"Five Whys" is the familiar name for this family of analysis. This template
uses **How was this possible?** to keep the discussion close to system behavior
and away from personal blame.

Do not force exactly five rows. Branch when multiple conditions contributed.
Every answer should point to evidence or be labeled as a hypothesis.

| Step | How was this possible? | Evidence | Condition or control gap |
| --- | --- | --- | --- |
| Impact | How did the user-visible or security impact happen? |  |  |
| 1 | How did the request, change, or event reach that path? |  |  |
| 2 | How did preventive controls allow it? |  |  |
| 3 | How did testing or review miss it? |  |  |
| 4 | How did detection or evidence affect the response? |  |  |
| 5 | Which deeper system condition made recurrence plausible? |  |  |

## 7. Contributing Conditions

Capture multiple conditions rather than compressing the incident into one
"root cause."

- **Technical design:**
- **Testing and review:**
- **Deployment or configuration:**
- **Dependencies and supply chain:**
- **Observability and alerting:**
- **Operational process and ownership:**
- **Communication and coordination:**
- **External or environmental conditions:**

## 8. Resolution and Recovery

### Immediate Containment

- What reduced active harm?
- What was the tradeoff?
- How was containment verified?

### Remediation

- What changed in code, configuration, access, or process?
- Which unsafe condition was removed?

### Recovery

- How and when was normal service restored?
- What was monitored during recovery?

### Verification and Residual Risk

- Which test, query, metric, or review proves the intended behavior?
- What remains unknown or accepted?
- What would trigger renewed investigation?

## 9. Communication

| Audience | Confirmed facts they need | Decision or action they need | Owner | Next update |
| --- | --- | --- | --- | --- |
| Responders |  |  |  |  |
| Internal stakeholders |  |  |  |  |
| Customers or partners |  |  |  |  |
| Public or regulatory audience, if applicable |  |  |  |  |

Do not publish unverified attribution, exploitable detail, customer data, or a
claim such as "no breach" before the evidence supports it.

## 10. What Helped, What Hurt, and Where We Were Lucky

### Helped

- 

### Hurt or Delayed the Response

- 

### Luck That Should Become a Control

- 

## 11. Action Items

Prefer a small number of specific improvements over a long wish list.

| ID | Risk or condition | Action | Type | Owner | Due | Verifiable proof | Gate, alert, or runbook | Status |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| AI-01 |  |  | Prevent / Detect / Respond |  |  |  |  | Open |

An action item is not complete because code was written. Define the evidence
that will show the risk was reduced.

## 12. Closure

- **Review approved by:**
- **Follow-up date:**
- **Open residual risk and approver:**
- **Evidence required before closure:**
- **Lessons shared with:**

## 13. Evidence Appendix

Link evidence rather than copying sensitive material into this document.

- Logs and traces:
- Metrics and dashboards:
- Relevant changes and pull requests:
- Tests and CI runs:
- Customer or support reports:
- Communication artifacts:
- Related incidents:

## Influences

This teaching template is informed by the
[Google SRE postmortem guidance](https://sre.google/workbook/postmortem-culture/)
and the
[PagerDuty postmortem template](https://response.pagerduty.com/after/post_mortem_template/).
It is intentionally smaller, adaptable, and oriented toward application
developers.
