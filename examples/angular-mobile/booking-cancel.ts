// Review exercise: the client can suggest values, but it cannot prove them.
// The screen may be stale. A mobile client may retry after a timeout.
if (!booking.canCancel) return;

await http.post(`/api/bookings/${booking.id}/cancel`, {
  accountId: currentUser.accountId,
  refundAmount: booking.refundAmount,
  version: booking.version,
});
