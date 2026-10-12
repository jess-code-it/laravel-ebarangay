Agent Instructions --- eBarangay
1. Project Overview
Build eBarangay, a secure, role-based web application for barangay
services using the existing project stack:
- Framework: Laravel 13
- PHP: 8.4.15
- Composer: 2.10.3
- Database: MySQL
- Frontend: Follow the frontend stack and conventions already
  present in the repository. Do not introduce a new framework or UI
  library without a clear need and approval.
Treat this file as the working agreement for AI coding agents and
developers. Inspect the repository before making changes, preserve
established conventions, and prefer small, testable changes.
2. Core Development Rules
1. Read composer.json, composer.lock, .env.example, routes,
   migrations, models, middleware, controllers, policies, tests, and
   frontend configuration before changing architecture.
2. Use Laravel 13-compatible APIs and PHP 8.4-compatible syntax. Do not
   copy APIs from older Laravel versions without verifying
   compatibility.
3. Use Composer-managed dependencies. Do not edit composer.lock
   manually.
4. Keep business logic out of route definitions and, where appropriate,
   controllers. Use Form Requests for validation, policies/gates for
   authorization, and services/actions for substantial workflows.
5. Use migrations for schema changes. Never rely on manual production
   database edits as the only record of a change.
6. Do not commit secrets, API keys, credentials, real resident data,
   database dumps, or production logs.
7. Do not disable security controls to make a test pass. Fix the
   underlying issue or document the blocker.
8. Do not claim the system is secure against every possible attack.
   Apply defense in depth, test controls, and document residual risks.
9. Keep changes focused. Do not overwrite unrelated user changes or
   delete existing features without approval.
10. When finished, report files changed, migrations or commands needed,
    tests run and their results, and any remaining security concerns.
3. Roles and Access Control
Use explicit server-side roles. Suggested role identifiers:
- super_admin
- admin
- common_user
Use Laravel policies/gates or a well-maintained role/permission package
only if it fits the installed dependencies. Do not rely on hidden
buttons, frontend route guards, or submitted role values as
authorization.
Access decision flow
1. A visitor can access only public pages and permitted authentication
   flows.
2. A registered user submits credentials through the login flow.
3. After successful authentication, load the user's role from trusted
   server-side data.
4. Route the user to the correct authorized dashboard or area.
5. If a user does not have an authorized role or permission, deny
   access with a safe 403 response or redirect to an appropriate
   page.
6. Log relevant security events without recording passwords, session
   IDs, access tokens, or other secrets.
Role boundaries
- Super Admin: Super Admin Dashboard; transaction management;
  audit trail; payment management; profile and authentication
  configuration; create/update/delete event-calendar items,
  announcements/news, incident reports, and blotter records, according
  to the permission matrix.
- Admin: Admin Dashboard; permitted transaction, payment,
  authentication, event-calendar, incident-report, and blotter
  workflows. Do not assume Admin has Super Admin powers.
- Common User: Common User Dashboard; certificate request
  dashboard; profile; permitted payment and incident-report
  submission/status features. Users must only access their own records
  unless a specific policy allows otherwise.
- Public/Guest: Landing, login, sign-up, FAQ, About Us, and Forgot
  Password pages. Any public access to other pages must be explicitly
  approved and narrowly scoped.
Create a documented permission matrix before implementing sensitive
operations. Enforce ownership and role checks on every read, create,
update, export, download, and delete operation. Prevent insecure direct
object reference (IDOR) by checking authorization for the requested
record, not just whether the user is logged in.
4. Pages and Features
Use the supplied eBarangay flowchart and page inventory as the initial
scope. Confirm exact route names and permissions against the current
codebase before implementation.
Common/public pages
- Landing Page
- Login Page
- Sign-up Page
- FAQ
- Forgot Password Page
- About Us
Common User pages
- Common User Dashboard
- Certificates Request Dashboard
- Profile Page
- Create/Update Incident Report Page, where authorized
- Authentication Page, if needed for account security
- Payment Page, where applicable
Super Admin pages
- Super Admin Dashboard
- Transaction Page
- Audit Trail Page
- Payment Page
- Profile Page
- Authentication Page
- Create/Update/Delete Event Page / Calendar Page
- Create/Update/Delete Announcement / News Page
- Create/Update/Delete Incident Report Page
- Create/Update/Delete Blotter Page
Admin pages
- Admin Dashboard
- Transaction Page
- Payment Page
- Authentication Page
- Create/Update Incident Report Page
- Create/Update Blotter Page
Do not infer that every page name means unrestricted CRUD. Define the
permitted actions, data scope, and approval requirements per role. For
example, deleting a blotter or incident record may need to be
restricted, soft-deleted, or replaced by a documented archival process.
5. Authentication and Account Security
Use Laravel's supported authentication mechanisms and maintained
dependencies. Review the existing authentication implementation before
replacing it.
Required controls
- Hash passwords with Laravel's configured password hasher; never
  store or log plaintext passwords.
- Validate all user input on the server using Form Requests or
  equivalent validation.
- Use CSRF protection for state-changing browser requests. Do not
  exempt routes casually.
- Regenerate the session ID after login and privilege changes.
  Invalidate sessions and regenerate the CSRF token on logout.
- Apply login throttling and sensible lockout/backoff behavior to
  reduce brute-force attacks and credential stuffing. Avoid permanent
  lockouts that enable denial of service.
- Use secure password-reset tokens with expiry, single-use behavior,
  and generic responses that do not reveal whether an account exists.
- Require verified email or another approved verification process
  before enabling sensitive account actions, if applicable to the
  product.
- Require multi-factor authentication for Super Admin accounts;
  strongly consider it for Admin accounts.
- Protect sensitive account changes (password, email, role, MFA,
  payout/payment settings) with re-authentication and/or MFA
  confirmation.
- Prevent mass assignment by defining $fillable or $guarded
  carefully and validating fields explicitly. Never accept role,
  permissions, verification status, or account status directly from
  ordinary sign-up requests.
- Use secure cookie settings in production: Secure over HTTPS,
  HttpOnly, and an appropriate SameSite policy.
- Set session lifetime according to risk and operational needs;
  provide session invalidation when accounts are disabled or roles are
  changed.
- Use generic login errors and avoid exposing whether a username/email
  exists.
- Keep authentication, password reset, registration, and MFA endpoints
  rate-limited.
- Do not implement custom cryptography or roll your own password
  storage.
Registration and privilege assignment
Public registration must create only the lowest-privilege approved role
(normally common_user). Admin and Super Admin accounts must be
provisioned through a controlled, audited process. Never permit users to
select their own privileged role in a request, form, API payload, or
mass assignment.
6. Web Application Security
Use defense in depth for the following common attack classes:
- SQL injection: Use Eloquent or parameterized query builder
  bindings. Avoid concatenating untrusted values into raw SQL. If raw
  SQL is unavoidable, bind all values and review it carefully.
- Cross-site scripting (XSS): Escape output by default in Blade
  ({{ }}). Avoid {!! !!} with user content. Sanitize rich HTML
  with a maintained allowlist sanitizer if rich text is required.
- Cross-site request forgery (CSRF): Keep Laravel CSRF middleware
  active for browser-based state-changing requests.
- Broken access control / IDOR: Apply policies or explicit
  authorization checks to every protected operation and record.
- Mass assignment: Validate and allowlist fields. Never trust
  client-supplied role or ownership identifiers.
- Session attacks: Regenerate sessions at authentication
  boundaries, use secure cookies, enforce HTTPS, and invalidate
  compromised sessions.
- Brute force / credential stuffing: Rate-limit login and recovery
  endpoints; monitor repeated failures.
- File upload attacks: Allowlist required extensions and MIME
  types, validate size, generate server-side filenames, store files
  outside the public web root or on private storage, and authorize
  every download. Never trust the original filename or client MIME
  type alone.
- CSRF and unsafe HTTP methods: Use appropriate HTTP verbs and
  never perform destructive actions through GET requests.
- Open redirects: Validate redirect targets and prefer named
  internal routes.
- Clickjacking / MIME sniffing: Configure suitable security
  headers, including frame restrictions,
  X-Content-Type-Options: nosniff, and an appropriate
  Referrer-Policy. Configure Content Security Policy carefully for
  the actual frontend.
- Server-side request forgery (SSRF): If the app fetches
  user-supplied URLs, restrict schemes and destinations, block
  private/loopback/link-local ranges as appropriate, and enforce
  network-level egress controls.
- Denial of service: Apply sensible request limits, pagination,
  query limits, upload limits, and rate limits to expensive
  operations.
- Sensitive data exposure: Minimize collected data, redact logs,
  restrict exports, use private storage, and avoid returning internal
  exception details.
- Dependency vulnerabilities: Review Composer advisories and
  update dependencies through a tested process.
- Configuration exposure: Never expose .env, debug pages, stack
  traces, database credentials, backups, or private storage through
  the web server.
Use Laravel's built-in protections where available. Do not disable
middleware, escaping, validation, or authorization as a shortcut.
7. MySQL and Data Protection
- Use MySQL with utf8mb4 character set and a suitable collation.
- Use migrations with explicit data types, foreign keys, indexes, and
  constraints.
- Add indexes for frequently queried foreign keys and search/filter
  columns after reviewing query patterns.
- Use transactions for multi-step operations that must succeed or fail
  together.
- Enforce important invariants at both application and database levels
  where practical.
- Use unique constraints for identifiers that must be unique, such as
  approved account identifiers or reference numbers.
- Use soft deletes or an auditable archival approach for records that
  must be retained. Follow applicable retention and privacy
  requirements.
- Use a dedicated least-privilege database account for the
  application. Do not use MySQL root in production.
- Keep database credentials in environment configuration or a secret
  manager, never source control.
- Restrict MySQL network access to the application environment;
  require encrypted connections where supported and appropriate.
- Back up the database securely, encrypt backups at rest and in
  transit where feasible, restrict access, and periodically test
  restoration.
- Avoid logging resident personal information, credentials, payment
  details, or full sensitive record contents.
- Use pagination and explicit field selection; avoid returning all
  columns or unbounded datasets.
- For payment handling, use a reputable payment provider. Do not store
  card numbers, CVV, or payment credentials. Verify provider
  callbacks/webhooks using the provider's signature mechanism and
  prevent replay or duplicate processing.
8. Privacy, Barangay Records, and Audit Trails
eBarangay may handle personal information and sensitive community
records. Apply data minimization, purpose limitation, role-based access,
secure retention, and privacy-aware logging.
- Collect only information required for a documented barangay service.
- Restrict blotter, incident, certificate, and resident records to
  authorized roles and legitimate purposes.
- Do not expose private records in public URLs, search results, logs,
  error messages, or client-side bundles.
- Audit important actions: authentication successes/failures,
  permission changes, account disablement, record
  creation/update/deletion, exports, payment state changes, and
  sensitive record access where appropriate.
- Audit entries should include actor ID (when available), action,
  target record identifier, timestamp, outcome, and
  request/correlation ID where practical.
- Do not put passwords, tokens, session cookies, or unnecessary
  personal data into audit logs.
- Protect audit logs against ordinary users and administrators who
  should not be able to silently alter them. Restrict deletion and
  changes to authorized maintenance procedures.
- Follow applicable Philippine privacy requirements and the
  organization's retention and incident-response policies. Escalate
  legal or policy decisions rather than inventing requirements.
9. Validation, Errors, and Logging
- Validate type, length, format, allowed values, ownership, and
  business rules on the server.
- Normalize input only where appropriate; do not assume validation
  alone makes output safe.
- Return clear validation errors without exposing internals.
- In production, keep APP_DEBUG=false and use a production-safe
  APP_ENV.
- Log unexpected failures securely with enough context to diagnose
  them, but redact secrets and sensitive data.
- Do not catch and silently discard exceptions. Handle expected
  failures explicitly and allow unexpected errors to be recorded.
- Use consistent error responses for browser and API requests.
10. Laravel Configuration and Environment
Use .env.example to document required configuration keys with
placeholders only. Never put real credentials in it.
Expected environment configuration should include the appropriate values
for the project, such as:
- APP_ENV
- APP_DEBUG=false in production
- APP_URL using the correct HTTPS URL in production
- DB_CONNECTION=mysql
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD
- Session, cache, queue, mail, and storage settings as required by the
  installed application
Never paste real .env values into source files, issues, chat, test
fixtures, or logs. Local development may use local-only secrets.
Production secrets must be managed separately and rotated if exposed.
Before production deployment, review Laravel's production deployment
guidance for the installed Laravel 13 version. Confirm configuration
caching, route/view caching where appropriate, writable storage/cache
directories, HTTPS, trusted proxy settings, queue workers, scheduler,
and file permissions. Do not run destructive commands against production
without explicit approval and a verified backup.
11. Testing Requirements
Add or update automated tests for every meaningful feature and security
boundary.
At minimum, cover:
- Guest access restrictions for protected routes.
- Login success/failure, throttling, logout, password reset, and
  session regeneration.
- Registration cannot create Admin or Super Admin users.
- Each role can access only its allowed routes and actions.
- A common user cannot view or modify another user's records by
  changing an ID.
- Admin cannot perform Super Admin-only actions.
- Unauthorized record updates/deletions are rejected.
- Validation rejects malformed and unexpected fields.
- CSRF protection remains enabled for browser state-changing routes.
- File uploads reject disallowed file types and excessive sizes.
- Payment callbacks/webhooks are signature-verified and duplicate
  events are handled safely, if payments are implemented.
- Audit entries are written for important actions without leaking
  secrets.
- Database constraints and transactions behave as intended.
Use Laravel's testing tools and the repository's existing test
conventions. Use factories and synthetic test data; never use real
resident data in tests. Run relevant tests after changes and report
failures honestly.
12. Suggested Implementation Workflow
1. Inspect repository structure and current dependencies.
2. Summarize the existing architecture and identify missing
   requirements before large changes.
3. Confirm the role/permission matrix and page-to-role mapping.
4. Review authentication, session, middleware, validation, database,
   and storage configuration.
5. Implement schema changes through migrations and add appropriate
   constraints/indexes.
6. Implement authorization policies before exposing sensitive data or
   actions.
7. Implement features in small vertical slices with tests.
8. Run formatting, static analysis, and tests available in the
   repository.
9. Review the diff for secrets, unsafe raw SQL, unescaped output, mass
   assignment, missing authorization, and accidental data exposure.
10. Document setup, migration, testing, and deployment steps.
13. Useful Local Commands
Run commands from the project root and check the repository's scripts
before assuming a command is available.
php -v
composer --version
php artisan --version
composer validate
composer audit
php artisan route:list
php artisan migrate:status
php artisan test
For a new local environment, after checking the project's actual setup:
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
On Windows, create .env by copying .env.example using the available
shell or file manager if cp is unavailable. Configure MySQL
credentials before migrating. Do not run migrations against production
without explicit authorization and a verified backup.
14. Definition of Done
A change is complete only when:
- The feature matches its documented requirements.
- Server-side authorization is enforced for all protected actions and
  records.
- Input validation, safe output handling, and database constraints are
  in place.
- Relevant automated tests pass, or failures are clearly reported.
- No secrets or sensitive user data are introduced into source control
  or logs.
- Migrations and environment changes are documented.
- The final summary states what changed, what was tested, and what
  still needs attention.
Security principle: No application can be guaranteed to prevent
every attack. eBarangay must use layered security, least privilege,
secure defaults, ongoing dependency updates, monitoring, backups, and
regular security review.