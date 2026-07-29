# INCIDENT-01 Review: Cross-User Booking Access

> [!IMPORTANT]
> This is a **completed synthetic teaching example**, not a record of a real
> organization or customer incident. It uses the
> [flexible incident review template](../../docs/incident-review-template.md).
> The template is a prompt, not a mandatory process. All identities, records,
> timestamps, and evidence in this packet are synthetic.

## 1. Incident Metadata

- **Incident ID:** INCIDENT-01
- **Title:** Cross-user booking access
- **Status:** Resolved teaching scenario
- **Severity:** Not assigned; synthetic exercise
- **Started:** 09:09, when the cross-account response was reproduced
- **Detected:** 09:09 by QA
- **Contained:** 09:34 by disabling the endpoint
- **Resolved:** Secure behavior implemented and tested on `main`
- **Service or asset:** Authenticated booking API and per-user booking data
- **Review owner:** Booking API owner
- **Evidence:** Files in this incident directory

## 2. Executive Summary

A QA tester opened booking `8412` as Account A, copied its URL, and received
the same booking after opening that URL while authenticated as Account B. Both
accounts were ordinary authenticated users; no password theft or login bypass
was required. The endpoint authenticated the caller but fetched the booking by
global identifier without enforcing ownership. The endpoint was disabled while
scope was investigated, then the secure path restored owner-scoped lookup, a
policy check, a valid-non-owner test, and structured authorization decisions.

## 3. Impact and Scope

### Confirmed

- Account B received a `200` response for booking `8412` after the URL was
  copied from Account A.
- Authentication succeeded for both synthetic actors.
- A cross-account confidentiality boundary failed.
- The behavior was repeatable in the QA scenario.

### Suspected but Unconfirmed

- Other authenticated users may have been able to request bookings they did not
  own while the unsafe path existed.

### Unknown

- Which actor received booking `8412` on each historical request.
- Whether booking `8412` belonged to the requesting actor in other requests.
- Which fields were serialized in historical responses.
- How many users, records, or requests could have exercised the path.

The supplied access logs cannot support a claim that only one record or user
was affected.

## 4. Detection

- **First signal:** QA reproduced a copied booking URL across two authenticated
  browser sessions.
- **Detection source:** Ordinary feature testing, not an automated security
  alert.
- **Actionable detail:** The account switch, booking identifier, response
  status, and reproduction steps.
- **Earlier proof that was missing:** A valid authenticated non-owner feature
  test.
- **Evidence gap:** Access logs did not connect actor, resource owner, and
  authorization decision.

## 5. Timeline

| Time | Observed fact or evidence | Decision or action | Owner |
| --- | --- | --- | --- |
| 09:06 | QA signs into synthetic Account A as actor 17. | Begin booking test. | QA |
| 09:07 | Account A opens booking `8412`. | Copy the booking URL. | QA |
| 09:08 | QA signs into synthetic Account B as actor 23 in a second browser. | Continue the same test across accounts. | QA |
| 09:09 | The copied `8412` URL returns `200` in Account B's browser. | Reproduce and preserve the steps. | QA |
| 09:21 | QA reports the repeatable cross-account response. | Begin incident triage. | QA and API owner |
| 09:34 | The endpoint is disabled. | Contain exposure while scope is investigated. | API owner |

## 6. Five Hows: Causal Analysis

| Step | How was this possible? | Evidence | Condition or control gap |
| --- | --- | --- | --- |
| Impact | Account B received Account A's booking. | QA report and repeated `200` for booking `8412`. | Per-user confidentiality was not enforced on the request. |
| 1 | The endpoint returned a booking found by its global numeric identifier. | Deliberate failure in [`AUTHZ-01`](../../demos/AUTHZ-01/README.md). | The data lookup did not begin from the authenticated actor's relationship. |
| 2 | Login succeeded, but no equivalent ownership or policy decision followed. | [`facilitator-findings.md`](facilitator-findings.md). | Authentication was treated as if it were authorization. |
| 3 | Existing proof covered the owner and anonymous caller, not a valid non-owner. | The deliberate branch makes the two-user tests fail. | The product boundary was not encoded in a negative test. |
| 4 | Generic scanners remained green because the code was syntactically valid and used no generic dangerous primitive. | [PR #1](https://github.com/adnanbn/5p_security_demos/pull/1). | CI could not infer the product-specific ownership rule. |
| 5 | Historical logs recorded requests and statuses without actor-to-resource authorization context. | Supplied edge and application logs. | Evidence could not answer scope questions quickly. |

The causal chain is not "QA used the wrong browser." Account switching exposed
a system condition that the backend was required to handle safely.

## 7. Contributing Conditions

- **Technical design:** Global lookup replaced owner-scoped lookup, and the
  explicit policy decision disappeared.
- **Testing and review:** No valid authenticated non-owner test carried the
  product rule.
- **Observability:** Logs lacked actor, resource, outcome, and stable reason
  code in one correlated authorization event.
- **Process:** Login on the route could create false confidence during review.
- **External conditions:** None are required to explain the synthetic incident.

## 8. Resolution and Recovery

### Immediate Containment

The endpoint was disabled at 09:34. This stopped the exposed path at the cost of
temporarily removing the feature.

### Remediation

- Restore lookup through the authenticated user's bookings.
- Retain a Laravel policy check as defense in depth.
- Return `404` for a missing or non-owned booking.
- Record a bounded authorization decision without booking contents.

### Recovery

Re-enable the endpoint only after the secure behavior and negative proof pass.

### Verification and Residual Risk

- The two-user feature test expects `404` and verifies that the protected
  reference is absent.
- The secure implementation records allowed and denied authorization outcomes.
- Historical scope remains unknown because the original evidence was
  insufficient.

## 9. Communication

| Audience | Confirmed facts they need | Decision or action they need | Owner | Next update |
| --- | --- | --- | --- | --- |
| Responders | Reproduction steps, affected route, evidence limits | Contain, preserve evidence, test the fix | Incident owner | At each containment or scope change |
| Internal stakeholders | Confirmed cross-account response and unknown historical scope | Support feature disablement and investigation | Incident owner | After containment |
| Customers | Only if real impact were confirmed; do not include private records | Understand affected feature and protective action | Communications owner | Time-boxed update |

Do not claim that only one user was affected or that no broader exposure
occurred when the logs cannot prove either statement.

## 10. What Helped, What Hurt, and Where We Were Lucky

### Helped

- QA tested across two valid accounts.
- The failure was simple to reproduce.
- The endpoint could be disabled quickly.

### Hurt or Delayed the Response

- The negative authorization case was missing before release.
- Generic scanners could not express the product rule.
- Logs could not connect actor, owner, resource, and decision.

### Luck That Should Become a Control

QA found the issue through ordinary testing. That discovery should become a
required two-user regression test rather than remain dependent on chance.

## 11. Action Items

| ID | Risk or condition | Action | Type | Owner | Due | Verifiable proof | Gate, alert, or runbook | Status |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| AUTHZ-01-A | Global lookup bypasses ownership | Restore actor-scoped lookup and retain policy enforcement | Prevent | Booking API owner | Before re-enable | Owner receives `200`; non-owner receives `404` | Laravel tests | Complete on secure `main` |
| AUTHZ-01-B | Product boundary is absent from CI | Add owner, anonymous, and valid-non-owner feature tests | Prevent | Booking API owner | Before re-enable | Focused test fails on PR #1 and passes on `main` | Required Laravel test job | Complete |
| AUTHZ-01-C | Logs cannot answer scope questions | Record request ID, actor, resource, outcome, and reason without booking contents | Detect | Platform and API owners | Before release | Structured allowed and denied events | Log contract test and alert design | Complete in demo |
| AUTHZ-01-D | Reviewers may equate login with permission | Add the review question: "What can a valid user do that they should not be able to do?" | Prevent | Engineering lead | Next review cycle | Question appears in PR guidance and review examples | PR review practice | Documented |

## 12. Closure

- **Evidence required:** Secure behavior, two-user regression test, and bounded
  authorization event.
- **Open residual risk:** Historical scope cannot be reconstructed from the
  supplied logs.
- **Lesson:** Authentication identifies the actor; authorization still has to
  protect the resource on every request.

## 13. Evidence Appendix

- [Incident packet and reading order](README.md)
- [Support report](support-report.md)
- [Timeline](timeline.md)
- [Evidence manifest](evidence-manifest.json)
- [Facilitator findings](facilitator-findings.md)
- [AUTHZ-01 durable demo](../../demos/AUTHZ-01/README.md)
- [Deliberate failing PR #1](https://github.com/adnanbn/5p_security_demos/pull/1)
