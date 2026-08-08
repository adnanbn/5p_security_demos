# Support Report

At 09:21, QA reported a repeatable access problem in the test environment.

QA opened booking `8412` while signed in as fictional Account A, copied the URL,
and pasted it into a second browser signed in as fictional Account B. The second
browser returned `200` and displayed Account A's booking.

Both accounts were ordinary authenticated users. No elevated role, stolen
password, or real customer data was involved. QA reproduced the behavior in
staging. The team later confirmed the same behavior in production using approved
test accounts and the minimum number of requests.

Do not include real customer information in the investigation channel.
