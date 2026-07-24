def get_booking_for_user(*, booking_id, user):
    """Django translation of the owner-scoped Laravel query."""
    return user.bookings.get(pk=booking_id)


def test_user_cannot_read_another_users_booking(api_client, alice, bobs_booking):
    api_client.force_authenticate(alice)

    response = api_client.get(f"/api/bookings/{bobs_booking.pk}")

    assert response.status_code == 404
