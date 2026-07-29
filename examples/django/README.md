# Django Examples

[`authorization.py`](authorization.py) translates `AUTHZ-01` into a small
Django-shaped example.

## Decision Being Taught

The caller may choose a booking identifier, but the authenticated user defines
the ownership scope:

```python
user.bookings.get(pk=booking_id)
```

The negative test authenticates as one valid user, requests another user's
booking, and expects a denial. That product rule is stronger evidence than a
generic scanner because the scanner does not know who should own the record.

## Reuse In A Real Project

- Put the ownership decision in the queryset, permission, or service boundary.
- Use the project's chosen `404` or `403` behavior consistently.
- Verify both the response and that no protected state changed.
- Add the focused test to required CI.

This file is a teaching extract, not a runnable Django project. See
[`AUTHZ-01`](../../demos/AUTHZ-01/README.md) for the canonical lesson and
durable expected finding.
