# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Laravel 10 admin template/starter kit. This is a clean, reusable base — no specific product domain has been decided yet. Treat it as a foundation for whatever application gets built on top of it, not as evidence of a particular direction.

## Commands

```bash
composer install               # PHP dependencies
npm install                    # JS dependencies
php artisan migrate            # run migrations
php artisan db:seed            # seed initial superadmin user
npm run dev                    # Vite dev server (asset watch)
npm run build                  # production asset build
php artisan serve              # local dev server

php artisan test                                    # run full test suite (phpunit)
php artisan test --filter=AuthFlowTest              # run a single test class
php artisan test tests/Feature/AuthFlowTest.php      # run a single test file
```

Seeded initial login: `superadmin@email.com` / `Testing123`.

There is no configured linter/formatter script in `composer.json`/`package.json` (Laravel Pint is a dev dependency but not wired to a composer script — run `vendor/bin/pint` directly if formatting PHP).

## Architecture

**Stack**: Laravel 10 (PHP 8.1+), Blade views, Alpine.js + jQuery + Tailwind, bundled via Vite (`resources/js/app.js`, `resources/css/app.css`). Uses the classic Laravel 10 `app/Http/Kernel.php` structure (not the newer `bootstrap/app.php` style).

**Routing**: `RouteServiceProvider` loads only `routes/web.php` (web middleware) and `routes/api.php` (api middleware, `/api` prefix). Other route files are pulled in via `require`, not independently registered:
- `web.php` requires `page.php` (Blade page routes) and `mailer.php`

Every route in `page.php` and `api.php` currently resolves to a real controller method with a real backing view (or JSON response) — there is no dead scaffolding left in the routing layer. `PageController::page_Themes()` renders a real view (`pages.settings.theme`) but isn't wired to a route yet; it's a half-built settings page, not orphaned scaffolding — leave it alone unless you're picking that feature up.

**What is actually implemented** (the reusable admin-template core):
- Auth (Laravel Breeze-based) — `app/Http/Controllers/Auth/*`, `routes/auth.php`
- Users & roles — `UserController`, `RolesController`, `User` model (role via `role_id` → `SettingRole`), gate `isSuperAdmin` defined in `AuthServiceProvider` checks `RoleHelper::roleName($user) === 'superadmin'`; permission-based middleware also available (`EnsurePermission`, `Permission` model)
- Teams — `TeamController`, `Team` model
- Dynamic nav menu system — `NavMenu` model (`nav_menus` table: title, icon, link, `allowed_roles`, `allowed_office`, `parent_menu`, `menu_order`), `MenusController`, `NavIconController`, driven client-side by `resources/js/navmenu.js`
- Notifications — polymorphic, targetable by user/role/department. `Notification` model + `notifications` migration, `NotificationService::send()` (targeting/insert logic), `TeamNotifier` (notification + queued email pair for team-leader flows), `NotificationController` (`index` cursor-paginated list, `unreadCount`, `markRead`, superadmin-only `testSend`), polled client-side via `resources/js/notificationController.js` (`window.initNotifications`, called from `navmenu.js`) against `/api/notifications*`. Bell UI lives in `resources/views/layouts/partials/notification-bell.blade.php`. A dev-only `/page_notification_test` page (superadmin-gated) exercises all three target modes.
- Dynamic mailer — `MailerSetting` model, `MailerController`, admin-configurable SMTP settings instead of static `.env` mail config
- Recruitment (RMS) — applicant intake/pipeline built on a dynamic form. Tables: `recruitment_forms` (single active "Caregiver Application", `version` int), `recruitment_form_fields` (typed fields: text/textarea/number/date/select/radio/checkbox/file, `options` json, `help_text`, soft-deactivated via `is_active`; `field_key` immutable; editing type/options bumps form version only when applicants already exist; the old `referral_source` field is seeded `is_active=false` — Source is now a core applicant column, see below), `lookup_lists`/`lookup_list_items` (named dropdowns; `lookup_list_items.parent_id` self-references for one level of nesting — `territory` list seeded empty and used this way: top-level items are Territories, their children are Locations; `source`/`role` are flat; **`status` is the single source of truth for pipeline stages** — seeded New/In Review/Interview/Orientation/Offer/Hired/Rejected, `Applicant::validStatuses()` returns that list's active top-level item names in order, `BASE_STATUSES` is gone), `checklist_groups` (`label`, `target_status` validated `Rule::in` against active status-list names in `ChecklistItemController`, `is_active`) / `checklist_items` (post-interview template, `checklist_group_id` nullable — ungrouped items informational only), `applicants` (`form_data` json snapshot + `form_version`, `assigned_to`=creator/owner, denormalized `team_id`, `status` plain string validated against `validStatuses()`; ATS core columns `role_id`/`source_id`/`location_id` → `lookup_list_items`, `phone`, `email`, `date_of_birth`, `interview_summary`), `applicant_files` (uploads to `storage/app/public/applicant_files`, needs `storage:link`), `applicant_checklist_items` (attached idempotently by `ApplicantController::attachMissingChecklistItems()` on transition into Interview or Orientation, and on interview Pass), `applicant_notes` (append-only, `created_by`; no edit/delete), `applicant_orientations` (one row per applicant — `applicant_id` unique, `updateOrCreate` on reschedule). **Two-stage intake:** Add Applicant is a lightweight create (name/role/source/location/phone/email/DOB/notes — no dynamic form, no files); the 33-question form moved to the **Interview** flow — `PATCH /api/applicants/{id}/interview` (front-end posts multipart via `_method=PATCH` spoofing since PHP won't parse multipart on real PATCH) takes `outcome=pass|fail` + `form_data`/`files`, saving answers and setting status Orientation (pass, attaches checklist) or Rejected (fail, no checklist). Checking off every active item in a group auto-advances status to the group's `target_status` (`maybeAdvanceStatusForGroup()`, from `toggleChecklistItem`) — one-directional. Controllers: `RecruitmentFormController`/`LookupListController`/`ChecklistItemController` (all `can:isSuperAdmin`, under `/api/recruitmentForm`, `/api/lookupLists`, `/api/checklistItems`, `/api/checklistGroups`), `ApplicantController` (`/api/applicants`, any authenticated user — visibility team-scoped in-query via `scopedQuery`, NOT middleware: superadmin all, leaders team-wide with `?scope=mine`, members team, teamless own; endpoints: `store`, `show`, `formConfig` [returns territories+roles+sources+fields, open to all so non-admins get dropdown values], `statuses`, `updateStatus`, `interview`, `interviewSummary`, `notes` GET/POST, `orientation` PUT, plus `GET /api/applicantOrientations` [scoped through the applicant] backing the schedule page). Add-applicant fires `TeamNotifier::notify()` (FYI to direct leaders). Daily `recruitment:notify-unprocessed` command (5pm, `Console/Kernel`) nudges recruiters with unfinished checklists. Pages: `/page_app_settings` (superadmin 3-tab maintenance: Form Management, Lookup Lists, Checklist), `/page_applicants` (list + Add/View/Interview modals — the View modal is a 2-column side-over with status, interview summary, interview/orientation actions, copy, answers, notes / checklist + files; the old `/page_applicant_new` and `/page_applicant_view` pages were removed), `/page_orientation_schedule` (scheduled-orientations list). Views under `resources/views/pages/recruitment/*`; page JS is inline-IIFE per blade (no Alpine on injected fragments). Nav: top-level "Recruitment" parent (all roles) with "Applicants" + "Orientation Schedule" children; "App Settings" under Developer Option (superadmin).

**Middleware of note** (`app/Http/Kernel.php` aliases):
- `check.status` (`CheckUserStatus`) — force-logs-out and redirects users whose `status === 1` (inactive); applied on the main authenticated `web.php` group
- `prevent-back-history` (`PreventBackHistory`) — applied alongside `check.status`
- `EnsureSingleSession` (registered globally in the `web` group) — on every authenticated request, deletes any other active session rows for that user in the `sessions` table, enforcing single-session-per-user by force-logging out other sessions
- `SafeText` — validates POST/PUT/PATCH string input against a restrictive allowed-character regex, returns 422 on violation (available but check where it's actually applied before assuming it runs everywhere)
- `EnsurePermission` (`permission:*`) — checks a named permission against the current user's role, used e.g. on role-management mutation routes
- `ThemeMiddleware` — available but check usage before assuming it's wired into a given route group

**Deployment layout** (see README): production deployment splits the repo into `app_core/` (all Laravel framework files: app, bootstrap, config, database, resources, routes, storage, vendor) with only `public/` exposed as the web root. `public/index.php` needs its relative paths updated to point at `app_core/` when restructured this way. Always run `npm run build` before restructuring for deployment. Never commit `.env`.
