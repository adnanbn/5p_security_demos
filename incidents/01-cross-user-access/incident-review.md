# INCIDENT-01 Review: One User Opens Another User's Booking

> [!IMPORTANT]
> This is a fictional teaching example. The users, data, times, and evidence are
> not real. It follows the
> [flexible incident review template](../../docs/incident-review-template.md),
> which is a guide rather than a required process.

## 1. Status

- **Incident:** Cross-user booking access
- **Unsafe behavior began:** Unknown
- **Discovered in staging:** 09:09
- **Confirmed in production:** 09:25 with approved test accounts
- **Declared:** 09:28
- **Contained:** 09:34 by disabling the affected endpoint
- **Service restored:** 10:22 after staging and production verification
- **Review owner:** Booking API owner
- **Current state:** Service restored, review complete, follow-up actions tracked

## 2. Summary

QA copied a booking URL from Account A and opened it while signed in as Account
B. Account B received Account A's protected booking data. Both accounts had valid
logins. The failure was a missing permission check, not a login bypass.

The team confirmed the behavior with controlled accounts, disabled the affected
endpoint, fixed the ownership and authorization checks, verified the repair with
two accounts, restored the endpoint, and assigned follow-up work.

## 3. Impact and Evidence

### Confirmed

- A valid non-owner received another user's booking data.
- The behavior was reproducible in staging and production with controlled data.
- The endpoint loaded a booking by ID without checking its owner.

### Possible but Not Confirmed

- Other authenticated users may have reached bookings they did not own while the
  unsafe path existed.

### Unknown

- When the unsafe behavior first reached production.
- How many earlier users, requests, or records were affected.
- Which user made each earlier booking request.
- Which protected fields were returned in earlier responses.

The old logs contain response codes but not enough actor, owner, and permission
information. Missing evidence does not prove that there was no broader exposure.

## 4. Detection

- **First signal:** QA reproduced the copied URL with two valid accounts.
- **Useful evidence:** Account B received Account A's protected booking data.
- **Earlier protection that was missing:** A valid logged-in non-owner test.
- **Evidence gap:** The logs did not connect the actor, booking owner, and
  permission result under one request ID.

## 5. Timeline and Decisions

| Time | Confirmed fact | Decision or action | Owner |
| --- | --- | --- | --- |
| 09:09 | QA reproduces the cross-account response in staging. | Preserve the steps and report the issue. | QA |
| 09:25 | Controlled production accounts show the same leak. | Declare a security incident. | API owner |
| 09:28 | Production impact is confirmed; historical scope is unknown. | Assign an incident lead and begin containment and communication. | Incident lead |
| 09:34 | The unsafe behavior is isolated to one endpoint. | Disable that endpoint instead of the whole platform. | API owner |
| 09:41 | The team finds the missing ownership and authorization checks. | Keep containment active while preparing the repair. | API owner |
| 09:48 | The change is small, understood, and covered by a focused test. | Fix forward instead of rolling back. | Incident lead and API owner |
| 10:05 | Staging returns `200` for the owner and `404` for the non-owner. | Approve the production deployment. | QA and API owner |
| 10:18 | Controlled production verification passes with no protected data returned to the non-owner. | Approve endpoint restoration. | Incident lead |
| 10:22 | The endpoint is restored and permission events remain healthy. | Continue monitoring while the impact review finishes. | API and platform owners |
| 10:35 | Old logs cannot establish the historical start or full scope. | Record the limitation and make no unsupported claims. | Incident lead |
| 11:00 | Required communication and follow-up work have owners. | Complete the review and track the open actions. | Incident lead |

## 6. How Was This Possible?

| Step | How was this possible? | Evidence | Missing protection |
| --- | --- | --- | --- |
| Impact | Account B received Account A's booking. | Controlled two-account reproduction | Per-user privacy rule was not enforced. |
| Request | The endpoint loaded a booking by its global ID. | Authorization demo and code diff | Query was not limited to the signed-in user. |
| Guard | Login succeeded, but ownership and permission were not checked. | Root-cause review | Server-side authorization check was missing. |
| Test and review | Existing tests did not include a valid non-owner. Generic scanners did not know the product rule. | PR #1 and focused test | Negative authorization test was missing from CI. |
| Detection | Old logs recorded response codes without enough decision context. | Supplied access logs | Actor, owner, result, and reason were not connected. |

Authentication succeeded. Authorization never happened.

## 7. Contain, Fix, Recover, and Communicate

- **Containment:** Disable the affected endpoint. Keep the rest of the platform
  available because the unsafe behavior is isolated to one route.
- **Repair:** Limit the query to the signed-in user's bookings and keep a second
  server-side permission check.
- **Restore proof:** Owner receives `200`; valid non-owner receives `404`; the
  protected booking reference is absent; the deployed version is confirmed.
- **Monitoring:** Watch allowed and denied permission events and deployment
  health after restoration.
- **Communication:** Share confirmed facts, current containment, known limits,
  required action, and the next update. Do not guess at historical scope.
- **Remaining uncertainty:** The old logs cannot reconstruct the complete
  historical impact.

## 8. Action Items

| ID | Risk or problem | Action | Owner | Due | Proof | Status |
| --- | --- | --- | --- | --- | --- | --- |
| AUTHZ-01-A | A global lookup can bypass ownership. | Scope the query to the signed-in user and keep the second permission check. | Booking API owner | Before restore | Owner `200`; non-owner `404`; protected reference absent | Complete |
| AUTHZ-01-B | The ownership rule can disappear without failing CI. | Keep owner, logged-out, missing-record, and valid non-owner tests as required checks. | Booking API owner | Before next feature release | Focused test fails on PR #1 and passes on `main`; verify branch protection requires it | Test complete; enforcement pending |
| AUTHZ-01-C | Logs cannot answer actor and permission questions. | Record request ID, actor, resource, result, and reason without protected contents; test the log shape and redaction. | Platform and API owners | Before next feature release | Allowed and denied event tests pass; secrets and booking contents are absent | Event complete; test pending |
| AUTHZ-01-D | Response decisions depend on memory. | Add a short runbook for containment, evidence preservation, restore proof, monitoring, and decision ownership. | API and incident owners | Before next feature release | A tabletop replay follows the runbook successfully | Open |
| AUTHZ-01-E | Incident updates can become vague or speculative. | Record the audience, confirmed facts, required action, owner, and next update time. | Incident and communications owners | Before the next incident exercise | Completed communication decision record | Open |

## 9. Closure

- **Service restored at:** 10:22 after staging and production verification
- **Communication decision:** Record confirmed impact and evidence limits; do not
  claim that only one user was affected
- **Remaining risk:** Historical impact cannot be reconstructed from the old logs
- **Open actions:** CI enforcement, permission-log test, response runbook, and
  communication record
- **Follow-up:** Action owners report evidence by their listed due dates
- **Review state:** Complete; open actions remain tracked

Restoring the endpoint required technical proof. Closing the review required a
recorded communication decision and clear ownership of the remaining work.

## 10. Evidence

- [Incident packet and reading order](README.md)
- [Support report](support-report.md)
- [Generated timeline](timeline.md)
- [Root cause and evidence limits](root-cause-and-lessons.md)
- [Secure implementation and tests](../../demos/AUTHZ-01/README.md)
- [Deliberate failing PR #1](https://github.com/adnanbn/5p_security_demos/pull/1)
