# Facilitator Findings

## Root Cause

The endpoint authenticated the caller but fetched a booking by global identifier without enforcing ownership or an equivalent policy.

Authentication succeeded. Authorization never happened.

## What the Evidence Shows

- Requests for booking identifiers `8411` and `8412` returned `200`.
- Authentication succeeded for actors 17 and 23.
- The access logs do not connect either actor to an individual booking request.

## What the Evidence Cannot Show

- Which actor received booking `8412` on each request.
- Whether booking `8412` belonged to that actor.
- Which fields were serialized.
- Whether other users exercised the same path.

## Corrective Layers

- Scope the query to the authenticated user's relationship.
- Retain a Laravel policy as defense in depth.
- Add a two-user feature test.
- Record an authorization decision without logging booking contents.