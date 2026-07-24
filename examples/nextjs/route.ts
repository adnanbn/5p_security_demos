// The client-provided ID selects a resource; the server session supplies identity.
export async function GET(
  _request: Request,
  context: { params: Promise<{ bookingId: string }> },
) {
  const session = await requireServerSession()
  const { bookingId } = await context.params

  const booking = await db.booking.findFirst({
    where: { id: bookingId, userId: session.user.id },
    select: { id: true, reference: true, title: true, startsAt: true, status: true },
  })

  return booking
    ? Response.json({ data: booking })
    : Response.json({ message: 'Not found.' }, { status: 404 })
}
