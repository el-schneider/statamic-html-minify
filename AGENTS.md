## Off-Limits Files

- **`CHANGELOG.md`** — Updated by CI when a GitHub release is published. Do not edit manually.

## Contributor Guardrails

- Prefer fixing the root cause instead of adding workaround-only patches.
- Keep comments focused on intent: explain why code exists, not just what it does.
- Avoid adding abstractions only used by one caller; keep local logic local.
- Do not add non-reusable patterns unless there is a clear, broader reuse need.
- Let failures surface unless they can be handled with explicit, actionable recovery.
- Do not use tidy/empty `try-catch` blocks; avoid swallowing useful errors.
- For markup-affecting changes, verify representative HTML output in a real Statamic app.
