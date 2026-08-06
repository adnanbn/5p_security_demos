# Frontend and Mobile Security Exercise

The UI hides cancellation when the API says `canCancel` is false:

```ts
if (booking.canCancel) {
  showCancelButton();
}

await http.post(`/api/bookings/${booking.id}/cancel`, {
  accountId: currentUser.accountId,
});
```

This may be reasonable interface code. It is not a server-side permission check.

Assume a valid user can:

1. Replay the request outside the Angular, Next.js, or mobile client.
2. Change the booking identifier and body.
3. Continue using an older mobile client after the UI changes.

## Review the Change

- **Risk:** A valid user may cancel another account's booking if the API trusts
  the client-provided account identifier or the hidden button.
- **Protection:** The server gets identity from the login credential and checks
  permission for the requested booking. This works the same in Laravel, Django,
  and other server frameworks.
- **Test:** A request test signs in as one user, targets another user's
  booking, expects a denial, and verifies that the booking state did not change.
- **Automated check:** The focused API test is required before merge.

## Example Review Comment

> Hiding this button is useful UX, but a caller can replay and modify the API
> request. Please enforce cancellation authorization on the server and add a
> valid non-owner request test that proves the booking remains unchanged.

The framework can reduce accidental HTML injection through default escaping,
but raw-HTML APIs and unsafe DOM access still need review. Client-side
validation improves feedback; the server remains the authority for identity,
authorization, validation, and state changes.
