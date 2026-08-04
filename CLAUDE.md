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
- Users & roles — `UserController`, `RolesController`, `User` model (role via `role_id` → `SettingRole`), gate `isSuperAdmin` defined in `AuthServiceProvider` checks `$user->role_name === 'superadmin'`; permission-based middleware also available (`EnsurePermission`, `Permission` model)
- Teams — `TeamController`, `Team` model
- Dynamic nav menu system — `NavMenu` model (`nav_menus` table: title, icon, link, `allowed_roles`, `allowed_office`, `parent_menu`, `menu_order`), `MenusController`, `NavIconController`, driven client-side by `resources/js/navmenu.js`
- Notifications — polymorphic, targetable by user/role/department. `Notification` model + `notifications` migration, `NotificationService::send()` (targeting/insert logic), `TeamNotifier` (notification + queued email pair for team-leader flows), `NotificationController` (`index` cursor-paginated list, `unreadCount`, `markRead`, superadmin-only `testSend`), polled client-side via `resources/js/notificationController.js` (`window.initNotifications`, called from `navmenu.js`) against `/api/notifications*`. Bell UI lives in `resources/views/layouts/partials/notification-bell.blade.php`. A dev-only `/page_notification_test` page (superadmin-gated) exercises all three target modes.
- Dynamic mailer — `MailerSetting` model, `MailerController`, admin-configurable SMTP settings instead of static `.env` mail config

**Middleware of note** (`app/Http/Kernel.php` aliases):
- `check.status` (`CheckUserStatus`) — force-logs-out and redirects users whose `status === 1` (inactive); applied on the main authenticated `web.php` group
- `prevent-back-history` (`PreventBackHistory`) — applied alongside `check.status`
- `EnsureSingleSession` (registered globally in the `web` group) — on every authenticated request, deletes any other active session rows for that user in the `sessions` table, enforcing single-session-per-user by force-logging out other sessions
- `SafeText` — validates POST/PUT/PATCH string input against a restrictive allowed-character regex, returns 422 on violation (available but check where it's actually applied before assuming it runs everywhere)
- `EnsurePermission` (`permission:*`) — checks a named permission against the current user's role, used e.g. on role-management mutation routes
- `ThemeMiddleware` — available but check usage before assuming it's wired into a given route group

**Deployment layout** (see README): production deployment splits the repo into `app_core/` (all Laravel framework files: app, bootstrap, config, database, resources, routes, storage, vendor) with only `public/` exposed as the web root. `public/index.php` needs its relative paths updated to point at `app_core/` when restructured this way. Always run `npm run build` before restructuring for deployment. Never commit `.env`.
