# Repository Rules

These rules define how changes are made to this repository. They are designed to keep the codebase stable and auditable.

- No direct pushes to the default branch (main). All changes must come via Pull Requests (PRs).
- Every PR requires at least one code review approval.
- All status checks must pass (CI green) before merge.
- PR titles should follow Conventional Commits (e.g., `feat: ...`, `fix: ...`, `chore: ...`).
- Keep PRs focused and small when possible. Include screenshots for UI changes.
- Fill out the PR template completely.

To fully enforce these rules, enable Branch Protection on `main` as described in `docs/BRANCH_PROTECTION.md`.
