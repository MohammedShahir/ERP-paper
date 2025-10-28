# Enforce Branch Protection on `main`

To ensure no direct edits happen without a Pull Request, configure the repository settings:

1. Settings → Branches → Add rule
2. Branch name pattern: `main`
3. Check the following:
   - Require a pull request before merging
   - Require approvals (at least 1)
   - Dismiss stale pull request approvals when new commits are pushed
   - Require status checks to pass before merging (select CI checks, e.g., `tests` job)
   - Require signed commits (optional)
   - Include administrators (optional, recommended)
4. Save changes.

Optional: Enable "Require review from Code Owners" and define owners in `.github/CODEOWNERS`.
