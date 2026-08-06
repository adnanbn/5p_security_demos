## Risk

What data or service does this change affect? Who can use it, and where is
access checked?

## Guard

Where does the server make the security decision? What happens when information is missing
or a dependency fails?

## Proof

- [ ] Happy-path behavior is covered.
- [ ] At least one blocked action has a repeatable negative test.
- [ ] Protected data is absent from denial and error responses.

## Automated Gate

Which required quality or security check evaluates this change?

## Observability

What log event, request ID, metric, or alert would help investigate
misuse without logging secrets or unnecessary personal data?

## Remaining Risk

What does this change or its automated evidence not prove?
