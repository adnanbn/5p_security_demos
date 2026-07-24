# Facilitator Findings

## Root Cause

Unknown and invalid requests reached Laravel. Custom credential and audit middleware queried the database and synchronously wrote an audit record for every denial.

The authentication control worked. The rejection path was too expensive.

## Contributing Conditions

- Common hostile paths were not rejected at the edge.
- Per-IP limiting did not address distributed low-volume sources.
- Every denial produced database work and a durable log write.
- Alerts focused on successful authentication failures rather than rejection cost.

## Corrective Layers

- Reject common sensitive and unknown paths before Laravel where practical.
- Rate limit by multiple dimensions and enforce bounded request cost.
- Sample repetitive denials while retaining representative evidence.
- Alert on worker saturation, queue depth, denial cost, and path cardinality.
- Keep incident communication factual and avoid claiming a breach without evidence.