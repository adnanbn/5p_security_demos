# Support Report

At 09:21, QA reported a repeatable access problem in the test environment.

QA opened booking `8412` while signed in as fictional Account A, copied the URL,
and pasted it into a second browser that was already signed in as fictional
Account B. The second browser returned `200` and displayed Account A's booking.

Both accounts were ordinary authenticated users. No elevated role, stolen
password, or production customer data was involved.

Do not include real customer information in the investigation channel.
