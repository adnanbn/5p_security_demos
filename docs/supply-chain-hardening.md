# Software Supply-Chain Hardening

A package install, build plugin, container image, and CI action can all execute
third-party code inside a trusted environment.

## Consumer Controls

- Commit lockfiles and use deterministic install commands.
- Review dependency, lifecycle-script, and lockfile changes together.
- Scan manifests and lockfiles for known vulnerabilities.
- Pin GitHub Actions to full commit SHAs and keep workflow permissions minimal.
- Isolate build jobs and avoid long-lived credentials in CI.
- Maintain a fast credential-rotation path for suspected compromise.

## Publisher Controls

- Require strong authentication for maintainers.
- Prefer short-lived workload identity and trusted publishing over stored tokens.
- Separate publish approval from routine development credentials.
- Record provenance and verify the artifact that was actually released.

## Repository Demonstrations

- [`demo/03-vulnerable-dependency`](https://github.com/adnanbn/5p_security_demos/tree/demo/03-vulnerable-dependency)
  gives OSV-Scanner isolated vulnerable-package evidence without executing it.
- [`demo/05-unpinned-action`](https://github.com/adnanbn/5p_security_demos/tree/demo/05-unpinned-action)
  changes one Action from a full commit SHA to a mutable tag so Zizmor fails.

These checks identify known risk. They do not prove that a dependency or action
is trustworthy, nor do they replace review of new executable code.
