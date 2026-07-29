# Facilitator Findings

## Root Cause

Unknown paths reached Laravel's fallback route. Custom denial-audit middleware
queried the database and synchronously wrote an audit record before returning
each `404`. Valid partner requests failed as collateral when workers and database
connections saturated.

The protected partner route continued to reject missing credentials correctly.
The expensive fallback path made the service unavailable.

## Contributing Conditions

- Common hostile paths were not rejected at the edge.
- Per-IP limiting alone did not address repeated probes from the fixture's
  multiple synthetic source addresses.
- Every unknown-path denial produced database work and a durable log write.
- Alerts focused on successful authentication failures rather than rejection cost.

## Corrective Layers

- Reject common sensitive and unknown paths before Laravel where practical.
- Rate limit by multiple dimensions and enforce bounded request cost.
- Sample repetitive denials while retaining representative evidence.
- Alert on worker saturation, queue depth, denial cost, and path cardinality.
- Keep incident communication factual and avoid claiming a breach without evidence.
