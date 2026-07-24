# Angular and Mobile Boundary

Hiding a booking link or button is useful interface behavior, not authorization.

Assume users can:

- Change route parameters and request bodies.
- Replay a request outside the Angular application.
- Inspect a mobile binary and recover public configuration.
- Continue using an older mobile client during incident containment.

The Laravel API must derive identity from the authenticated credential and
enforce authorization on every requested booking.
