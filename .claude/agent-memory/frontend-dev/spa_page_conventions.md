---
name: spa-page-conventions
description: How RMSv1's AJAX SPA page system works — loadPage, apiCall response shape, renderRemoteTable, no Alpine on injected fragments
metadata:
  type: project
---

RMSv1 (Laravel 10 Blade + Tailwind) loads pages into `#content` via AJAX (SPA-style). Confirmed while building the recruitment Applicant pages ([[recruitment-applicant-pages]]).

Key facts, verified against `resources/js/navmenu.js`, `resources/js/apihandler.js`, `resources/js/remoteTable.js`, `resources/views/pages/settings/usersmanagement.blade.php`:

- Every page-level `<script>` block must live at the bottom of the Blade file and be wrapped in `(function(){ ... })();` — it re-executes on every SPA navigation into that page, so nothing should leak/register globally outside the IIFE.
- Alpine.js does NOT initialize on AJAX-injected fragments in this app — plain vanilla JS only for page-level interactivity.
- Global nav helper: `window.loadPage({title, link})` (defined in navmenu.js) — navigate between SPA pages, e.g. `loadPage({title:'Applicants', link:'/page_applicants'})`.
- `apiCall({mode, isJson, payload, url, button})` (apihandler.js): GET ignores payload; JSON mutations use `isJson:true` + plain object (apiCall does `JSON.stringify` internally — never stringify yourself); file uploads use `isJson:false` + a raw `FormData` object (browser sets multipart headers, do not touch headers yourself). Method `mode` is used as-is for plain JSON mutations (e.g. `'PATCH'` for JSON updates) — no method-spoofing needed there.
  - EXCEPTION: FormData (multipart) bodies sent to a route registered as `PATCH`/`PUT` in `routes/api.php` MUST use Laravel method spoofing, not a native PATCH/PUT. Reason: PHP only populates `$_POST`/`$_FILES` (and thus Laravel's `form_data`/`files` inputs) from a multipart body on a POST request — never on PATCH/PUT — so a native multipart PATCH reaches the controller with empty fields and silently fails validation. Fix: `mode: 'POST'`, `isJson: false`, `payload: formData` with `formData.append('_method', 'PATCH')` (or `'PUT'`) added to the FormData; Laravel resolves the spoofed method from the POST body to the PATCH/PUT route. Confirmed by tech lead 2026-08-05 for `ApplicantController::interview()` (`PATCH /api/applicants/{id}/interview`, multipart `form_data[...]`/`files[...]`/`outcome`). Only applies when the payload is FormData; JSON PATCH/PUT calls are unaffected.
- Response shape: success resolves `{success:true, data:...}`. Error responses may have the parsed body nested under `.response` — the standard defensive-handling snippet is:
  ```js
  if (!res || res.success !== true) {
    const err = (res && res.response) ? res.response : (res || {});
    const msg = err.invalid_fields ? Object.values(err.invalid_fields).flat().join(' ') : (err.message || 'Request failed.');
    showMessage({status:'error', title:'Error', message: msg});
    return;
  }
  ```
- Tables: `<x-table id="..." />` Blade component renders search box + `<table>` + pagination scaffold (classes: `.table-search-input`, `.table-search-button`, `.table-header`, `.table-body`, `.table-pagination`). Bind it with `window.renderRemoteTable({url, tableId, afterRenderFunction, thead})` — `thead` entries are `{title, key}` (dot-path lookup via `getValueByPath`) or `{title, render:(row)=>html}`. Returns a table controller object (`.load(page)`, `.reload()`, `.setFilter(key,value)`, `.setFilters(obj)`, `.search(term)`, `.goToPage(page)`) — nothing auto-loads, you must call `.load(1)` yourself. Row click handling pattern (mirrored from usersmanagement.blade.php): in `afterRenderFunction(row)`, add a click listener and `JSON.parse(row.dataset.row)` to get the full row object (the whole row is serialized into `data-row` by `renderRemoteTable`).
- `<x-side-modal id="...">` — only slot content, no custom modal/slideover markup. Opened via `initSideModal({modalId})`, closed via `closeSideModal(modalId)` or a `.modal-close` button inside it.
- Blade directives (`@if`, `auth()->user()`, etc.) work fine in these pages even though delivered via AJAX, because the fragment is still server-rendered by Laravel before being sent to the client — confirmed by rendering `applicants.blade.php`'s `@if(auth()->user()->is_team_leader)` guard through `view()->file(...)->render()` with no authenticated user in context (property access on null returns null in PHP 8, doesn't throw, so the guard degrades safely when logged out).
