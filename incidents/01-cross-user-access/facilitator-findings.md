# Facilitator Findings

## Root Cause

The endpoint authenticated the caller but fetched a booking by global identifier without enforcing ownership or an equivalent policy.

Authentication succeeded. Authorization never happened.

## What the Evidence Shows

- Requests for booking identifiers 41 and 42 returned `200`.
- Authentication succeeded for actor 17.
- The logs do not connect actor 17 to each booking access.

## What the Evidence Cannot Show

- Which user received booking 42.
- Whether booking 42 belonged to that user.
- Which fields were serialized.
- Whether other users exercised the same path.

## Corrective Layers

- Scope the query to the authenticated user's relationship.
- Retain a Laravel policy as defense in depth.
- Add a two-user feature test.
- Record an authorization decision without logging booking contents.