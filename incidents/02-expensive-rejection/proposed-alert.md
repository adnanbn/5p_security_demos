# Proposed Alert: Expensive Rejection

Page the API on-call when valid partner success rate falls while the PHP-FPM
listen queue, database connection wait, and unknown-path cardinality rise.

- **Owner:** API on-call
- **First action:** apply the documented edge containment and preserve a sample
- **Runbook:** rejection-outage
- **Evidence:** no raw credentials, request bodies, or full headers