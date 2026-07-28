# Incident 2 Edge Configuration

These files show the teaching scenario before and after containment:

- `permissive-api-before.conf` forwards unknown paths to Laravel. On the
  deliberately vulnerable scenario branch, the fallback performs database and
  synchronous logging work before returning `404`.
- `secure-api.conf` is the proposed after-state. It rejects common probes before
  PHP and bounds traffic to the partner route.

The regular expression, limits, upstream, and paths are examples. Validate them
against the real application and deployment environment. Laravel must still
reject safely if edge controls are bypassed.
