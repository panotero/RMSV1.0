<div class="container mx-auto p-3">

    {{-- PAGE HEADER --}}
    <div class="flex justify-between items-center mb-5 p-2">
        <div>
            <h1 class="text-2xl font-bold dark:text-white">App Settings</h1>
            <p class="text-zinc-500">Manage the recruitment application form, lookup lists, and onboarding checklist
            </p>
        </div>
    </div>

    {{-- TAB BAR --}}
    <div class="border-b border-zinc-200 dark:border-zinc-700 mb-5">
        <nav class="flex gap-6" id="appSettingsTabs">
            <button type="button" data-tab="form"
                class="app-settings-tab px-1 pb-3 text-sm font-medium border-b-2 -mb-px transition">
                Form Management
            </button>
            <button type="button" data-tab="lookup"
                class="app-settings-tab px-1 pb-3 text-sm font-medium border-b-2 -mb-px transition">
                Lookup Lists
            </button>
            <button type="button" data-tab="checklist"
                class="app-settings-tab px-1 pb-3 text-sm font-medium border-b-2 -mb-px transition">
                Checklist
            </button>
        </nav>
    </div>

    {{-- ============================================================ --}}
    {{-- TAB 1: FORM MANAGEMENT --}}
    {{-- ============================================================ --}}
    <div data-panel="form">

        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
                <p class="text-sm font-medium text-zinc-800 dark:text-zinc-100" id="formNameDisplay">—</p>
                <span id="formVersionBadge"
                    class="text-[10px] font-semibold uppercase tracking-widest bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 rounded-full px-2 py-0.5">v-</span>
            </div>
            <button type="button" id="btnAddField"
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                + Add Field
            </button>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr>
                        <th
                            class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wide bg-orange-500 text-white">
                            Order</th>
                        <th
                            class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wide bg-orange-500 text-white">
                            Label</th>
                        <th
                            class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wide bg-orange-500 text-white">
                            Key</th>
                        <th
                            class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wide bg-orange-500 text-white">
                            Type</th>
                        <th
                            class="px-4 py-2.5 text-center text-xs font-medium uppercase tracking-wide bg-orange-500 text-white">
                            Required</th>
                        <th
                            class="px-4 py-2.5 text-center text-xs font-medium uppercase tracking-wide bg-orange-500 text-white">
                            Actions</th>
                    </tr>
                </thead>
                <tbody id="fieldsTableBody" class="divide-y divide-zinc-100 dark:divide-zinc-800"></tbody>
            </table>
        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- TAB 2: LOOKUP LISTS --}}
    {{-- ============================================================ --}}
    <div data-panel="lookup" class="hidden">

        <div class="grid grid-cols-1 md:grid-cols-[260px_1fr] gap-4">

            {{-- LEFT: lists --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden h-fit">
                <div class="px-4 py-3 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center gap-2">
                    <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Lookup Lists</p>
                    <button type="button" id="btnAddLookupList"
                        class="text-orange-500 hover:text-orange-600 text-xs font-medium transition shrink-0">
                        + Add List
                    </button>
                </div>
                <div id="lookupListsContainer" class="divide-y divide-zinc-100 dark:divide-zinc-800"></div>
            </div>

            {{-- RIGHT: items --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4">
                <div class="flex justify-between items-center mb-3">
                    <p class="text-sm font-medium text-zinc-800 dark:text-zinc-100" id="lookupSelectedListTitle">—
                    </p>
                    <button type="button" id="btnAddLookupItem"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                        + Add Item
                    </button>
                </div>

                <div id="lookupItemsContainer" class="space-y-2"></div>
            </div>

        </div>

    </div>

    {{-- ============================================================ --}}
    {{-- TAB 3: CHECKLIST --}}
    {{-- ============================================================ --}}
    <div data-panel="checklist" class="hidden">


        <div class="grid grid-cols-1 md:grid-cols-[280px_1fr] gap-4">

            {{-- LEFT: groups --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden h-fit">
                <div class="px-4 py-3 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center gap-2">
                    <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Groups</p>
                    <button type="button" id="btnAddChecklistGroup"
                        class="text-orange-500 hover:text-orange-600 text-xs font-medium transition shrink-0">
                        + Add Group
                    </button>
                </div>
                <div id="checklistGroupsContainer" class="divide-y divide-zinc-100 dark:divide-zinc-800"></div>
            </div>

            {{-- RIGHT: items --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4">
                <div class="flex justify-between items-center mb-1">
                    <p class="text-sm font-medium text-zinc-800 dark:text-zinc-100" id="checklistSelectedGroupTitle">
                        —</p>
                    <button type="button" id="btnAddChecklistItem"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                        + Add Item
                    </button>
                </div>
                <p class="text-xs text-zinc-400 mb-3" id="checklistSelectedGroupSubtitle"></p>

                <div id="checklistItemsContainer" class="space-y-2"></div>
            </div>

        </div>

    </div>

</div>

{{-- FIELD ADD/EDIT MODAL --}}
<x-modal id="fieldModal">
    <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
        <p class="text-lg font-semibold dark:text-white" id="fieldModalTitle">Add Field</p>
        <button class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">✕</button>
    </div>

    <form id="fieldForm" class="p-5 space-y-4 text-sm max-h-[65vh] overflow-y-auto">
        <input type="hidden" id="fieldId">

        {{-- Field Key (edit mode only) --}}
        <div class="flex flex-col gap-1 hidden" id="fieldKeyWrapper">
            <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Field Key</label>
            <input type="text" id="fieldKey" disabled
                class="w-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-500 dark:text-zinc-400 font-mono cursor-not-allowed">
            <p class="text-xs text-zinc-400">Key is permanent and cannot be changed.</p>
        </div>

        {{-- Label --}}
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Label</label>
            <input type="text" id="fieldLabel" required
                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
        </div>

        {{-- Type --}}
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Type</label>
            <select id="fieldType"
                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
                <option value="text">Text</option>
                <option value="textarea">Textarea</option>
                <option value="number">Number</option>
                <option value="date">Date</option>
                <option value="select">Select</option>
                <option value="radio">Radio</option>
                <option value="checkbox">Checkbox</option>
                <option value="file">File</option>
            </select>
        </div>

        {{-- Options (select/radio/checkbox only) --}}
        <div class="flex flex-col gap-1 hidden" id="fieldOptionsWrapper">
            <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Options source</label>
            <select id="fieldOptionsSource"
                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
                <option value="">Custom (type below)</option>
            </select>

            <div class="flex flex-col gap-1 mt-2" id="fieldOptionsCustomWrapper">
                <textarea id="fieldOptions" rows="4" placeholder="Option A&#10;Option B&#10;Option C"
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition"></textarea>
                <p class="text-xs text-zinc-400">One option per line.</p>
            </div>

            <p class="text-xs text-zinc-400 mt-2 hidden" id="fieldOptionsSourceNote"></p>
        </div>

        {{-- Required --}}
        <label class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-200">
            <input type="checkbox" id="fieldRequired" class="rounded border-zinc-300 text-orange-500 focus:ring-orange-400 cursor-pointer">
            Required
        </label>

        {{-- Help text --}}
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Help Text</label>
            <input type="text" id="fieldHelpText"
                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
        </div>

        {{-- Conditional visibility --}}
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Show only when field</label>
            <select id="fieldConditionKey"
                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
                <option value="">Always show</option>
            </select>
            <p class="text-xs text-zinc-400">Optional. The field appears only when the chosen field equals the value below.</p>
        </div>
        <div class="flex flex-col gap-1" id="fieldConditionValueWrapper">
            <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Equals value</label>
            <input type="text" id="fieldConditionValue"
                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition"
                placeholder="e.g. No">
        </div>

        {{-- Order (edit mode only) --}}
        <div class="flex flex-col gap-1 hidden" id="fieldOrderWrapper">
            <label class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Order</label>
            <input type="number" id="fieldOrder"
                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition">
        </div>
    </form>

    <div class="border-t border-zinc-100 dark:border-zinc-800 px-5 py-4 flex justify-end gap-2">
        <button type="button"
            class="modal-close px-4 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
            Cancel
        </button>
        <button type="button" id="saveFieldBtn"
            class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
            Save Field
        </button>
    </div>
</x-modal>

{{-- ADD LOOKUP LIST SIDE MODAL --}}
<x-side-modal id="addLookupListSideModal">

    {{-- Header --}}
    <div
        class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
        <div>
            <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Lookup Lists</p>
            <p class="text-lg font-semibold dark:text-white mt-0.5">Add List</p>
        </div>
        <button
            class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
            ✕
        </button>
    </div>

    {{-- Body --}}
    <div class="p-5">
        <form id="lookupListForm" class="space-y-4">
            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">List name
                    <span class="text-red-500">*</span></label>
                <input type="text" id="lookupListNameInput" required placeholder="e.g. Department"
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                <p class="text-xs text-zinc-400">Creates a new dropdown list you can populate with items below. A new
                    list isn't automatically offered as options on a form field yet — that's still a manual step.</p>
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Sub-item label
                    (optional)</label>
                <input type="text" id="lookupListChildLabelInput" placeholder="e.g. Location"
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                <p class="text-xs text-zinc-400">Only set this if items in this list can each have their own nested
                    items — e.g. Territory items nesting Locations. Leave blank for a flat list.</p>
            </div>
        </form>
    </div>

    {{-- Footer --}}
    <div
        class="border-t border-zinc-100 dark:border-zinc-800 px-5 py-4 flex justify-end gap-2 sticky bottom-0 bg-white dark:bg-zinc-900">
        <button type="button"
            class="modal-close px-4 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
            Cancel
        </button>
        <button type="button" id="saveLookupListBtn"
            class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
            Save List
        </button>
    </div>

</x-side-modal>

{{-- ADD LOOKUP LIST ITEM SIDE MODAL --}}
<x-side-modal id="addLookupItemSideModal">

    {{-- Header --}}
    <div
        class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
        <div>
            <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest" id="lookupItemModalListLabel">
                Lookup List</p>
            <p class="text-lg font-semibold dark:text-white mt-0.5" id="lookupItemModalTitle">Add Item</p>
        </div>
        <button
            class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
            ✕
        </button>
    </div>

    {{-- Body --}}
    <div class="p-5">
        <form id="lookupItemForm" class="space-y-4">
            <input type="hidden" id="lookupItemId">

            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Item name
                    <span class="text-red-500">*</span></label>
                <input type="text" id="lookupItemNameInput" required placeholder="e.g. New York"
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
            </div>
            <div class="flex flex-col gap-1" id="lookupItemParentWrapper">
                <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Parent (optional)</label>
                <select id="lookupItemParentSelect"
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    <option value="">— None (top-level) —</option>
                </select>
                <p class="text-xs text-zinc-400">Nest this item under a top-level item — e.g. a Location under a
                    Territory.</p>
            </div>

            {{-- Child rows (e.g. Locations under a Territory) - only shown for a
                 top-level item on a list that defines a child_label --}}
            <div class="flex flex-col gap-2 hidden" id="lookupItemChildrenWrapper">
                <div class="flex justify-between items-center">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400"
                        id="lookupItemChildrenLabel">Sub-items</label>
                    <button type="button" id="lookupItemAddChildRow"
                        class="text-orange-500 hover:text-orange-600 text-xs font-medium transition">
                        + Add row
                    </button>
                </div>
                <div id="lookupItemChildrenRows" class="space-y-2"></div>
                <p class="text-xs text-zinc-400" id="lookupItemChildrenNote"></p>
            </div>
        </form>
    </div>

    {{-- Footer --}}
    <div
        class="border-t border-zinc-100 dark:border-zinc-800 px-5 py-4 flex justify-end gap-2 sticky bottom-0 bg-white dark:bg-zinc-900">
        <button type="button"
            class="modal-close px-4 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
            Cancel
        </button>
        <button type="button" id="saveLookupItemBtn"
            class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
            Save Item
        </button>
    </div>

</x-side-modal>

{{-- ADD/EDIT CHECKLIST GROUP SIDE MODAL --}}
<x-side-modal id="checklistGroupSideModal">

    {{-- Header --}}
    <div
        class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
        <div>
            <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Checklist</p>
            <p class="text-lg font-semibold dark:text-white mt-0.5" id="checklistGroupModalTitle">Add Group</p>
        </div>
        <button
            class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
            ✕
        </button>
    </div>

    {{-- Body --}}
    <div class="p-5">
        <form id="checklistGroupForm" class="space-y-4">
            <input type="hidden" id="checklistGroupId">

            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Group name
                    <span class="text-red-500">*</span></label>
                <input type="text" id="checklistGroupLabelInput" required placeholder="e.g. Orientation"
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Target status
                    <span class="text-red-500">*</span></label>
                <select id="checklistGroupTargetStatusInput" required
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    <option value="">Select status</option>
                </select>
                <p class="text-xs text-zinc-400">Applicant status set automatically once every item in this group is
                    checked. Options come from the managed Status lookup list — add or edit statuses there.</p>
            </div>
        </form>
    </div>

    {{-- Footer --}}
    <div
        class="border-t border-zinc-100 dark:border-zinc-800 px-5 py-4 flex justify-end gap-2 sticky bottom-0 bg-white dark:bg-zinc-900">
        <button type="button"
            class="modal-close px-4 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
            Cancel
        </button>
        <button type="button" id="saveChecklistGroupBtn"
            class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
            Save Group
        </button>
    </div>

</x-side-modal>

{{-- ADD/EDIT CHECKLIST ITEM SIDE MODAL --}}
<x-side-modal id="checklistItemSideModal">

    {{-- Header --}}
    <div
        class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
        <div>
            <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Checklist</p>
            <p class="text-lg font-semibold dark:text-white mt-0.5" id="checklistItemModalTitle">Add Item</p>
        </div>
        <button
            class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
            ✕
        </button>
    </div>

    {{-- Body --}}
    <div class="p-5">
        <form id="checklistItemForm" class="space-y-4">
            <input type="hidden" id="checklistItemId">

            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Item label
                    <span class="text-red-500">*</span></label>
                <input type="text" id="checklistItemLabelInput" required placeholder="e.g. Background check"
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Group</label>
                <select id="checklistItemGroupSelect"
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    <option value="">Ungrouped (informational only)</option>
                </select>
            </div>
        </form>
    </div>

    {{-- Footer --}}
    <div
        class="border-t border-zinc-100 dark:border-zinc-800 px-5 py-4 flex justify-end gap-2 sticky bottom-0 bg-white dark:bg-zinc-900">
        <button type="button"
            class="modal-close px-4 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
            Cancel
        </button>
        <button type="button" id="saveChecklistItemBtn"
            class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
            Save Item
        </button>
    </div>

</x-side-modal>

{{-- JS --}}
<script>
    (function() {
        const OPTION_TYPES = ['select', 'radio', 'checkbox'];

        const TAB_PANELS = {
            form: document.querySelector('[data-panel="form"]'),
            lookup: document.querySelector('[data-panel="lookup"]'),
            checklist: document.querySelector('[data-panel="checklist"]'),
        };

        const tabButtons = Array.from(document.querySelectorAll('.app-settings-tab'));
        const loadedTabs = {
            form: false,
            lookup: false,
            checklist: false,
        };

        let activeFormFields = [];
        let lookupLists = [];
        let selectedLookupListId = null;
        let checklistItems = [];
        let checklistGroups = [];
        let selectedChecklistGroupId = null;

        // ------------------------------------------------------------
        // TABS
        // ------------------------------------------------------------
        function setActiveTab(tab) {
            tabButtons.forEach(btn => {
                const isActive = btn.dataset.tab === tab;
                btn.classList.toggle('text-orange-500', isActive);
                btn.classList.toggle('border-orange-500', isActive);
                btn.classList.toggle('text-zinc-500', !isActive);
                btn.classList.toggle('dark:text-zinc-400', !isActive);
                btn.classList.toggle('border-transparent', !isActive);
            });

            Object.keys(TAB_PANELS).forEach(key => {
                TAB_PANELS[key].classList.toggle('hidden', key !== tab);
            });

            if (!loadedTabs[tab]) {
                loadedTabs[tab] = true;
                if (tab === 'form') loadActiveForm();
                if (tab === 'lookup') loadLookupLists();
                if (tab === 'checklist') loadChecklistData();
            }
        }

        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => setActiveTab(btn.dataset.tab));
        });

        // ------------------------------------------------------------
        // TAB 1: FORM MANAGEMENT
        // ------------------------------------------------------------
        function emptyFieldsState() {
            return `<tr><td colspan="6" class="text-center py-8 text-zinc-400 text-sm">No fields yet. Add the first one above.</td></tr>`;
        }

        async function loadActiveForm() {
            const res = await apiCall({
                mode: 'GET',
                url: '/api/recruitmentForm/active'
            });

            if (!res || res.success !== true) {
                const err = (res && res.response) ? res.response : (res || {});
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: err.message || 'Failed to load the recruitment form.'
                });
                return;
            }

            const form = res.data || {};
            document.getElementById('formNameDisplay').textContent = form.name || '—';
            document.getElementById('formVersionBadge').textContent = `v${form.version ?? '-'}`;

            activeFormFields = Array.isArray(form.fields) ? [...form.fields].sort((a, b) => (a.order ?? 0) - (b
                .order ?? 0)) : [];

            renderFieldsTable();
        }

        function renderFieldsTable() {
            const tbody = document.getElementById('fieldsTableBody');

            if (!activeFormFields.length) {
                tbody.innerHTML = emptyFieldsState();
                return;
            }

            const ordered = orderFieldsWithConditionalChildren(activeFormFields);

            tbody.innerHTML = ordered.map(field => {
                const isConditional = Boolean(field.condition_field_key);
                const typeLabel = field.options_source_list_id
                    ? `${field.type} <span class="text-zinc-400">(${field.options_source_list?.label ?? 'lookup list'})</span>`
                    : field.type;

                return `
                <tr>
                    <td class="px-4 py-2.5 text-zinc-500 dark:text-zinc-400">${field.order ?? '-'}</td>
                    <td class="px-4 py-2.5 text-zinc-800 dark:text-zinc-100">
                        ${isConditional ? '<span class="text-zinc-300 dark:text-zinc-600">&#8627;</span> ' : ''}${field.label}
                    </td>
                    <td class="px-4 py-2.5 font-mono text-xs text-zinc-500 dark:text-zinc-400">${field.field_key}</td>
                    <td class="px-4 py-2.5 text-zinc-500 dark:text-zinc-400">${typeLabel}</td>
                    <td class="px-4 py-2.5 text-center">
                        <span class="text-[10px] font-semibold uppercase tracking-widest rounded-full px-2 py-0.5 ${field.is_required ? 'bg-orange-100 text-orange-700' : 'bg-zinc-100 text-zinc-500'}">
                            ${field.is_required ? 'Yes' : 'No'}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        <div class="flex justify-center gap-2">
                            <button type="button" class="btn-edit-field text-xs font-medium text-blue-600 hover:underline" data-id="${field.id}">Edit</button>
                            <button type="button" class="btn-delete-field text-xs font-medium text-red-600 hover:underline" data-id="${field.id}">Delete</button>
                        </div>
                    </td>
                </tr>
            `;
            }).join('');
        }

        // Fields conditional on another field are displayed directly below
        // their target field, regardless of their raw `order` value.
        function orderFieldsWithConditionalChildren(fields) {
            const byKey = new Map();
            fields.forEach(f => {
                if (f.field_key) byKey.set(f.field_key, f);
            });

            const childrenByParentKey = new Map();
            const roots = [];

            fields.forEach(f => {
                const parentKey = f.condition_field_key;
                if (parentKey && byKey.has(parentKey) && byKey.get(parentKey) !== f) {
                    if (!childrenByParentKey.has(parentKey)) childrenByParentKey.set(parentKey, []);
                    childrenByParentKey.get(parentKey).push(f);
                } else {
                    roots.push(f);
                }
            });

            const ordered = [];
            const visited = new Set();

            function emit(field) {
                if (visited.has(field.id)) return;
                visited.add(field.id);
                ordered.push(field);
                (childrenByParentKey.get(field.field_key) || []).forEach(emit);
            }

            roots.forEach(emit);

            return ordered;
        }

        function toggleFieldOptionsVisibility() {
            const type = document.getElementById('fieldType').value;
            document.getElementById('fieldOptionsWrapper').classList.toggle('hidden', !OPTION_TYPES.includes(
                type));
        }

        function populateFieldOptionsSourceSelect() {
            const select = document.getElementById('fieldOptionsSource');
            const current = select.value;

            select.innerHTML = '<option value="">Custom (type below)</option>' +
                lookupLists.map(list => `<option value="${list.id}">${list.label}</option>`).join('');

            select.value = current;
        }

        function toggleOptionsSourceMode() {
            const select = document.getElementById('fieldOptionsSource');
            const listId = select.value;
            const note = document.getElementById('fieldOptionsSourceNote');

            document.getElementById('fieldOptionsCustomWrapper').classList.toggle('hidden', Boolean(listId));

            if (listId) {
                const list = lookupLists.find(l => String(l.id) === String(listId));
                note.textContent = `Options come from the "${list ? list.label : 'selected'}" lookup list — managed on the Lookup Lists tab, not here.`;
                note.classList.remove('hidden');
            } else {
                note.classList.add('hidden');
            }
        }

        function toggleFieldConditionValueVisibility() {
            const conditionKey = document.getElementById('fieldConditionKey').value;
            document.getElementById('fieldConditionValueWrapper').classList.toggle('hidden', !conditionKey);
        }

        function populateFieldConditionKeyOptions(field) {
            const select = document.getElementById('fieldConditionKey');
            const options = activeFormFields.filter(f => f.id !== field?.id);

            select.innerHTML = `<option value="">Always show</option>` + options.map(f =>
                `<option value="${f.field_key}">${f.label}</option>`
            ).join('');
        }

        async function openFieldModal(field = null) {
            const form = document.getElementById('fieldForm');
            form.reset();

            if (!lookupLists.length) {
                await loadLookupLists();
            }

            document.getElementById('fieldId').value = field?.id ?? '';
            document.getElementById('fieldLabel').value = field?.label ?? '';
            document.getElementById('fieldType').value = field?.type ?? 'text';
            document.getElementById('fieldOptions').value = Array.isArray(field?.options) ? field.options.join(
                '\n') : '';
            document.getElementById('fieldRequired').checked = Boolean(field?.is_required);
            document.getElementById('fieldHelpText').value = field?.help_text ?? '';
            document.getElementById('fieldOrder').value = field?.order ?? '';
            document.getElementById('fieldKey').value = field?.field_key ?? '';

            populateFieldOptionsSourceSelect();
            document.getElementById('fieldOptionsSource').value = field?.options_source_list_id ?? '';
            toggleOptionsSourceMode();

            populateFieldConditionKeyOptions(field);
            document.getElementById('fieldConditionKey').value = field?.condition_field_key ?? '';
            document.getElementById('fieldConditionValue').value = field?.condition_value ?? '';
            toggleFieldConditionValueVisibility();

            document.getElementById('fieldModalTitle').textContent = field ? 'Edit Field' : 'Add Field';
            document.getElementById('fieldKeyWrapper').classList.toggle('hidden', !field);
            document.getElementById('fieldOrderWrapper').classList.toggle('hidden', !field);

            toggleFieldOptionsVisibility();

            initModal({
                modalId: 'fieldModal'
            });
        }

        document.getElementById('fieldType').addEventListener('change', toggleFieldOptionsVisibility);
        document.getElementById('fieldOptionsSource').addEventListener('change', toggleOptionsSourceMode);
        document.getElementById('fieldConditionKey').addEventListener('change', toggleFieldConditionValueVisibility);

        document.getElementById('btnAddField').addEventListener('click', () => openFieldModal(null));

        document.getElementById('fieldsTableBody').addEventListener('click', async (e) => {
            const editBtn = e.target.closest('.btn-edit-field');
            const deleteBtn = e.target.closest('.btn-delete-field');

            if (editBtn) {
                const field = activeFormFields.find(f => String(f.id) === String(editBtn.dataset.id));
                if (field) openFieldModal(field);
                return;
            }

            if (deleteBtn) {
                const confirmed = await customConfirm(
                    'Deactivate this field? Existing applicants keep their answers.');
                if (!confirmed) return;

                const res = await apiCall({
                    mode: 'DELETE',
                    url: `/api/recruitmentForm/fields/${deleteBtn.dataset.id}`
                });

                if (!res || res.success !== true) {
                    const err = (res && res.response) ? res.response : (res || {});
                    showMessage({
                        status: 'error',
                        title: 'Error',
                        message: err.message || 'Failed to delete field.'
                    });
                    return;
                }

                showMessage({
                    status: 'success',
                    title: 'Field deactivated!'
                });
                await loadActiveForm();
            }
        });

        document.getElementById('saveFieldBtn').addEventListener('click', async function() {
            const fieldId = document.getElementById('fieldId').value;
            const isEdit = Boolean(fieldId);

            const label = document.getElementById('fieldLabel').value.trim();
            const type = document.getElementById('fieldType').value;

            if (!label) {
                document.getElementById('fieldLabel').focus();
                return;
            }

            const optionsSourceListId = document.getElementById('fieldOptionsSource').value || null;

            let options = null;
            if (OPTION_TYPES.includes(type) && !optionsSourceListId) {
                const lines = document.getElementById('fieldOptions').value
                    .split('\n')
                    .map(line => line.trim())
                    .filter(line => line.length > 0);
                options = lines.length ? lines : null;
            }

            const conditionFieldKey = document.getElementById('fieldConditionKey').value || null;

            const payload = {
                label,
                type,
                options,
                options_source_list_id: OPTION_TYPES.includes(type) ? (optionsSourceListId ? Number(
                    optionsSourceListId) : null) : null,
                is_required: document.getElementById('fieldRequired').checked,
                help_text: document.getElementById('fieldHelpText').value.trim() || null,
                condition_field_key: conditionFieldKey,
                condition_value: conditionFieldKey ?
                    (document.getElementById('fieldConditionValue').value.trim() || null) : null,
            };

            if (isEdit) {
                const orderVal = document.getElementById('fieldOrder').value;
                payload.order = orderVal !== '' ? Number(orderVal) : null;
            }

            const res = await apiCall({
                mode: isEdit ? 'PUT' : 'POST',
                isJson: true,
                payload,
                url: isEdit ? `/api/recruitmentForm/fields/${fieldId}` : '/api/recruitmentForm/active/fields',
                button: this,
            });

            if (!res || res.success !== true) {
                const err = (res && res.response) ? res.response : (res || {});
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: err.message || 'Failed to save field.'
                });
                return;
            }

            showMessage({
                status: 'success',
                title: isEdit ? 'Field updated!' : 'Field added!'
            });

            if (isEdit && res.version_bumped === true) {
                showMessage({
                    status: 'warning',
                    title: 'Form version bumped',
                    message: 'Form version bumped to keep existing applicants\' answers consistent.'
                });
            }

            document.querySelector('#fieldModal .modal-close').click();
            await loadActiveForm();
        });

        // ------------------------------------------------------------
        // TAB 2: LOOKUP LISTS
        // ------------------------------------------------------------
        function emptyLookupItemsState() {
            return `<p class="text-sm text-zinc-400 py-6 text-center">No items yet. Add the first one above.</p>`;
        }

        async function loadLookupLists() {
            const res = await apiCall({
                mode: 'GET',
                url: '/api/lookupLists'
            });

            if (!res || res.success !== true) {
                const err = (res && res.response) ? res.response : (res || {});
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: err.message || 'Failed to load lookup lists.'
                });
                return;
            }

            lookupLists = Array.isArray(res.data) ? res.data : [];

            if (!selectedLookupListId && lookupLists.length) {
                selectedLookupListId = lookupLists[0].id;
            }

            renderLookupLists();
            renderLookupItems();
        }

        function renderLookupLists() {
            const container = document.getElementById('lookupListsContainer');

            if (!lookupLists.length) {
                container.innerHTML = `<p class="text-xs text-zinc-400 p-4">No lookup lists found.</p>`;
                return;
            }

            container.innerHTML = lookupLists.map(list => `
                <button type="button" class="lookup-list-btn w-full text-left px-4 py-2.5 text-sm transition ${String(list.id) === String(selectedLookupListId) ? 'bg-orange-50 dark:bg-zinc-800 text-orange-600 font-medium' : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-800'}"
                    data-id="${list.id}">
                    ${list.label}
                </button>
            `).join('');
        }

        function renderLookupItems() {
            const titleEl = document.getElementById('lookupSelectedListTitle');
            const container = document.getElementById('lookupItemsContainer');

            const list = lookupLists.find(l => String(l.id) === String(selectedLookupListId));

            if (!list) {
                titleEl.textContent = '—';
                container.innerHTML = emptyLookupItemsState();
                return;
            }

            titleEl.textContent = list.label;

            const allItems = Array.isArray(list.items) ? list.items : [];

            if (!allItems.length) {
                container.innerHTML = emptyLookupItemsState();
                return;
            }

            const siblingsOf = (parentId) => allItems
                .filter(i => (i.parent_id ?? null) === (parentId ?? null))
                .sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

            const renderRow = (item, siblings, index, indent) => `
                <div class="flex items-center gap-2 px-3 py-2 border border-zinc-200 dark:border-zinc-700 rounded-lg ${item.is_active ? '' : 'opacity-50'}"${indent ? ' style="margin-left:' + indent + 'px"' : ''}>
                    ${indent ? '<span class="text-zinc-300 dark:text-zinc-600 shrink-0">&#8627;</span>' : ''}
                    <span class="flex-1 text-sm ${indent ? '' : 'font-medium'} text-zinc-800 dark:text-zinc-100 truncate">${item.name}</span>
                    ${!item.is_active ? '<span class="text-[10px] font-semibold uppercase tracking-widest bg-zinc-100 dark:bg-zinc-800 text-zinc-500 rounded-full px-2 py-0.5 shrink-0">Inactive</span>' : ''}
                    <label class="flex items-center gap-1 text-xs text-zinc-500 dark:text-zinc-400 cursor-pointer shrink-0">
                        <input type="checkbox" class="lookup-item-active-toggle rounded border-zinc-300 text-orange-500 focus:ring-orange-400 cursor-pointer" data-id="${item.id}" ${item.is_active ? 'checked' : ''}>
                        Active
                    </label>
                    <button type="button" class="lookup-item-up p-1 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 shrink-0 ${index === 0 ? 'opacity-30 pointer-events-none' : ''}" data-id="${item.id}" title="Move up">&uarr;</button>
                    <button type="button" class="lookup-item-down p-1 text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 shrink-0 ${index === siblings.length - 1 ? 'opacity-30 pointer-events-none' : ''}" data-id="${item.id}" title="Move down">&darr;</button>
                    <button type="button" class="lookup-item-edit text-xs font-medium text-blue-600 hover:underline shrink-0" data-id="${item.id}">Edit</button>
                </div>
            `;

            const topLevel = siblingsOf(null);

            container.innerHTML = topLevel.map((item, index) => {
                const children = siblingsOf(item.id);
                return renderRow(item, topLevel, index, 0) +
                    children.map((child, childIndex) => renderRow(child, children, childIndex, 24)).join('');
            }).join('');
        }

        function openAddLookupListModal() {
            document.getElementById('lookupListForm').reset();

            initSideModal({
                modalId: 'addLookupListSideModal'
            });

            document.getElementById('lookupListNameInput').focus();
        }

        document.getElementById('btnAddLookupList').addEventListener('click', openAddLookupListModal);

        document.getElementById('saveLookupListBtn').addEventListener('click', async function() {
            const input = document.getElementById('lookupListNameInput');
            const label = input.value.trim();
            if (!label) {
                input.focus();
                return;
            }

            const childLabel = document.getElementById('lookupListChildLabelInput').value.trim() || null;

            const res = await apiCall({
                mode: 'POST',
                isJson: true,
                payload: {
                    label,
                    child_label: childLabel,
                },
                url: '/api/lookupLists',
                button: this,
            });

            if (!res || res.success !== true) {
                const err = (res && res.response) ? res.response : (res || {});
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: err.message || 'Failed to add list.'
                });
                return;
            }

            showMessage({
                status: 'success',
                title: 'List added!'
            });
            closeSideModal('addLookupListSideModal');
            selectedLookupListId = res.data.id;
            await loadLookupLists();
        });

        document.getElementById('lookupListsContainer').addEventListener('click', (e) => {
            const btn = e.target.closest('.lookup-list-btn');
            if (!btn) return;
            selectedLookupListId = btn.dataset.id;
            renderLookupLists();
            renderLookupItems();
        });

        function addChildRow(value = '') {
            const row = document.createElement('div');
            row.className = 'flex items-center gap-2';
            row.innerHTML = `
                <input type="text" class="lookup-child-row-input flex-1 bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition" value="${value}">
                <button type="button" class="lookup-child-row-remove p-1.5 text-zinc-400 hover:text-red-500 shrink-0" title="Remove row">✕</button>
            `;
            document.getElementById('lookupItemChildrenRows').appendChild(row);
            return row;
        }

        document.getElementById('lookupItemChildrenRows').addEventListener('click', (e) => {
            const removeBtn = e.target.closest('.lookup-child-row-remove');
            if (removeBtn) removeBtn.closest('div').remove();
        });

        document.getElementById('lookupItemAddChildRow').addEventListener('click', () => {
            const row = addChildRow('');
            row.querySelector('input').focus();
        });

        function refreshChildrenSectionVisibility(list, isEdit) {
            const wrapper = document.getElementById('lookupItemChildrenWrapper');
            const parentChosen = document.getElementById('lookupItemParentSelect').value !== '';
            const show = Boolean(list.child_label) && !(isEdit ? false : parentChosen);

            wrapper.classList.toggle('hidden', !show);
            if (!show) return;

            document.getElementById('lookupItemChildrenLabel').textContent = `${list.child_label}s`;
            document.getElementById('lookupItemChildrenNote').textContent = isEdit ?
                `New ${list.child_label.toLowerCase()} rows to add here. Existing ones are edited from the list below.` :
                `Optionally add ${list.child_label.toLowerCase()} rows now instead of one at a time later.`;
        }

        function openLookupItemModal(item = null) {
            const list = lookupLists.find(l => String(l.id) === String(selectedLookupListId));
            if (!list) return;

            const isEdit = Boolean(item);

            document.getElementById('lookupItemModalListLabel').textContent = isEdit ?
                `Editing in: ${list.label}` : `Adding to: ${list.label}`;
            document.getElementById('lookupItemModalTitle').textContent = isEdit ? 'Edit Item' : 'Add Item';
            document.getElementById('lookupItemForm').reset();
            document.getElementById('lookupItemId').value = item?.id ?? '';
            document.getElementById('lookupItemNameInput').value = item?.name ?? '';

            // Reparenting an existing item isn't supported here - it would
            // need extra depth checks (a top-level item with children can't
            // become a child itself without breaking the 2-level limit). New
            // items pick a parent from the list's current top-level items.
            document.getElementById('lookupItemParentWrapper').classList.toggle('hidden', isEdit);

            if (!isEdit) {
                const items = Array.isArray(list.items) ? list.items : [];
                const topLevel = items
                    .filter(i => !i.parent_id)
                    .sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

                const parentSelect = document.getElementById('lookupItemParentSelect');
                parentSelect.innerHTML = '<option value="">— None (top-level) —</option>' +
                    topLevel.map(i => `<option value="${i.id}">${i.name}</option>`).join('');
            }

            // Child rows only apply to a top-level item on a list that
            // defines a child_label - editing a top-level item starts with
            // no rows (purely additive), adding a new top-level item starts
            // with one blank row as a convenience.
            document.getElementById('lookupItemChildrenRows').innerHTML = '';
            refreshChildrenSectionVisibility(list, isEdit);
            if (!isEdit && list.child_label) addChildRow('');

            initSideModal({
                modalId: 'addLookupItemSideModal'
            });

            document.getElementById('lookupItemNameInput').focus();
        }

        document.getElementById('lookupItemParentSelect').addEventListener('change', () => {
            const list = lookupLists.find(l => String(l.id) === String(selectedLookupListId));
            if (list) refreshChildrenSectionVisibility(list, false);
        });

        document.getElementById('btnAddLookupItem').addEventListener('click', () => openLookupItemModal(null));

        document.getElementById('saveLookupItemBtn').addEventListener('click', async function() {
            if (!selectedLookupListId) return;

            const itemId = document.getElementById('lookupItemId').value;
            const isEdit = Boolean(itemId);

            const input = document.getElementById('lookupItemNameInput');
            const name = input.value.trim();
            if (!name) {
                input.focus();
                return;
            }

            const children = Array.from(document.querySelectorAll('#lookupItemChildrenRows .lookup-child-row-input'))
                .map(el => el.value.trim())
                .filter(v => v.length > 0);

            const payload = isEdit ? {
                name,
                children,
            } : {
                name,
                parent_id: document.getElementById('lookupItemParentSelect').value || null,
                children,
            };

            const res = await apiCall({
                mode: isEdit ? 'PUT' : 'POST',
                isJson: true,
                payload,
                url: isEdit ? `/api/lookupLists/items/${itemId}` : `/api/lookupLists/${selectedLookupListId}/items`,
                button: this,
            });

            if (!res || res.success !== true) {
                const err = (res && res.response) ? res.response : (res || {});
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: err.message || `Failed to ${isEdit ? 'update' : 'add'} item.`
                });
                return;
            }

            showMessage({
                status: 'success',
                title: isEdit ? 'Item updated!' : 'Item added!'
            });
            closeSideModal('addLookupItemSideModal');
            await loadLookupLists();
        });

        document.getElementById('lookupItemsContainer').addEventListener('click', async (e) => {
            const editBtn = e.target.closest('.lookup-item-edit');
            const upBtn = e.target.closest('.lookup-item-up');
            const downBtn = e.target.closest('.lookup-item-down');

            const list = lookupLists.find(l => String(l.id) === String(selectedLookupListId));
            if (!list) return;
            const items = Array.isArray(list.items) ? list.items : [];

            if (editBtn) {
                const item = items.find(i => String(i.id) === String(editBtn.dataset.id));
                if (!item) return;

                openLookupItemModal(item);
                return;
            }

            if (upBtn || downBtn) {
                const targetId = (upBtn || downBtn).dataset.id;
                const target = items.find(i => String(i.id) === String(targetId));
                if (!target) return;

                const siblings = items
                    .filter(i => (i.parent_id ?? null) === (target.parent_id ?? null))
                    .sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

                const index = siblings.findIndex(i => String(i.id) === String(targetId));
                if (index === -1) return;
                const swapWith = upBtn ? index - 1 : index + 1;
                if (swapWith < 0 || swapWith >= siblings.length) return;

                const reordered = [...siblings];
                [reordered[index], reordered[swapWith]] = [reordered[swapWith], reordered[index]];
                const orderedIds = reordered.map(i => i.id);

                const res = await apiCall({
                    mode: 'POST',
                    isJson: true,
                    payload: {
                        ordered_ids: orderedIds
                    },
                    url: `/api/lookupLists/${selectedLookupListId}/items/reorder`
                });

                if (!res || res.success !== true) {
                    const err = (res && res.response) ? res.response : (res || {});
                    showMessage({
                        status: 'error',
                        title: 'Error',
                        message: err.message || 'Failed to reorder items.'
                    });
                    return;
                }

                await loadLookupLists();
            }
        });

        document.getElementById('lookupItemsContainer').addEventListener('change', async (e) => {
            const toggle = e.target.closest('.lookup-item-active-toggle');
            if (!toggle) return;

            const res = await apiCall({
                mode: 'PUT',
                isJson: true,
                payload: {
                    is_active: toggle.checked
                },
                url: `/api/lookupLists/items/${toggle.dataset.id}`
            });

            if (!res || res.success !== true) {
                const err = (res && res.response) ? res.response : (res || {});
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: err.message || 'Failed to update item.'
                });
                await loadLookupLists();
                return;
            }

            await loadLookupLists();
        });

        // ------------------------------------------------------------
        // TAB 3: CHECKLIST
        // ------------------------------------------------------------
        const UNGROUPED = '__ungrouped__';

        function emptyChecklistState() {
            return `<p class="text-sm text-zinc-400 py-6 text-center">No items in this group yet. Add one above.</p>`;
        }

        async function loadChecklistData() {
            const [groupsRes, itemsRes] = await Promise.all([
                apiCall({
                    mode: 'GET',
                    url: '/api/checklistGroups'
                }),
                apiCall({
                    mode: 'GET',
                    url: '/api/checklistItems'
                }),
            ]);

            if (!groupsRes || groupsRes.success !== true || !itemsRes || itemsRes.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: 'Failed to load the checklist.'
                });
                return;
            }

            checklistGroups = Array.isArray(groupsRes.data) ?
                [...groupsRes.data].sort((a, b) => (a.order ?? 0) - (b.order ?? 0)) : [];
            checklistItems = Array.isArray(itemsRes.data) ?
                [...itemsRes.data].sort((a, b) => (a.order ?? 0) - (b.order ?? 0)) : [];

            if (selectedChecklistGroupId === null) {
                selectedChecklistGroupId = checklistGroups.length ? checklistGroups[0].id : UNGROUPED;
            }

            renderChecklistGroups();
            renderChecklistItems();
        }

        function renderChecklistGroups() {
            const container = document.getElementById('checklistGroupsContainer');
            const isSelected = id => String(id) === String(selectedChecklistGroupId);

            const groupRow = (id, label, subtitle, actions) => `
                <div class="flex items-center gap-1 px-2 ${isSelected(id) ? 'bg-orange-50 dark:bg-zinc-800' : 'hover:bg-zinc-50 dark:hover:bg-zinc-800'} transition">
                    <button type="button" class="checklist-group-btn flex-1 text-left py-2.5 px-2 text-sm ${isSelected(id) ? 'text-orange-600 font-medium' : 'text-zinc-700 dark:text-zinc-200'}"
                        data-id="${id}">
                        <div>${label}</div>
                        ${subtitle ? `<div class="text-[11px] ${isSelected(id) ? 'text-orange-400' : 'text-zinc-400'}">${subtitle}</div>` : ''}
                    </button>
                    ${actions}
                </div>
            `;

            const groupActions = id => `
                <button type="button" class="checklist-group-edit text-xs font-medium text-blue-600 hover:underline shrink-0 px-1" data-id="${id}">Edit</button>
                <button type="button" class="checklist-group-delete text-xs font-medium text-red-600 hover:underline shrink-0 px-1" data-id="${id}">Delete</button>
            `;

            container.innerHTML =
                checklistGroups.map(g => groupRow(
                    g.id, g.label, `→ ${g.target_status}${g.is_active ? '' : ' · inactive'}`, groupActions(g.id)
                )).join('') +
                groupRow(UNGROUPED, 'Ungrouped', 'informational only', '');
        }

        function currentGroupChecklistItems() {
            if (selectedChecklistGroupId === UNGROUPED) {
                return checklistItems.filter(i => !i.checklist_group_id);
            }
            return checklistItems.filter(i => String(i.checklist_group_id) === String(selectedChecklistGroupId));
        }

        function renderChecklistItems() {
            const titleEl = document.getElementById('checklistSelectedGroupTitle');
            const subtitleEl = document.getElementById('checklistSelectedGroupSubtitle');
            const container = document.getElementById('checklistItemsContainer');

            if (selectedChecklistGroupId === UNGROUPED) {
                titleEl.textContent = 'Ungrouped';
                subtitleEl.textContent = 'These items don\'t move an applicant\'s status.';
            } else {
                const group = checklistGroups.find(g => String(g.id) === String(selectedChecklistGroupId));
                titleEl.textContent = group ? group.label : '—';
                subtitleEl.textContent = group ?
                    `Checking every active item here sets status to "${group.target_status}".` : '';
            }

            const items = currentGroupChecklistItems();

            if (!items.length) {
                container.innerHTML = emptyChecklistState();
                return;
            }

            container.innerHTML = items.map(item => `
                <div class="flex items-center gap-2 px-3 py-2 border border-zinc-200 dark:border-zinc-700 rounded-lg ${item.is_active ? '' : 'opacity-50'}">
                    <span class="flex-1 text-sm text-zinc-800 dark:text-zinc-100 truncate">${item.label}</span>
                    ${!item.is_active ? '<span class="text-[10px] font-semibold uppercase tracking-widest bg-zinc-100 dark:bg-zinc-800 text-zinc-500 rounded-full px-2 py-0.5 shrink-0">Inactive</span>' : ''}
                    <label class="flex items-center gap-1 text-xs text-zinc-500 dark:text-zinc-400 cursor-pointer shrink-0">
                        <input type="checkbox" class="checklist-item-active-toggle rounded border-zinc-300 text-orange-500 focus:ring-orange-400 cursor-pointer" data-id="${item.id}" ${item.is_active ? 'checked' : ''}>
                        Active
                    </label>
                    <button type="button" class="checklist-item-edit text-xs font-medium text-blue-600 hover:underline shrink-0" data-id="${item.id}">Edit</button>
                    <button type="button" class="checklist-item-delete text-xs font-medium text-red-600 hover:underline shrink-0" data-id="${item.id}">Delete</button>
                </div>
            `).join('');
        }

        document.getElementById('checklistGroupsContainer').addEventListener('click', async (e) => {
            const editBtn = e.target.closest('.checklist-group-edit');
            const deleteBtn = e.target.closest('.checklist-group-delete');
            const selectBtn = e.target.closest('.checklist-group-btn');

            if (editBtn) {
                const group = checklistGroups.find(g => String(g.id) === String(editBtn.dataset.id));
                if (group) openChecklistGroupModal(group);
                return;
            }

            if (deleteBtn) {
                const confirmed = await customConfirm(
                    'Delete this group? Its checklist items must be moved or deleted first.');
                if (!confirmed) return;

                const res = await apiCall({
                    mode: 'DELETE',
                    url: `/api/checklistGroups/${deleteBtn.dataset.id}`
                });

                if (!res || res.success !== true) {
                    const err = (res && res.response) ? res.response : (res || {});
                    showMessage({
                        status: 'error',
                        title: 'Error',
                        message: err.message || 'Failed to delete group.'
                    });
                    return;
                }

                showMessage({
                    status: 'success',
                    title: 'Group deleted!'
                });
                if (String(selectedChecklistGroupId) === String(deleteBtn.dataset.id)) {
                    selectedChecklistGroupId = UNGROUPED;
                }
                await loadChecklistData();
                return;
            }

            if (selectBtn) {
                selectedChecklistGroupId = selectBtn.dataset.id;
                renderChecklistGroups();
                renderChecklistItems();
            }
        });

        // ---- Group modal ----
        // Cached active, top-level items from the "status" lookup list, used
        // to populate the Target status select. Fetched once and reused.
        let statusLookupItems = null;

        async function loadStatusLookupItems() {
            if (statusLookupItems) return statusLookupItems;

            const res = await apiCall({
                mode: 'GET',
                url: '/api/lookupLists'
            });

            if (!res || res.success !== true || !Array.isArray(res.data)) {
                statusLookupItems = [];
                return statusLookupItems;
            }

            const statusList = res.data.find(l => l.key === 'status');
            const items = statusList && Array.isArray(statusList.items) ? statusList.items : [];

            statusLookupItems = items
                .filter(i => i.is_active && !i.parent_id)
                .sort((a, b) => (a.order ?? 0) - (b.order ?? 0));

            return statusLookupItems;
        }

        function populateChecklistGroupTargetStatusSelect(currentValue) {
            const select = document.getElementById('checklistGroupTargetStatusInput');
            const options = statusLookupItems || [];

            let html = '<option value="">Select status</option>' +
                options.map(item => `<option value="${item.name}">${item.name}</option>`).join('');

            // Legacy value that isn't among the active status options -
            // append it so the select still reflects what's actually saved.
            if (currentValue && !options.some(item => item.name === currentValue)) {
                html += `<option value="${currentValue}">${currentValue} (legacy)</option>`;
            }

            select.innerHTML = html;
            select.value = currentValue ?? '';
        }

        async function openChecklistGroupModal(group = null) {
            const isEdit = Boolean(group);

            document.getElementById('checklistGroupModalTitle').textContent = isEdit ? 'Edit Group' : 'Add Group';
            document.getElementById('checklistGroupForm').reset();
            document.getElementById('checklistGroupId').value = group?.id ?? '';
            document.getElementById('checklistGroupLabelInput').value = group?.label ?? '';

            await loadStatusLookupItems();
            populateChecklistGroupTargetStatusSelect(group?.target_status ?? '');

            initSideModal({
                modalId: 'checklistGroupSideModal'
            });

            document.getElementById('checklistGroupLabelInput').focus();
        }

        document.getElementById('btnAddChecklistGroup').addEventListener('click', () => openChecklistGroupModal(
            null));

        document.getElementById('saveChecklistGroupBtn').addEventListener('click', async function() {
            const groupId = document.getElementById('checklistGroupId').value;
            const isEdit = Boolean(groupId);

            const label = document.getElementById('checklistGroupLabelInput').value.trim();
            const targetStatus = document.getElementById('checklistGroupTargetStatusInput').value.trim();

            if (!label) {
                document.getElementById('checklistGroupLabelInput').focus();
                return;
            }
            if (!targetStatus) {
                document.getElementById('checklistGroupTargetStatusInput').focus();
                return;
            }

            const res = await apiCall({
                mode: isEdit ? 'PUT' : 'POST',
                isJson: true,
                payload: {
                    label,
                    target_status: targetStatus
                },
                url: isEdit ? `/api/checklistGroups/${groupId}` : '/api/checklistGroups',
                button: this,
            });

            if (!res || res.success !== true) {
                const err = (res && res.response) ? res.response : (res || {});
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: err.message || `Failed to ${isEdit ? 'update' : 'add'} group.`
                });
                return;
            }

            showMessage({
                status: 'success',
                title: isEdit ? 'Group updated!' : 'Group added!'
            });
            closeSideModal('checklistGroupSideModal');
            if (!isEdit) selectedChecklistGroupId = res.data.id;
            await loadChecklistData();
        });

        // ---- Item modal ----
        function populateChecklistItemGroupSelect(currentGroupId) {
            const select = document.getElementById('checklistItemGroupSelect');
            select.innerHTML = '<option value="">Ungrouped (informational only)</option>' +
                checklistGroups.map(g => `<option value="${g.id}">${g.label} → ${g.target_status}</option>`).join(
                    '');
            select.value = currentGroupId ?? '';
        }

        function openChecklistItemModal(item = null) {
            const isEdit = Boolean(item);

            document.getElementById('checklistItemModalTitle').textContent = isEdit ? 'Edit Item' : 'Add Item';
            document.getElementById('checklistItemForm').reset();
            document.getElementById('checklistItemId').value = item?.id ?? '';
            document.getElementById('checklistItemLabelInput').value = item?.label ?? '';

            const defaultGroupId = isEdit ?
                (item.checklist_group_id ?? '') :
                (selectedChecklistGroupId === UNGROUPED ? '' : selectedChecklistGroupId);
            populateChecklistItemGroupSelect(defaultGroupId);

            initSideModal({
                modalId: 'checklistItemSideModal'
            });

            document.getElementById('checklistItemLabelInput').focus();
        }

        document.getElementById('btnAddChecklistItem').addEventListener('click', () => openChecklistItemModal(
            null));

        document.getElementById('saveChecklistItemBtn').addEventListener('click', async function() {
            const itemId = document.getElementById('checklistItemId').value;
            const isEdit = Boolean(itemId);

            const label = document.getElementById('checklistItemLabelInput').value.trim();
            if (!label) {
                document.getElementById('checklistItemLabelInput').focus();
                return;
            }

            const groupId = document.getElementById('checklistItemGroupSelect').value || null;

            const res = await apiCall({
                mode: isEdit ? 'PUT' : 'POST',
                isJson: true,
                payload: {
                    label,
                    checklist_group_id: groupId
                },
                url: isEdit ? `/api/checklistItems/${itemId}` : '/api/checklistItems',
                button: this,
            });

            if (!res || res.success !== true) {
                const err = (res && res.response) ? res.response : (res || {});
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: err.message || `Failed to ${isEdit ? 'update' : 'add'} item.`
                });
                return;
            }

            showMessage({
                status: 'success',
                title: isEdit ? 'Item updated!' : 'Item added!'
            });
            closeSideModal('checklistItemSideModal');
            if (!isEdit) selectedChecklistGroupId = groupId ?? UNGROUPED;
            await loadChecklistData();
        });

        document.getElementById('checklistItemsContainer').addEventListener('click', async (e) => {
            const editBtn = e.target.closest('.checklist-item-edit');
            const deleteBtn = e.target.closest('.checklist-item-delete');

            if (editBtn) {
                const item = checklistItems.find(i => String(i.id) === String(editBtn.dataset.id));
                if (item) openChecklistItemModal(item);
                return;
            }

            if (deleteBtn) {
                const confirmed = await customConfirm('Delete this checklist item?');
                if (!confirmed) return;

                const res = await apiCall({
                    mode: 'DELETE',
                    url: `/api/checklistItems/${deleteBtn.dataset.id}`
                });

                if (!res || res.success !== true) {
                    const err = (res && res.response) ? res.response : (res || {});
                    showMessage({
                        status: 'error',
                        title: 'Error',
                        message: err.message || 'Failed to delete checklist item.'
                    });
                    return;
                }

                showMessage({
                    status: 'success',
                    title: 'Checklist item deleted!'
                });
                await loadChecklistData();
            }
        });

        document.getElementById('checklistItemsContainer').addEventListener('change', async (e) => {
            const toggle = e.target.closest('.checklist-item-active-toggle');
            if (!toggle) return;

            const res = await apiCall({
                mode: 'PUT',
                isJson: true,
                payload: {
                    is_active: toggle.checked
                },
                url: `/api/checklistItems/${toggle.dataset.id}`
            });

            if (!res || res.success !== true) {
                const err = (res && res.response) ? res.response : (res || {});
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: err.message || 'Failed to update checklist item.'
                });
            }

            await loadChecklistData();
        });

        // ------------------------------------------------------------
        // INIT
        // ------------------------------------------------------------
        setActiveTab('form');
    })();
</script>
