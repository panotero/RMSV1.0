---
name: project-recruitment-module
description: RMS Recruitment module — DB layer, App-Settings admin endpoints, Applicant API + scheduled command, and conditional/dependent form fields (all as of 2026-08-04) are done; no frontend yet
metadata:
  type: project
---

The Recruitment module's database layer (migrations, Eloquent models, RecruitmentFormSeeder) was
built on 2026-08-04, scoped explicitly to DB-only work — no controllers, routes, or frontend were
created in that pass.

**Update 2026-08-04 (later same day):** Two more pieces landed on top of the DB layer:
- App-Settings admin endpoints (a separate task, already present when I picked up the Applicant API):
  `LookupListController`, `ChecklistItemController`, `RecruitmentFormController`, routed under
  `/api/lookupLists`, `/api/checklistItems`, `/api/recruitmentForm`, all gated `can:isSuperAdmin`.
- The Applicant API (`App\Http\Controllers\ApplicantController`, routes under `/api/applicants`) and
  a scheduled command `recruitment:notify-unprocessed` (`app/Console/Commands/NotifyUnprocessedApplicants.php`,
  scheduled dailyAt 17:00 in `app/Console/Kernel.php`). Still no frontend for applicants (list/create/detail
  pages) — that's a separate task.

**Update 2026-08-04 (third pass, backend-only): conditional/dependent form fields.**
`recruitment_form_fields` gained two nullable columns, `condition_field_key` and `condition_value`
(migration `2026_08_04_000020_add_condition_columns...`), plumbed through
`RecruitmentFormField::$fillable`, `RecruitmentFormController::storeField/updateField` (validated +
persisted, NOT part of the version-bump rule — only `type`/`options` changes bump `RecruitmentForm.version`),
and `ApplicantController::formConfig()` (now returns both keys per field). `ApplicantController::store()`
skips the required-check entirely for a field whose `condition_field_key` is set and whose submitted
controlling value (string-cast) doesn't match `condition_value` (string-cast) — i.e. a currently-hidden
conditional field is never treated as missing. Two fields are seeded with real conditions:
`auto_insurance_note` shows when `auto_insurance == 'No'`; `allergies_detail` shows when
`has_allergies == 'Yes'`. All other fields have both columns null. This is backend-only — the intake
form UI (show/hide wiring) is not built yet, that's frontend work for whoever picks this up next.

**Correction to the "known placeholders" note below:** the 5 seeded `checklist_items` placeholders
(reference check, background check, TB test, CPR cert, offer letter) were REMOVED on 2026-08-04 per
updated product direction — the client defines their own checklist items via the admin UI.
`RecruitmentFormSeeder` no longer seeds any `checklist_items` rows (section D is now empty by design,
not an oversight). Also, the 'Add Applicant' nav_menus child entry (link `/page_applicant_new`) was
removed from `NavMenuSeeder` — adding an applicant is becoming a side modal on the Applicants list
page instead of a separate nav-linked page. The `/page_applicant_new` route/controller method itself
was intentionally left in place (unlinked, not deleted).

Team-scoping rule implemented in `ApplicantController::scopedQuery()`: superadmin sees all; user with
no `team_id` sees only their own `assigned_to` records; team leader sees whole team by default but
`?scope=mine` narrows to their own; regular team member always sees whole team (no toggle).

The seeded active `RecruitmentForm` (as of this pass) has 33 fields, 0 of which are `type=file` — so
the file-upload branch of `ApplicantController::store()` (files keyed by field_key under `files.*`,
stored via `Storage::disk('public')`) was verified by code review + lint only, not exercised end-to-end.
If a `file`-type field gets added to the form later, that path is worth a real test pass.

Tables: `recruitment_forms`, `lookup_lists`, `lookup_list_items`, `recruitment_form_fields`,
`checklist_items`, `applicants`, `applicant_files`, `applicant_checklist_items`. Migrations use the
`2026_08_04_0000NN_*` prefix, numbered 000010-000017 (000001 was already taken by
`create_notifications_table`).

Models live in `app/Models`: RecruitmentForm, RecruitmentFormField, LookupList, LookupListItem,
ChecklistItem, Applicant, ApplicantFile, ApplicantChecklistItem.

**Why:** This is the foundation for a caregiver-recruitment applicant tracking feature built on top
of the admin-template base described in CLAUDE.md. The seeded "Caregiver Application" form (33
fields) and its lookup lists are the first concrete evidence of what this app's actual product
domain will be (CLAUDE.md currently says "no specific product domain has been decided yet" — that
may need updating once this feature ships).

Known placeholders seeded intentionally (not bugs, don't "fix" without asking):
- `location` lookup list has zero items — real branch/office names are unknown, admins fill via UI.
- `checklist_items` is seeded EMPTY (as of 2026-08-04, see correction above) — same reasoning as
  `location`, real values unknown, admins define via UI.
- `source` lookup list items (LinkedIn, Employee Referral, Job Board, Walk-in, Other) are a
  reasonable starter default, not confirmed real-world values.
- The `referral_source` form field intentionally stores `options: null` — its options are meant to
  be resolved at runtime from the `source` lookup list, not hardcoded in `recruitment_form_fields`.

**How to apply:** When picking up controllers/routes/frontend for this module, expect to build
against this schema as-is. Check whether these placeholder lookup values have since been edited via
an admin UI before assuming the seeded defaults are still current.
