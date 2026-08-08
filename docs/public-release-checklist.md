# Public Release Checklist

Use this checklist before changing the repository from private to public.

- Confirm the remote visibility before and after every administrative change.
- Review every branch and tag, not only `main`.
- Delete or recreate demonstration branches if their history is unsuitable.
- Verify every credential is fictional and grants no access.
- Review generated logs for names, domains, IP addresses, and hidden metadata.
- Confirm the MIT license, contribution guide, security policy, and teaching
  warning are present.
- Re-run tests, secret scanning, dependency scanning, and workflow auditing.
- Protect every branch against deletion, force pushes, and direct changes.
- Require a pull request, owner review, and owner-controlled merge for every
  target branch. Keep explicitly approved collaborators without granting merge
  authority.
- Create the public release from a clean, reviewed commit rather than assuming
  private history is ready to publish.
