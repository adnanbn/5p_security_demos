type CommentProps = {
  body: string
}

export function Comment({ body }: CommentProps) {
  // React escapes text interpolation. Keep untrusted content out of HTML sinks.
  return <p>{body}</p>
}
