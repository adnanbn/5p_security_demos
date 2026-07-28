# Timeline

- **09:06** - QA signs into synthetic Account A as actor 17.
- **09:07** - Account A opens booking `8412` and copies its URL.
- **09:08** - QA signs into synthetic Account B as actor 23 in a second browser.
- **09:09** - The copied `8412` URL returns `200` in Account B's browser.
- **09:21** - QA reports the repeatable cross-account response.
- **09:34** - The endpoint is disabled while scope is investigated.