# Contributing

Thanks for your interest in contributing! To keep the codebase stable:

1. Fork the repo and create a feature branch from `main`.
2. Follow Conventional Commits for messages.
3. Add tests for new features and run `php artisan test`.
4. Ensure CI passes.
5. Open a Pull Request and fill out the template.

## Development

-   PHP/Laravel
-   Node + Vite for assets
-   Run DB migrations locally: `php artisan migrate`

## Code style

-   Prefer readability and small functions.
-   Keep controllers thin; move logic into models/services where reasonable.
