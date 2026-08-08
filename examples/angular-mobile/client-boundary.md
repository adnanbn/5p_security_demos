# Frontend and Mobile Cancellation Exercise

The code in [`booking-cancel.ts`](booking-cancel.ts) looks reasonable in a
client application:

```ts
if (!booking.canCancel) return;

await http.post(`/api/bookings/${booking.id}/cancel`, {
  accountId: currentUser.accountId,
  refundAmount: booking.refundAmount,
  version: booking.version,
});
```

Now add the product rules:

- A customer may cancel only their own booking and only until 24 hours before
  it starts.
- Support staff may follow an approved override path.
- The mobile application retries after a timeout.
- The screen may have been open for several minutes before the request is sent.

## Your Task

1. Which values are client input, and which decisions belong to the server?
2. What can change after the screen loads?
3. Choose three tests that prove the correct user, the current rules, and a
   retry that does not cancel or refund twice.
4. What should be logged, and which check should be required before merge?

Stop here before reading the review guide.

---

## Review Guide

### Client Input Is Not Proof

The caller can change the booking ID, account ID, refund amount, version, and
the visible `canCancel` value. The server gets the actor and role from the
authenticated session. It loads the booking, checks ownership or support
permission, applies the current deadline, and calculates the refund itself.

### State Can Change

The deadline may pass, the booking may already be cancelled, its version may
change, or support may update it while the screen is open. The server must use
current data when it makes the change. A version can help detect stale data,
but it does not prove identity or permission.

### Make Retries Safe

Cancellation and refund should complete as one controlled operation. An
idempotency key, unique operation record, or database constraint can prevent a
timeout retry from applying the same action twice.

### Useful Tests

- A customer cannot cancel another customer's booking.
- A customer cannot cancel after the deadline, while the authorized support
  path follows its separate rule.
- Repeating the same logical request does not cancel or refund twice.
- A stale version cannot overwrite newer state.

### Useful Evidence

Log the actor, booking, decision, reason, request or correlation ID, and result.
Do not log tokens, payment details, or unnecessary personal data. Require the
focused API or feature tests before merge. A generic scanner is unlikely to
understand the deadline, support override, or refund rule.

## Cross-Stack Translation

The framework names change, but the server decisions do not. A controller,
view, route handler, or service must authenticate the actor, authorize the
action, read current state, apply the change once, and record the outcome.
