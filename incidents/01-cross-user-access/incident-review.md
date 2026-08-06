# INCIDENT-01 Review: One User Opens Another User's Booking

> [!IMPORTANT]
> This is a **completed fictional example**, not a real incident. It uses the
> [flexible incident review template](../../docs/incident-review-template.md).
> The template is a guide, not a required process. All users, records, times,
> and evidence in this folder are fictional.

## 1. Incident Metadata

- **Incident ID:** INCIDENT-01
- **Title:** Cross-user booking access
- **Status:** Resolved teaching scenario
- **Severity:** Not assigned; fictional exercise
- **Started:** 09:09, when the cross-account response was reproduced
- **Discovered:** 09:09 when QA reproduced the problem
- **Reported to the team:** 09:21
- **Contained:** 09:34 by disabling the endpoint
- **Resolved:** Secure behavior implemented and tested on `main`
- **Service or data:** Booking API and per-user booking data
- **Review owner:** Booking API owner
- **Evidence:** Files in this incident directory

## 2. Executive Summary

A QA tester opened booking `8412` as Account A and copied its URL. The same URL
opened while the tester was logged in as Account B. Both accounts were normal
users; no stolen password or login bypass was required.

The endpoint checked that the user was logged in, but it loaded the booking only
by its ID. It did not check who owned the booking. The team disabled the
endpoint, limited the query to the signed-in user's bookings, kept a second
server-side permission check, added a two-user test, and improved permission
logging.

## 3. Impact and Scope

### Confirmed

- Account B received a `200` response for booking `8412` after the URL was
  copied from Account A.
- Login succeeded for both fictional users.
- The rule that keeps each user's booking private failed.
- The behavior was repeatable in the QA scenario.

### Suspected but Unconfirmed

- Other authenticated users may have been able to request bookings they did not
  own while the unsafe path existed.

### Unknown

- Which user received booking `8412` on each earlier request.
- Whether booking `8412` belonged to that user in other requests.
- Which booking fields were returned in earlier responses.
- How many users, records, or requests could have exercised the path.

The supplied access logs cannot prove that only one record or user was affected.

## 4. Detection

- **First signal:** QA reproduced a copied booking URL across two logged-in
  browser sessions.
- **Detection source:** Ordinary feature testing, not an automated security
  alert.
- **Actionable detail:** The account switch, booking identifier, response
  status, and reproduction steps.
- **Earlier test that was missing:** A valid logged-in non-owner feature
  test.
- **Evidence gap:** Access logs did not connect the user, booking owner, and
  permission result.

## 5. Timeline

| Time | Observed fact or evidence | Decision or action | Owner |
| --- | --- | --- | --- |
| 09:06 | QA signs into fictional Account A as user 17. | Begin booking test. | QA |
| 09:07 | Account A opens booking `8412`. | Copy the booking URL. | QA |
| 09:08 | QA signs into fictional Account B as user 23 in a second browser. | Continue the same test across accounts. | QA |
| 09:09 | The copied `8412` URL returns `200` in Account B's browser. | Reproduce and preserve the steps. | QA |
| 09:21 | QA reports the repeatable cross-account response. | Start the investigation. | QA and API owner |
| 09:34 | The endpoint is disabled. | Stop more access while the team checks the possible impact. | API owner |

## 6. Five Hows: Causal Analysis

| Step | How was this possible? | Evidence | Missing protection |
| --- | --- | --- | --- |
| Impact | Account B received Account A's booking. | QA report and repeated `200` for booking `8412`. | The request did not enforce the per-user privacy rule. |
| 1 | The endpoint found a booking only by its numeric ID. | Unsafe example in [`AUTHZ-01`](../../demos/AUTHZ-01/README.md). | The query was not limited to the signed-in user's bookings. |
| 2 | Login succeeded, but the server did not check ownership or another permission rule. | [`root-cause-and-lessons.md`](root-cause-and-lessons.md). | Login was treated as permission. |
| 3 | Existing tests covered the owner and a logged-out user, but not a valid non-owner. | PR #1 makes the later two-user tests fail. | The privacy rule was missing from the tests before release. |
| 4 | Generic scanners stayed green because the code was valid and matched no common risky pattern. | [PR #1](https://github.com/adnanbn/5p_security_demos/pull/1). | A scanner did not know the application's ownership rule. |
| 5 | Old logs recorded requests and status codes without the user, booking owner, and permission result together. | Supplied edge and application logs. | The logs could not answer impact questions quickly. |

The causal chain is not "QA used the wrong browser." Account switching exposed
a missing server-side permission check.

## 7. Contributing Conditions

- **Technical design:** A global lookup replaced a query limited to the signed-in
  user, and the second permission check disappeared.
- **Testing and review:** No valid authenticated non-owner test carried the
  product rule.
- **Logging:** The logs did not record the user, booking, permission result, and
  reason under one request ID.
- **Process:** Login on the route could create false confidence during review.
- **External conditions:** None are required to explain this fictional incident.

## 8. Resolution and Recovery

### Stop the Ongoing Harm

The endpoint was disabled at 09:34. This stopped more access but temporarily
removed the feature.

### Permanent Fix

- Limit the lookup to the signed-in user's bookings.
- Keep a second server-side permission check. This demo uses a Laravel policy.
- Return `404` for a missing or non-owned booking.
- Log a small permission result without booking contents.

### Recovery

Re-enable the endpoint only after the secure behavior and negative proof pass.

### Verification and Remaining Risk

- The two-user feature test expects `404` and verifies that the protected
  reference is absent.
- The secure implementation records allowed and denied permission results.
- Historical scope remains unknown because the original evidence was
  insufficient.

## 9. Communication

| Audience | Confirmed facts they need | Decision or action they need | Owner | Next update |
| --- | --- | --- | --- | --- |
| Responders | Reproduction steps, affected route, and limits of the logs | Stop more access, preserve evidence, and test the fix | Incident owner | When the protection or impact estimate changes |
| Internal stakeholders | Confirmed cross-account response and unknown historical impact | Support feature disablement and investigation | Incident owner | After access is stopped |
| Customers | Only if real impact were confirmed; do not include private records | Understand affected feature and protective action | Communications owner | Time-boxed update |

Do not claim that only one user was affected or that no broader exposure
occurred when the logs cannot prove either statement.

## 10. What Helped, What Hurt, and Where We Were Lucky

### Helped

- QA tested across two valid accounts.
- The failure was simple to reproduce.
- The endpoint could be disabled quickly.

### Hurt or Delayed the Response

- The negative authorization case was missing at incident time; PR #1 is a
  later proof of the fix.
- Generic scanners could not express the product rule.
- Logs could not connect the user, owner, booking, and permission result.

### Luck That Should Become a Control

QA found the issue through ordinary testing. That discovery should become an
automated two-user test, and a required merge check where repository
enforcement is available, rather than remain dependent on chance.

## 11. Action Items

| ID | Risk or condition | Action | Type | Owner | Due | Verifiable proof | Gate, alert, or runbook | Status |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| AUTHZ-01-A | Global lookup bypasses ownership | Limit the lookup to the signed-in user and keep the second permission check | Prevent | Booking API owner | Before re-enable | Owner receives `200`; non-owner receives `404` | Application tests | Complete on secure `main` |
| AUTHZ-01-B | The privacy rule is absent from CI | Add owner, logged-out, and valid non-owner tests | Prevent | Booking API owner | Before re-enable | Focused test fails on PR #1 and passes on `main` | Automated application test; require it before merge when repository settings allow | Implemented as PR check; enforcement pending |
| AUTHZ-01-C | Logs cannot answer impact questions | Record request ID, user, booking ID, result, and reason without booking contents | Detect | Platform and API owners | Before release | Structured allowed and denied events | Permission-log test and alert design | Partial: event implemented; test and alert pending |
| AUTHZ-01-D | Reviewers may equate login with permission | Add the review question: "What can a valid user do that they should not be able to do?" | Prevent | Engineering lead | Next review cycle | Question appears in PR guidance and review examples | PR review practice | Documented |

## 12. Closure

- **Evidence required:** Secure behavior, two-user test, and a small permission
  log entry.
- **Remaining risk:** Historical impact cannot be reconstructed from the
  supplied logs.
- **Lesson:** Login identifies the user. The server must still check permission
  for every protected request.

## 13. Evidence Appendix

- [Incident packet and reading order](README.md)
- [Support report](support-report.md)
- [Timeline](timeline.md)
- [Evidence manifest](evidence-manifest.json)
- [Root cause and lessons](root-cause-and-lessons.md)
- [AUTHZ-01 durable demo](../../demos/AUTHZ-01/README.md)
- [Deliberate failing PR #1](https://github.com/adnanbn/5p_security_demos/pull/1)
