# INCIDENT-02 Review: Expensive Rejection

> [!IMPORTANT]
> This is a **completed synthetic teaching example**, not a record of a real
> organization, attack, benchmark, or customer incident. It uses the
> [flexible incident review template](../../docs/incident-review-template.md).
> The template is a prompt, not a mandatory process. The JSONL files are a
> deterministic sample, and the FPM and Postgres CSVs model a larger synthetic
> effect; read the evidence manifest before comparing values.

## 1. Incident Metadata

- **Incident ID:** INCIDENT-02
- **Title:** Expensive rejection makes the partner API unavailable
- **Status:** Resolved teaching scenario
- **Severity:** Not assigned; synthetic exercise
- **Started:** 10:41, when automated probing began
- **Detected:** 10:42 through modeled saturation signals
- **Contained:** 10:44 through edge blocks
- **Resolved:** 10:47 in the scenario; secure rejection behavior is on `main`
- **Services or assets:** Nginx edge, PHP-FPM workers, Laravel fallback route,
  Postgres connections, and credential-protected partner API
- **Review owner:** Partner API and platform owners
- **Evidence:** Files in this incident directory

## 2. Executive Summary

Public scrapers probed common secret, backup, debug, Git, and old PHP paths.
The probes did not obtain access and received `401` or `404`, yet valid partner
requests began timing out. Unknown paths reached Laravel's fallback route,
where custom denial-audit middleware performed database work and a synchronous
log write before returning each `404`. Edge containment reduced the active
load; the long-term correction moves cheap rejection forward, bounds denial
cost and evidence, and alerts on valid-customer impact rather than status codes
alone.

## 3. Impact and Scope

### Confirmed

- Legitimate partner requests timed out in the synthetic scenario.
- PHP-FPM active workers reached the configured maximum.
- The FPM listen queue and database connection wait increased.
- Probes targeted a high-cardinality set of non-product paths.
- The protected partner route continued to reject missing credentials.

### Suspected but Unconfirmed

- None is required to explain the modeled availability impact.

### Unknown

- Whether any credential or customer data was accessed outside this synthetic
  scenario; the evidence does not establish unauthorized access.
- Real production throughput, limits, and impact. The CSV values are modeled,
  not local benchmark measurements.
- Attacker identity or attribution.

The incident is an availability failure with incomplete security evidence, not
proof of a breach and not proof that no breach occurred.

## 4. Detection

- **First useful signals:** Worker saturation, FPM listen queue, database wait,
  valid partner timeouts, and high path cardinality.
- **Detection source:** Modeled infrastructure and request evidence.
- **Misleading surface signal:** The suspicious requests received correct-looking
  `401` and `404` responses.
- **Earlier signal that was missing:** An impact-based alert correlating denial
  rate and cost with valid partner failure.
- **Evidence limit:** Sampled JSONL rows must not be summed and compared directly
  with the modeled full-stream CSV rates.

## 5. Timeline

| Time | Observed fact or evidence | Decision or action | Owner |
| --- | --- | --- | --- |
| 10:40 | Partner traffic is normal and worker capacity is healthy. | Continue normal operation. | Service owner |
| 10:41 | Automated probes begin requesting common secret, backup, and debug paths. | Begin correlating path and source patterns. | Platform owner |
| 10:42 | PHP-FPM reaches maximum active workers; database waits and the listen queue rise. | Investigate capacity and request cost as competing hypotheses. | Incident responders |
| 10:43 | Legitimate partner requests time out. | Declare user-visible availability impact. | Incident owner |
| 10:44 | Edge blocks are added for probing paths and source patterns. | Reduce active harm with reversible containment. | Edge owner |
| 10:47 | Capacity recovers. | Investigate and remediate the application rejection path. | API and platform owners |

## 6. Five Hows: Causal Analysis

| Step | How was this possible? | Evidence | Condition or control gap |
| --- | --- | --- | --- |
| Impact | Valid partner requests timed out. | Modeled FPM queue, database wait, and incident timeline. | Shared workers and database connections were exhausted. |
| 1 | Rejected probes consumed those shared resources. | Sampled denial evidence and modeled saturation signals rise together. | A failed request did not have predictable bounded cost. |
| 2 | Unknown paths reached Laravel's fallback and performed a database read, cache write, and synchronous security-log write before `404`. | [`facilitator-findings.md`](facilitator-findings.md) and [PR #6](https://github.com/adnanbn/5p_security_demos/pull/6). | Durable denial auditing ran in the synchronous request path. |
| 3 | Common hostile paths were allowed through the permissive edge to application workers. | [Before-state Nginx configuration](../../infrastructure/nginx/permissive-api-before.conf). | Cheap rejection was not placed at the earliest practical layer. |
| 4 | Per-IP thinking did not address distributed low-volume sources, and every denial produced work. | High path diversity and contributing conditions. | Limits were not multidimensional or pressure-aware. |
| 5 | Alerts emphasized authentication outcomes rather than rejection cost and valid-customer impact. | Existing and proposed alert discussion. | Detection did not correlate denial behavior with shared-resource saturation. |

The causal chain is not "the API needed more servers." Additional capacity
could buy time, but unbounded work per rejected request would preserve the
failure mode and could increase pressure on Postgres.

## 7. Contributing Conditions

- **Technical design:** Synchronous database and logging work ran before an
  unknown-path `404`.
- **Edge configuration:** Common probes reached PHP-FPM and Laravel.
- **Rate limiting:** A single source dimension was insufficient for distributed
  low-volume traffic.
- **Observability:** Status codes looked correct while valid users were failing.
- **Evidence design:** Durable evidence was not sampled or degraded under
  pressure.
- **Response:** Scaling was plausible but would not identify or remove the
  expensive denial path.

## 8. Resolution and Recovery

### Immediate Containment

At 10:44, reversible edge blocks rejected common probing paths before they
reached application workers. Capacity recovered by 10:47 while responders
continued investigating.

### Remediation

- Keep Laravel's unknown-route fallback free of database work.
- Reject common sensitive paths at the edge where practical.
- Bound body size, headers, path handling, concurrency, and request rate.
- Apply limits by identity, route family, tenant, source, and system pressure
  where appropriate.
- Sample repetitive denials and preserve a representative structured event.

### Recovery

Restore normal partner traffic while watching valid request success, FPM queue,
worker saturation, database wait, and denial-path cost.

### Verification and Residual Risk

- [`PartnerApiSecurityTest`](../../tests/Feature/PartnerApiSecurityTest.php)
  proves that an unknown API path performs no database query.
- PR #6 deliberately makes the rejection-cost proof fail.
- The Nginx after-state and proposed alert are teaching designs and still need
  environment-specific validation before production use.
- Distributed traffic and new path families remain residual risks that require
  layered limits and impact-based monitoring.

## 9. Communication

| Audience | Confirmed facts they need | Decision or action they need | Owner | Next update |
| --- | --- | --- | --- | --- |
| Responders | Partner impact, queue and database pressure, sampled path evidence | Contain at edge and inspect denial cost | Incident owner | At each containment decision |
| Internal stakeholders | Partner API degradation and current evidence limits | Support mitigation and customer response | Service owner | Time-boxed update |
| Partners | Elevated errors, mitigation status, workaround if available, and next update | Decide whether to retry or use workaround | Communications owner | Explicit timestamp |
| Public or regulatory audience | Only confirmed impact and legally reviewed facts if required | Appropriate action for that audience | Designated owner | Per applicable process |

An appropriate first partner update is:

> We are investigating elevated errors affecting the partner API. Mitigations
> are in place, and our investigation into unauthorized access is ongoing; we
> will provide the next update at [time].

## 10. What Helped, What Hurt, and Where We Were Lucky

### Helped

- Edge containment was reversible and reduced active harm quickly.
- Request, FPM, and database evidence could be correlated.
- Valid partner failure prevented responders from treating denials as harmless.

### Hurt or Delayed the Response

- Correct-looking status codes created a false sense that controls were working
  safely.
- The denial path performed synchronous shared-resource work.
- Per-IP limiting and raw denial counts did not explain distributed behavior or
  customer impact.

### Luck That Should Become a Control

Responders found the relationship between hostile path diversity and resource
saturation. That relationship should become an owned alert and runbook.

## 11. Action Items

| ID | Risk or condition | Action | Type | Owner | Due | Verifiable proof | Gate, alert, or runbook | Status |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| AVAIL-01-A | Unknown-path denial touches shared data resources | Keep the Laravel fallback free of database work | Prevent | API owner | Before release | Unknown path produces `404` with zero queries | Laravel rejection-cost test | Complete on secure `main` |
| AVAIL-01-B | Common probes consume PHP workers | Validate and deploy cheap edge rejection for known-sensitive paths | Prevent | Edge owner | Environment-specific | Staging test confirms matching and acceptable false positives | Edge configuration review | Proposed teaching configuration |
| AVAIL-01-C | Repeated evidence writes can amplify load | Use structured sampling and graceful degradation for repetitive denials | Mitigate | Platform owner | Before production adoption | Load test keeps evidence bounded under pressure | Logging test and runbook | Proposed event design |
| AVAIL-01-D | Denial status hides valid-customer failure | Alert on partner success, FPM queue, database wait, path cardinality, and denial cost together | Detect | Service owner | Before production adoption | Synthetic exercise fires the alert and names a first action | Proposed alert and runbook | Proposed |
| AVAIL-01-E | One source dimension misses distributed traffic | Apply route-, identity-, tenant-, source-, and pressure-aware limits where appropriate | Prevent | API and platform owners | Threat-model dependent | Controlled test proves valid traffic retains capacity | Rate-limit tests and dashboard | Partially demonstrated |

## 12. Closure

- **Evidence required:** Cheap fallback, zero-query rejection test, recovered
  valid traffic, and an owned impact-based alert.
- **Open residual risk:** Edge patterns, thresholds, and capacity behavior must
  be validated in the real deployment environment.
- **Lesson:** A correct denial can still be insecure when producing it consumes
  unbounded shared work.

## 13. Evidence Appendix

- [Incident packet and reading order](README.md)
- [Evidence manifest](evidence-manifest.json)
- [Timeline](timeline.md)
- [Path frequency](path-frequency.csv)
- [Modeled PHP-FPM metrics](php-fpm-metrics.csv)
- [Modeled database metrics](database-metrics.csv)
- [Facilitator findings](facilitator-findings.md)
- [Proposed alert](proposed-alert.md)
- [Proposed denial event](proposed-denial-event.json)
- [Public communication draft](public-communication-draft.md)
- [AVAILABILITY-01 durable demo](../../demos/AVAILABILITY-01/README.md)
- [Deliberate failing PR #6](https://github.com/adnanbn/5p_security_demos/pull/6)
