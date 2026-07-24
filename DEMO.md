# Incident Scenario: Expensive Rejection Path

This branch performs a database read, a durable database write, and a
synchronous security log for every unknown API path.

Every request is denied, but distributed probing can exhaust PHP-FPM workers,
database connections, and logging throughput.

Expected result: the test requiring unknown paths to avoid database work fails.
Do not merge this branch.
