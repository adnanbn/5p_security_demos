# Root Cause and Lessons

## Root Cause

The endpoint confirmed that the user was logged in, then loaded a booking only
by its ID. It did not check whether the booking belonged to that user.

Authentication succeeded. Authorization never happened.

## What the Evidence Shows

- Requests for booking identifiers `8411` and `8412` returned `200`.
- Login succeeded for users 17 and 23.
- The access logs do not connect either user to a specific booking request.

## What the Evidence Cannot Show

- Which user received booking `8412` on each request.
- Whether booking `8412` belonged to that user.
- Which booking fields were returned.
- Whether other users exercised the same path.

## Fixes

- Limit the query to the signed-in user's bookings.
- Keep a second server-side permission check. This demo uses a Laravel policy.
- Add a two-user feature test.
- Log the permission result without logging the booking contents.
