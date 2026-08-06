<div class="container mx-auto p-3">

    {{-- PAGE HEADER --}}
    <div class="flex justify-between items-center mb-5 p-2">
        <div>
            <h1 class="text-2xl font-bold">Applicants</h1>
            <p class="text-zinc-500">Track and manage candidates through the recruitment pipeline</p>
        </div>
        <div class="flex items-center gap-2">
            <button id="btnAddApplicant"
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                + Add Applicant
            </button>
        </div>
    </div>

    {{-- FILTERS --}}
    <div class="flex flex-wrap items-end gap-3 mb-4 p-2">
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Status</label>
            <select id="applicantStatusFilter"
                class="bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                <option value="">All</option>
                <option value="New">New</option>
                <option value="In Review">In Review</option>
                <option value="Interview">Interview</option>
                <option value="Offer">Offer</option>
                <option value="Hired">Hired</option>
                <option value="Rejected">Rejected</option>
            </select>
        </div>
    </div>

    {{-- TABLE --}}
    <x-table id="applicantsTable" />

    <div class="mt-3 p-2 flex items-center justify-between">
        <div>
            @if (auth()->user()->is_team_leader)
                <label class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300 cursor-pointer">
                    <input type="checkbox" id="scopeAllToggle" checked
                        class="rounded border-zinc-300 text-orange-500 focus:ring-orange-400">
                    Show all team members' applicants
                </label>
            @endif
        </div>

        {{-- EXPORT --}}
        <div class="relative">
            <button type="button" id="btnExportApplicants"
                class="px-4 py-2 rounded-lg text-sm font-medium border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                Export
            </button>

            <div id="exportPanel"
                class="hidden absolute z-20 bottom-full right-0 mb-2 w-[40vw] max-w-[95vw] bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-lg p-4">

                <div class="flex gap-4">

                    {{-- LEFT: inputs + actions --}}
                    <div class="flex-1 flex flex-col gap-3">
                        <div class="flex flex-wrap gap-2">
                            <button type="button" id="exportPresetToday"
                                class="px-3 py-1.5 text-xs font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                                Today
                            </button>
                            <button type="button" id="exportPresetThisWeek"
                                class="px-3 py-1.5 text-xs font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                                This Week
                            </button>
                            <button type="button" id="exportPresetLastWeek"
                                class="px-3 py-1.5 text-xs font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                                Last Week
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">From</label>
                                <input type="date" id="exportFrom"
                                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-2 py-1.5 text-xs text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">To</label>
                                <input type="date" id="exportTo"
                                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-2 py-1.5 text-xs text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">File
                                Type</label>
                            <select id="exportFormat"
                                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                                <option value="csv" selected>CSV</option>
                                <option value="xlsx">Excel</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label
                                class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Status</label>
                            <div id="exportStatusFilter"
                                class="flex flex-col gap-1.5 max-h-28 overflow-y-auto border border-zinc-200 dark:border-zinc-700 rounded-lg p-2 bg-zinc-50 dark:bg-zinc-800">
                            </div>
                        </div>

                        <button type="button" id="exportRunBtn"
                            class="w-full mt-auto px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                            Export
                        </button>
                    </div>

                    {{-- RIGHT: calendar --}}
                    <div class="flex-1">
                        <div id="exportCalendar" class="p-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ADD APPLICANT SIDE MODAL --}}
    <x-side-modal id="addApplicantSideModal">

        {{-- Header --}}
        <div
            class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
            <div>
                <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Recruitment</p>
                <p class="text-lg font-semibold dark:text-white mt-0.5">Add Applicant</p>
            </div>
            <button
                class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                ✕
            </button>
        </div>

        {{-- Body --}}
        <div class="p-5">

            {{-- LOADING STATE --}}
            <div id="applicantFormLoading"
                class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-8 text-center text-sm text-zinc-400">
                Loading form...
            </div>

            {{-- ERROR STATE --}}
            <div id="applicantFormError"
                class="hidden rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-8 text-center text-sm text-red-600">
                Unable to load the applicant form. Please try again later.
            </div>

            {{-- FORM --}}
            <form id="applicantForm" class="hidden space-y-4">

                {{-- Candidate Name --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Candidate Name
                        <span class="text-red-500">*</span></label>
                    <input type="text" id="candidateName" name="full_name" required
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Date (read-only, not submitted) --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Date</label>
                    <div id="applicantDateDisplay"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-500 dark:text-zinc-400">
                    </div>
                    <p class="text-xs text-zinc-400">Auto-set to today.</p>
                </div>

                {{-- Role --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Role</label>
                    <select id="roleSelect"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        <option value="">Select role</option>
                    </select>
                </div>

                {{-- Source --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Source</label>
                    <select id="sourceSelect"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        <option value="">Select source</option>
                    </select>
                </div>

                {{-- Employee referral name (shown only when Source = Employee Referral) --}}
                <div class="flex flex-col gap-1 hidden" id="sourceReferralNameWrap">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Employee name who
                        referred the applicant</label>
                    <input type="text" id="sourceReferralNameInput"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Other source, specify (shown only when Source = Other) --}}
                <div class="flex flex-col gap-1 hidden" id="sourceOtherSpecifyWrap">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Please
                        specify</label>
                    <input type="text" id="sourceOtherSpecifyInput"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Phone --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Phone</label>
                    <input type="text" id="applicantPhone"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Email</label>
                    <input type="email" id="applicantEmail"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Date of Birth --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Date of
                        Birth</label>
                    <input type="date" id="applicantDob"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Notes --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Notes</label>
                    <textarea id="applicantNotes" rows="3"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition"></textarea>
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
            <button type="button" id="saveApplicantBtn"
                class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                Save Applicant
            </button>
        </div>

    </x-side-modal>

    {{-- Scoped width override for the View Applicant modal only --}}
    <style>
        @media (min-width:768px) {
            #viewApplicantSideModal .side-modal-panel {
                width: 600px;
            }
        }

        @media (min-width:1024px) {
            #viewApplicantSideModal .side-modal-panel {
                width: 960px;
            }
        }

        @media (min-width:1280px) {
            #viewApplicantSideModal .side-modal-panel {
                width: 1100px;
            }
        }
    </style>

    {{-- VIEW APPLICANT SIDE MODAL --}}
    <x-side-modal id="viewApplicantSideModal">

        {{-- Header --}}
        <div
            class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
            <div>
                <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Recruitment</p>
                <p class="text-lg font-semibold dark:text-white mt-0.5">Applicant Details</p>
            </div>
            <button
                class="js-view-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                ✕
            </button>
        </div>

        {{-- Body --}}
        <div class="p-5">

            {{-- LOADING STATE --}}
            <div id="applicantLoading"
                class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-8 text-center text-sm text-zinc-400">
                Loading applicant...
            </div>

            {{-- ERROR STATE --}}
            <div id="applicantError"
                class="hidden rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-8 text-center text-sm text-red-600">
                Unable to load this applicant. Please try again later.
            </div>

            {{-- CONTENT --}}
            <div id="applicantContent" class="hidden grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- LEFT COLUMN --}}
                <div class="flex flex-col gap-6">

                    {{-- Header card --}}
                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <h2 id="applicantName" class="text-xl font-bold text-zinc-800 dark:text-zinc-100"></h2>
                            <span id="applicantStatusBadge"></span>
                            <button type="button" id="btnEditInfo"
                                class="ml-auto text-xs font-medium text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 transition">
                                Edit
                            </button>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-4">
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Assigned To
                                </p>
                                <p id="applicantAssignedTo" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5">
                                </p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Location
                                </p>
                                <p id="applicantLocation" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5"></p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Role</p>
                                <p id="applicantRole" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5"></p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Source</p>
                                <p id="applicantSource" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5"></p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Phone</p>
                                <p id="applicantPhoneView" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5">
                                </p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Email</p>
                                <p id="applicantEmailView" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5">
                                </p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Date of
                                    Birth</p>
                                <p id="applicantDobView" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5"></p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Created</p>
                                <p id="applicantCreatedAt" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5">
                                </p>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Last
                                    Activity
                                </p>
                                <p id="applicantLastActivity" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5">
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label
                                class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Status</label>
                            <select id="applicantStatusSelect"
                                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            </select>
                        </div>
                    </div>

                    {{-- Interview Summary card --}}
                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-5">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Interview
                                Summary</p>
                            <button type="button" id="saveInterviewSummaryBtn"
                                class="text-xs font-medium text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 transition">
                                Save
                            </button>
                        </div>
                        <textarea id="applicantInterviewSummary" rows="4" placeholder="Notes from the interview..."
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition"></textarea>
                    </div>

                    {{-- Actions row --}}
                    <div class="flex gap-2">
                        <button type="button" id="btnInterview"
                            class="flex-1 px-4 py-2 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                            Interview
                        </button>
                        <button type="button" id="btnScheduleOrientation"
                            class="hidden flex-1 px-4 py-2 text-sm font-medium text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/30 hover:bg-teal-100 dark:hover:bg-teal-900/50 border border-teal-200 dark:border-teal-800 rounded-lg transition">
                            Schedule Orientation
                        </button>
                    </div>

                    {{-- Answers card --}}
                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-5">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Application
                                Answers</p>
                            <div class="flex items-center gap-3">
                                <button type="button" id="btnEditAnswers"
                                    class="hidden text-xs font-medium text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 transition">
                                    Edit
                                </button>
                                <button type="button" id="btnCopyAnswers"
                                    class="text-xs font-medium text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 transition">
                                    Copy
                                </button>
                            </div>
                        </div>
                        <div id="applicantAnswersList"></div>
                    </div>

                    {{-- Notes card --}}
                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-5">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Notes</p>
                            <button type="button" id="btnAddNote"
                                class="text-xs font-medium text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 transition">
                                + Add Note
                            </button>
                        </div>

                        <div id="noteComposer" class="flex flex-col gap-2 mb-3 hidden">
                            <textarea id="noteInput" rows="3" placeholder="Add a note..."
                                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition"></textarea>
                            <div class="flex justify-end gap-2">
                                <button type="button" id="cancelNoteBtn"
                                    class="px-3 py-1.5 text-xs font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                                    Cancel
                                </button>
                                <button type="button" id="saveNoteBtn"
                                    class="px-3 py-1.5 text-xs font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                                    Save Note
                                </button>
                            </div>
                        </div>

                        <div id="notesList"></div>
                    </div>

                    {{-- Activity History card --}}
                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-5">
                        <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400 mb-2">Activity
                            History</p>
                        <div id="activityList" class="max-h-64 overflow-y-auto"></div>
                    </div>

                </div>

                {{-- RIGHT COLUMN --}}
                <div class="flex flex-col gap-6">

                    {{-- Checklist card --}}
                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-5">
                        <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400 mb-2">Checklist</p>
                        <div id="applicantChecklistList"></div>
                    </div>

                    {{-- Files card --}}
                    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-5">
                        <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400 mb-2">Files</p>
                        <div id="applicantFilesList"></div>
                    </div>

                </div>

            </div>

        </div>

    </x-side-modal>

    {{-- EDIT APPLICANT SIDE MODAL --}}
    <x-side-modal id="editApplicantSideModal">

        {{-- Header --}}
        <div
            class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
            <div>
                <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Recruitment</p>
                <p class="text-lg font-semibold dark:text-white mt-0.5">Edit Applicant</p>
            </div>
            <button
                class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                ✕
            </button>
        </div>

        {{-- Body --}}
        <div class="p-5">
            <form id="editApplicantForm" class="space-y-4">

                {{-- Full Name --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Full Name
                        <span class="text-red-500">*</span></label>
                    <input type="text" id="editFullName" required
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Role --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Role</label>
                    <select id="editRoleSelect"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        <option value="">Select role</option>
                    </select>
                </div>

                {{-- Source --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Source</label>
                    <select id="editSourceSelect"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                        <option value="">Select source</option>
                    </select>
                </div>

                {{-- Employee referral name (shown only when Source = Employee Referral) --}}
                <div class="flex flex-col gap-1 hidden" id="editSourceReferralNameWrap">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Employee name who
                        referred the applicant</label>
                    <input type="text" id="editSourceReferralNameInput"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Other source, specify (shown only when Source = Other) --}}
                <div class="flex flex-col gap-1 hidden" id="editSourceOtherSpecifyWrap">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Please
                        specify</label>
                    <input type="text" id="editSourceOtherSpecifyInput"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Territory / Location --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label
                            class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Territory</label>
                        <select id="editTerritorySelect"
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            <option value="">Select territory</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Location</label>
                        <select id="editLocationSelect"
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            <option value="">Select a territory first</option>
                        </select>
                    </div>
                </div>

                {{-- Phone --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Phone</label>
                    <input type="text" id="editPhone"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Email --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Email</label>
                    <input type="email" id="editEmail"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>

                {{-- Date of Birth --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Date of
                        Birth</label>
                    <input type="date" id="editDob"
                        class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
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
            <button type="button" id="saveEditInfoBtn"
                class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                Save
            </button>
        </div>

    </x-side-modal>

    {{-- INTERVIEW SIDE MODAL --}}
    <x-side-modal id="interviewApplicantSideModal">

        {{-- Header --}}
        <div
            class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
            <div>
                <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Recruitment</p>
                <p class="text-lg font-semibold dark:text-white mt-0.5">Interview</p>
            </div>
            <button
                class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                ✕
            </button>
        </div>

        {{-- Body --}}
        <div class="p-5">

            {{-- LOADING STATE --}}
            <div id="interviewFormLoading"
                class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-8 text-center text-sm text-zinc-400">
                Loading form...
            </div>

            {{-- ERROR STATE --}}
            <div id="interviewFormError"
                class="hidden rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-8 text-center text-sm text-red-600">
                Unable to load the interview form. Please try again later.
            </div>

            {{-- FORM --}}
            <form id="interviewForm" class="hidden space-y-4">
                <div id="interviewFieldsContainer" class="space-y-4"></div>
            </form>
        </div>

        {{-- Footer --}}
        <div
            class="border-t border-zinc-100 dark:border-zinc-800 px-5 py-4 flex justify-end gap-2 sticky bottom-0 bg-white dark:bg-zinc-900">
            <button type="button"
                class="modal-close px-4 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                Cancel
            </button>
            <button type="button" id="submitInterviewBtn"
                class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                Submit Interview
            </button>
        </div>

    </x-side-modal>

    {{-- INTERVIEW OUTCOME MODAL --}}
    <x-modal id="interviewOutcomeModal">
        <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
            <p class="text-lg font-semibold dark:text-white">Interview Outcome</p>
            <button class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">✕</button>
        </div>
        <div class="p-5 text-sm text-zinc-600 dark:text-zinc-300">
            Mark this interview as passed or failed. This updates the applicant's status and checklist.
        </div>
        <div class="border-t border-zinc-100 dark:border-zinc-800 px-5 py-4 flex justify-end gap-2">
            <button type="button" id="interviewCancelBtn"
                class="modal-close px-4 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                Cancel
            </button>
            <button type="button" id="interviewFailBtn"
                class="px-4 py-1.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition">
                Fail
            </button>
            <button type="button" id="interviewPassBtn"
                class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                Pass
            </button>
        </div>
    </x-modal>

    {{-- ORIENTATION MODAL --}}
    <x-modal id="orientationModal">
        <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
            <p class="text-lg font-semibold dark:text-white">Schedule Orientation</p>
            <button class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">✕</button>
        </div>
        <div class="p-5">
            <div class="flex flex-col gap-1">
                <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Orientation Date
                    <span class="text-red-500">*</span></label>
                <input type="date" id="orientationDateInput"
                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
            </div>
        </div>
        <div class="border-t border-zinc-100 dark:border-zinc-800 px-5 py-4 flex justify-end gap-2">
            <button type="button"
                class="modal-close px-4 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                Cancel
            </button>
            <button type="button" id="saveOrientationBtn"
                class="px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                Save
            </button>
        </div>
    </x-modal>


</div>

{{-- JS --}}
<script>
    (function() {
        const STATUS_BADGES = {
            'New': 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300',
            'In Review': 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
            'Interview': 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
            'Passed': 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/40 dark:text-cyan-300',
            'Orientation': 'bg-teal-100 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300',
            'Offer': 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
            'Hired': 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
            'Rejected': 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
        };

        // Default/fallback set - refreshed from /api/applicants/statuses at
        // load, which also includes any checklist group's target_status
        // (e.g. a group-driven "Orientation" status).
        let STATUSES = ['New', 'In Review', 'Interview', 'Passed', 'Orientation', 'Offer', 'Hired', 'Rejected'];

        // Cached dynamic field definitions from /api/applicants/formConfig,
        // shared between the Add modal's initial load and the Interview
        // modal (which is the only place these fields render now).
        let cachedFormFields = null;

        // Cached territories (with nested .locations) from
        // /api/applicants/formConfig, shared between the Interview form's
        // and Edit Applicant form's territory/location selects.
        let cachedTerritories = [];

        async function loadStatuses() {
            const res = await apiCall({
                mode: 'GET',
                url: '/api/applicants/statuses'
            });

            if (!res || res.success !== true || !Array.isArray(res.data)) return;

            STATUSES = res.data;

            const filter = document.getElementById('applicantStatusFilter');
            const current = filter.value;
            filter.innerHTML = '<option value="">All</option>' +
                STATUSES.map(s => `<option value="${s}">${s}</option>`).join("");
            filter.value = current;

            const exportFilter = document.getElementById('exportStatusFilter');
            if (exportFilter) {
                exportFilter.innerHTML = STATUSES.map(s => `
                    <label class="flex items-center gap-2 text-xs text-zinc-600 dark:text-zinc-300 cursor-pointer">
                        <input type="checkbox" value="${s}" class="export-status-checkbox rounded border-zinc-300 text-orange-500 focus:ring-orange-400">
                        ${s}
                    </label>
                `).join("");
            }
        }

        function statusBadge(status) {
            const classes = STATUS_BADGES[status] ??
                'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300';
            return `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${classes}">${status ?? '—'}</span>`;
        }

        // The API already sends dates pre-formatted ("January 1, 2001" or
        // "January 1, 2001, 1:00 AM" - see App\Support\FriendlyDate) -
        // these just supply the "—" fallback, no re-parsing.
        function formatDate(value) {
            return value || '—';
        }

        function formatDateOnly(value) {
            return value || '—';
        }

        function apiErrorMessage(res) {
            const err = (res && res.response) ? res.response : (res || {});
            return err.invalid_fields ?
                Object.values(err.invalid_fields).flat().join(' ') : (err.message || 'Request failed.');
        }

        // ===================== LIST / TABLE =====================

        function handleRowClick(row) {
            row.addEventListener('click', function() {
                const data = JSON.parse(row.dataset.row);
                openViewModal(data.id);
            });
        }

        const thead = [{
                title: 'Name',
                key: 'full_name',
            },
            {
                title: 'Location',
                render: (row) => row.location?.name ?? '—',
            },
            {
                title: 'Assigned To',
                render: (row) => row.assignee?.name ?? '—',
            },
            {
                title: 'Team',
                render: (row) => row.team?.name ?? '—',
            },
            {
                title: 'Status',
                render: (row) => statusBadge(row.status),
            },
            {
                title: 'Last Activity',
                render: (row) => row.last_activity_at ?? '—',
            },
        ];

        const table = renderRemoteTable({
            url: '/api/applicants',
            tableId: 'applicantsTable',
            afterRenderFunction: handleRowClick,
            thead: thead,
        });

        table.load(1);
        loadStatuses();

        document.getElementById('btnAddApplicant').addEventListener('click', function() {
            openAddModal();
        });

        const statusFilter = document.getElementById('applicantStatusFilter');
        statusFilter.addEventListener('change', function() {
            table.setFilter('status', statusFilter.value || '');
        });

        const scopeToggle = document.getElementById('scopeAllToggle');
        if (scopeToggle) {
            scopeToggle.addEventListener('change', function() {
                table.setFilter('scope', scopeToggle.checked ? 'team' : 'mine');
            });
        }

        // ===================== ADD APPLICANT MODAL =====================

        const addModalEl = document.getElementById('addApplicantSideModal');
        const addLoadingEl = addModalEl.querySelector('#applicantFormLoading');
        const addErrorEl = addModalEl.querySelector('#applicantFormError');
        const applicantFormEl = addModalEl.querySelector('#applicantForm');
        const roleSelect = addModalEl.querySelector('#roleSelect');
        const sourceSelect = addModalEl.querySelector('#sourceSelect');
        const sourceReferralNameWrap = addModalEl.querySelector('#sourceReferralNameWrap');
        const sourceReferralNameInput = addModalEl.querySelector('#sourceReferralNameInput');
        const sourceOtherSpecifyWrap = addModalEl.querySelector('#sourceOtherSpecifyWrap');
        const sourceOtherSpecifyInput = addModalEl.querySelector('#sourceOtherSpecifyInput');
        let cachedSources = [];
        const phoneInput = addModalEl.querySelector('#applicantPhone');
        const emailInput = addModalEl.querySelector('#applicantEmail');
        const dobInput = addModalEl.querySelector('#applicantDob');
        const notesInput = addModalEl.querySelector('#applicantNotes');
        const saveApplicantBtn = addModalEl.querySelector('#saveApplicantBtn');
        const dateDisplay = addModalEl.querySelector('#applicantDateDisplay');
        const candidateNameInput = addModalEl.querySelector('#candidateName');

        // Fills a territory <select> with a placeholder option + one option
        // per territory. Shared between the Interview form's and Edit
        // Applicant form's territory/location rows.
        function populateTerritorySelect(territorySelectEl, territories) {
            territorySelectEl.innerHTML = '<option value="">Select territory</option>' +
                (territories || []).map(t => `<option value="${t.id}">${t.name}</option>`).join("");
        }

        // Given the chosen territory object (with .locations), fills the
        // location <select>. Pass null/undefined when no territory is
        // selected yet.
        function populateLocationSelect(locationSelectEl, territory) {
            if (!territory) {
                locationSelectEl.innerHTML = '<option value="">Select a territory first</option>';
                locationSelectEl.disabled = true;
                return;
            }

            const locations = territory.locations || [];

            if (!locations.length) {
                locationSelectEl.innerHTML = '<option value="">No locations for this territory</option>';
                locationSelectEl.disabled = true;
                return;
            }

            locationSelectEl.disabled = false;
            locationSelectEl.innerHTML = '<option value="">Select location</option>' +
                locations.map(loc => `<option value="${loc.id}">${loc.name}</option>`).join("");
        }

        let cachedRoles = [];

        function renderRoleOptions(roles) {
            cachedRoles = roles || [];
            roleSelect.innerHTML = '<option value="">Select role</option>' +
                cachedRoles.map(r => `<option value="${r.id}">${r.name}</option>`).join("");
        }

        function renderSourceOptions(sources) {
            cachedSources = sources || [];
            sourceSelect.innerHTML = '<option value="">Select source</option>' +
                cachedSources.map(s => `<option value="${s.id}">${s.name}</option>`).join("");
        }

        function toggleSourceDetailFields() {
            const selected = cachedSources.find(s => String(s.id) === String(sourceSelect.value));
            const name = selected?.name ?? '';

            const isReferral = name === 'Employee Referral';
            const isOther = name === 'Other';

            sourceReferralNameWrap.classList.toggle('hidden', !isReferral);
            sourceOtherSpecifyWrap.classList.toggle('hidden', !isOther);

            if (!isReferral) sourceReferralNameInput.value = '';
            if (!isOther) sourceOtherSpecifyInput.value = '';
        }

        sourceSelect.addEventListener('change', toggleSourceDetailFields);

        function resetAddForm() {
            candidateNameInput.value = '';
            roleSelect.value = '';
            sourceSelect.value = '';
            sourceReferralNameInput.value = '';
            sourceOtherSpecifyInput.value = '';
            toggleSourceDetailFields();
            phoneInput.value = '';
            emailInput.value = '';
            dobInput.value = '';
            notesInput.value = '';
        }

        async function loadFormConfig() {
            dateDisplay.textContent = new Date().toLocaleDateString();

            const res = await apiCall({
                mode: 'GET',
                url: '/api/applicants/formConfig'
            });

            if (!res || res.success !== true) {
                addLoadingEl.classList.add('hidden');
                addErrorEl.classList.remove('hidden');
                return;
            }

            cachedTerritories = res.data.territories ?? [];
            renderRoleOptions(res.data.roles);
            renderSourceOptions(res.data.sources);
            cachedFormFields = res.data.fields ?? [];

            addLoadingEl.classList.add('hidden');
            applicantFormEl.classList.remove('hidden');
        }

        function openAddModal() {
            initSideModal({
                modalId: 'addApplicantSideModal'
            });
        }

        addModalEl.addEventListener('click', function(e) {
            const target = e.target;
            if (target && target.matches && target.matches('input[type="date"]') && typeof target
                .showPicker === 'function') {
                try {
                    target.showPicker();
                } catch (_) {}
            }
        });

        saveApplicantBtn.addEventListener('click', async function(e) {
            e.preventDefault();

            const fullName = candidateNameInput.value.trim();

            if (!fullName) {
                showMessage({
                    status: 'error',
                    title: 'Missing required fields',
                    message: 'Candidate Name required.'
                });
                return;
            }

            const payload = {
                full_name: fullName,
                role_id: roleSelect.value ? Number(roleSelect.value) : null,
                source_id: sourceSelect.value ? Number(sourceSelect.value) : null,
                source_detail: sourceReferralNameWrap.classList.contains('hidden') ?
                    (sourceOtherSpecifyWrap.classList.contains('hidden') ? null : (
                        sourceOtherSpecifyInput.value
                        .trim() || null)) : (sourceReferralNameInput.value.trim() || null),
                phone: phoneInput.value.trim() || null,
                email: emailInput.value.trim() || null,
                date_of_birth: dobInput.value || null,
                notes: notesInput.value.trim() || null,
            };

            const res = await apiCall({
                mode: 'POST',
                isJson: true,
                payload,
                url: '/api/applicants',
                button: saveApplicantBtn
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: apiErrorMessage(res)
                });
                return;
            }

            showMessage({
                status: 'success',
                title: 'Applicant saved'
            });

            closeSideModal('addApplicantSideModal');
            resetAddForm();
            table.reload();
        });

        loadFormConfig();

        // ===================== VIEW APPLICANT MODAL =====================

        const viewModalEl = document.getElementById('viewApplicantSideModal');
        const viewLoadingEl = viewModalEl.querySelector('#applicantLoading');
        const viewErrorEl = viewModalEl.querySelector('#applicantError');
        const viewContentEl = viewModalEl.querySelector('#applicantContent');

        const viewNameEl = viewModalEl.querySelector('#applicantName');
        const viewStatusBadgeEl = viewModalEl.querySelector('#applicantStatusBadge');
        const viewStatusSelectEl = viewModalEl.querySelector('#applicantStatusSelect');
        const viewAssignedToEl = viewModalEl.querySelector('#applicantAssignedTo');
        const viewLocationEl = viewModalEl.querySelector('#applicantLocation');
        const viewRoleEl = viewModalEl.querySelector('#applicantRole');
        const viewSourceEl = viewModalEl.querySelector('#applicantSource');
        const viewPhoneEl = viewModalEl.querySelector('#applicantPhoneView');
        const viewEmailEl = viewModalEl.querySelector('#applicantEmailView');
        const viewDobEl = viewModalEl.querySelector('#applicantDobView');
        const viewCreatedAtEl = viewModalEl.querySelector('#applicantCreatedAt');
        const viewLastActivityEl = viewModalEl.querySelector('#applicantLastActivity');
        const viewAnswersListEl = viewModalEl.querySelector('#applicantAnswersList');
        const viewFilesListEl = viewModalEl.querySelector('#applicantFilesList');
        const viewChecklistListEl = viewModalEl.querySelector('#applicantChecklistList');
        const viewCloseBtn = viewModalEl.querySelector('.js-view-close');
        const viewInterviewSummaryEl = viewModalEl.querySelector('#applicantInterviewSummary');
        const saveInterviewSummaryBtn = viewModalEl.querySelector('#saveInterviewSummaryBtn');
        const btnInterview = viewModalEl.querySelector('#btnInterview');
        const btnCopyAnswers = viewModalEl.querySelector('#btnCopyAnswers');
        const btnEditAnswers = viewModalEl.querySelector('#btnEditAnswers');
        const btnEditInfo = viewModalEl.querySelector('#btnEditInfo');

        let currentApplicantId = null;
        let currentApplicant = null;

        function updateInterviewButtonVisibility() {
            if (currentApplicant && currentApplicant.status === 'New') {
                btnInterview.classList.remove('hidden');
            } else {
                btnInterview.classList.add('hidden');
            }
        }

        function renderViewHeader(applicant) {
            viewNameEl.textContent = applicant.full_name;
            viewStatusBadgeEl.innerHTML = statusBadge(applicant.status);
            viewAssignedToEl.textContent = applicant.assignee_name ?? '—';
            viewLocationEl.textContent = applicant.territory_name && applicant.location_name ?
                `${applicant.territory_name} — ${applicant.location_name}` :
                (applicant.location_name || applicant.territory_name || '—');
            viewRoleEl.textContent = applicant.role_name ?? '—';
            viewSourceEl.textContent = applicant.source_name ?
                (applicant.source_detail ? `${applicant.source_name} — ${applicant.source_detail}` : applicant
                    .source_name) : '—';
            viewPhoneEl.textContent = applicant.phone ?? '—';
            viewEmailEl.textContent = applicant.email ?? '—';
            viewDobEl.textContent = formatDateOnly(applicant.date_of_birth);
            viewCreatedAtEl.textContent = formatDate(applicant.created_at);
            viewLastActivityEl.textContent = formatDate(applicant.last_activity_at);

            viewStatusSelectEl.innerHTML = STATUSES
                .map(s => `<option value="${s}" ${s === applicant.status ? 'selected' : ''}>${s}</option>`)
                .join("");

            viewInterviewSummaryEl.value = applicant.interview_summary ?? '';

            btnEditAnswers.classList.toggle('hidden', !applicant.has_answers);

            updateScheduleOrientationButton();
            updateInterviewButtonVisibility();
        }

        function renderAnswers(answers) {
            if (!answers || !answers.length) {
                viewAnswersListEl.innerHTML = '<p class="text-sm text-zinc-400">No answers recorded.</p>';
                return;
            }

            viewAnswersListEl.innerHTML = answers.map(answer => {
                const value = Array.isArray(answer.value) ? answer.value.join(', ') : answer.value;
                const displayValue = (value === null || value === undefined || value === '') ? '—' : value;

                return `
                    <div class="flex flex-col gap-0.5 py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                        <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">${answer.label}</p>
                        <p class="text-sm text-zinc-800 dark:text-zinc-100">${displayValue}</p>
                    </div>
                `;
            }).join("");
        }

        function renderFiles(files) {
            if (!files || !files.length) {
                viewFilesListEl.innerHTML = '<p class="text-sm text-zinc-400">No files uploaded.</p>';
                return;
            }

            viewFilesListEl.innerHTML = files.map(file => `
                <a href="${file.url}" target="_blank" download
                    class="flex items-center gap-2 py-2 text-sm text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    ${file.original_name}
                </a>
            `).join("");
        }

        function renderChecklist(checklist) {
            if (!checklist || !checklist.length) {
                viewChecklistListEl.innerHTML =
                    '<p class="text-sm text-zinc-400">The checklist appears once the applicant enters the Interview stage.</p>';
                return;
            }

            const itemRow = (item) => `
                <label class="flex items-start gap-2 py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0 cursor-pointer"
                    data-checklist-item-id="${item.id}">
                    <input type="checkbox"
                        class="mt-0.5 rounded border-zinc-300 text-orange-500 focus:ring-orange-400 checklist-item-checkbox"
                        ${item.is_done ? 'checked' : ''}>
                    <span class="flex-1">
                        <span class="block text-sm text-zinc-800 dark:text-zinc-100">${item.label}</span>
                        <span class="checklist-item-caption block text-xs text-zinc-400">${item.is_done ? `Done by ${item.done_by_name ?? '—'} · ${formatDate(item.done_at)}` : ''}</span>
                    </span>
                </label>
            `;

            // Group items under their checklist group's header, in the
            // order groups first appear; ungrouped items are collected into
            // a trailing, unheaded bucket.
            const groups = [];
            const groupsById = new Map();
            const ungrouped = [];

            checklist.forEach(item => {
                if (!item.checklist_group_id) {
                    ungrouped.push(item);
                    return;
                }
                if (!groupsById.has(item.checklist_group_id)) {
                    const bucket = {
                        label: item.group_label,
                        targetStatus: item.group_target_status,
                        items: []
                    };
                    groupsById.set(item.checklist_group_id, bucket);
                    groups.push(bucket);
                }
                groupsById.get(item.checklist_group_id).items.push(item);
            });

            const groupSection = (bucket) => `
                <div class="mb-3">
                    <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400 mb-1">${bucket.label}
                        <span class="normal-case font-normal text-zinc-400">→ ${bucket.targetStatus}</span>
                    </p>
                    ${bucket.items.map(itemRow).join("")}
                </div>
            `;

            viewChecklistListEl.innerHTML =
                groups.map(groupSection).join("") +
                (ungrouped.length ? ungrouped.map(itemRow).join("") : "");
        }

        function renderViewAll(applicant) {
            currentApplicant = applicant;
            renderViewHeader(applicant);
            renderAnswers(applicant.answers);
            renderFiles(applicant.files);
            renderChecklist(applicant.checklist);
        }

        async function loadApplicant(id) {
            viewLoadingEl.classList.remove('hidden');
            viewErrorEl.classList.add('hidden');
            viewContentEl.classList.add('hidden');

            const res = await apiCall({
                mode: 'GET',
                url: `/api/applicants/${id}`
            });

            if (!res || res.success !== true) {
                viewLoadingEl.classList.add('hidden');
                viewErrorEl.classList.remove('hidden');
                return;
            }

            renderViewAll(res.data);
            await loadNotes(id);
            await loadActivity(id);

            viewLoadingEl.classList.add('hidden');
            viewContentEl.classList.remove('hidden');
        }

        function openViewModal(id) {
            currentApplicantId = id;
            noteComposerEl.classList.add('hidden');
            noteInputEl.value = '';
            initSideModal({
                modalId: 'viewApplicantSideModal'
            });
            loadApplicant(id);
        }

        viewModalEl.addEventListener('click', function(e) {
            const target = e.target;
            if (target && target.matches && target.matches('input[type="date"]') && typeof target
                .showPicker === 'function') {
                try {
                    target.showPicker();
                } catch (_) {}
            }
        });

        viewStatusSelectEl.addEventListener('change', async () => {
            const newStatus = viewStatusSelectEl.value;
            const previousStatus = currentApplicant?.status;

            const res = await apiCall({
                mode: 'PATCH',
                isJson: true,
                payload: {
                    status: newStatus
                },
                url: `/api/applicants/${currentApplicantId}/status`
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: apiErrorMessage(res)
                });
                viewStatusSelectEl.value = previousStatus ?? newStatus;
                return;
            }

            currentApplicant.status = res.data.status;
            currentApplicant.checklist = res.data.checklist;
            viewStatusBadgeEl.innerHTML = statusBadge(res.data.status);
            renderChecklist(res.data.checklist);
            updateScheduleOrientationButton();
        });

        viewChecklistListEl.addEventListener('change', async (e) => {
            const checkbox = e.target.closest('.checklist-item-checkbox');
            if (!checkbox) return;

            const label = checkbox.closest('[data-checklist-item-id]');
            const itemId = label.dataset.checklistItemId;
            const isDone = checkbox.checked;

            const res = await apiCall({
                mode: 'PATCH',
                isJson: true,
                payload: {
                    is_done: isDone
                },
                url: `/api/applicants/${currentApplicantId}/checklist/${itemId}`
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: apiErrorMessage(res)
                });
                checkbox.checked = !isDone;
                return;
            }

            checkbox.checked = res.data.is_done;
            const caption = label.querySelector('.checklist-item-caption');
            caption.textContent = res.data.is_done ?
                `Done by ${res.data.done_by_name ?? '—'} · ${formatDate(res.data.done_at)}` : '';

            if (res.status_advanced) {
                currentApplicant.status = res.status;
                viewStatusBadgeEl.innerHTML = statusBadge(res.status);
                if (![...viewStatusSelectEl.options].some(o => o.value === res.status)) {
                    viewStatusSelectEl.insertAdjacentHTML('beforeend',
                        `<option value="${res.status}">${res.status}</option>`);
                }
                viewStatusSelectEl.value = res.status;
                updateScheduleOrientationButton();
                showMessage({
                    status: 'success',
                    title: 'Status advanced!',
                    message: `"${res.advanced_by_group}" checklist complete — status set to "${res.status}".`
                });
                table.reload();
            }
        });

        viewCloseBtn.addEventListener('click', function() {
            closeSideModal('viewApplicantSideModal');
            table.reload();
        });

        saveInterviewSummaryBtn.addEventListener('click', async function() {
            const value = viewInterviewSummaryEl.value.trim();

            const res = await apiCall({
                mode: 'PATCH',
                isJson: true,
                payload: {
                    interview_summary: value || null
                },
                url: `/api/applicants/${currentApplicantId}/interviewSummary`,
                button: saveInterviewSummaryBtn
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: apiErrorMessage(res)
                });
                return;
            }

            currentApplicant.interview_summary = res.data.interview_summary;

            showMessage({
                status: 'success',
                title: 'Interview summary saved!'
            });
        });

        // navigator.clipboard is only defined in a secure context (HTTPS,
        // or the special-cased http://localhost) - on a plain-HTTP LAN
        // address it's simply undefined, so calling .writeText on it throws
        // immediately. Fall back to the legacy execCommand technique so the
        // button still works there.
        async function copyTextToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(text);
                return;
            }

            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();

            try {
                const copied = document.execCommand('copy');
                if (!copied) throw new Error('execCommand copy returned false');
            } finally {
                document.body.removeChild(textarea);
            }
        }

        btnCopyAnswers.addEventListener('click', async function() {
            const answers = currentApplicant?.answers || [];

            if (!answers.length) {
                showMessage({
                    status: 'error',
                    title: 'Nothing to copy',
                    message: 'This applicant has no interview answers yet.'
                });
                return;
            }

            const header = [
                `Applicant Name: ${currentApplicant?.full_name ?? '—'}`,
                `Location: ${currentApplicant?.location_name ?? '—'}`,
                `Role: ${currentApplicant?.role_name ?? '—'}`,
            ].join('\n');

            const answersText = answers.map(a => {
                const value = Array.isArray(a.value) ? a.value.join(', ') : a.value;
                const displayValue = (value === null || value === undefined || value === '') ?
                    '—' : value;
                return `${a.label}: ${displayValue}`;
            }).join('\n');

            const text = `${header}\n\n${answersText}`;

            try {
                await copyTextToClipboard(text);
                showMessage({
                    status: 'success',
                    title: 'Answers copied!'
                });
            } catch (err) {
                console.error('Copy to clipboard failed:', err);
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: 'Could not copy to clipboard.'
                });
            }
        });

        btnInterview.addEventListener('click', function() {
            openInterviewModal();
        });

        // ===================== EDIT APPLICANT INFO MODAL =====================

        const editModalEl = document.getElementById('editApplicantSideModal');
        const editFullNameInput = editModalEl.querySelector('#editFullName');
        const editRoleSelect = editModalEl.querySelector('#editRoleSelect');
        const editSourceSelect = editModalEl.querySelector('#editSourceSelect');
        const editSourceReferralNameWrap = editModalEl.querySelector('#editSourceReferralNameWrap');
        const editSourceReferralNameInput = editModalEl.querySelector('#editSourceReferralNameInput');
        const editSourceOtherSpecifyWrap = editModalEl.querySelector('#editSourceOtherSpecifyWrap');
        const editSourceOtherSpecifyInput = editModalEl.querySelector('#editSourceOtherSpecifyInput');
        const editTerritorySelect = editModalEl.querySelector('#editTerritorySelect');
        const editLocationSelect = editModalEl.querySelector('#editLocationSelect');
        const editPhoneInput = editModalEl.querySelector('#editPhone');
        const editEmailInput = editModalEl.querySelector('#editEmail');
        const editDobInput = editModalEl.querySelector('#editDob');
        const saveEditInfoBtn = editModalEl.querySelector('#saveEditInfoBtn');

        function toggleEditSourceDetailFields() {
            const selected = cachedSources.find(s => String(s.id) === String(editSourceSelect.value));
            const name = selected?.name ?? '';

            const isReferral = name === 'Employee Referral';
            const isOther = name === 'Other';

            editSourceReferralNameWrap.classList.toggle('hidden', !isReferral);
            editSourceOtherSpecifyWrap.classList.toggle('hidden', !isOther);

            if (!isReferral) editSourceReferralNameInput.value = '';
            if (!isOther) editSourceOtherSpecifyInput.value = '';
        }

        editSourceSelect.addEventListener('change', toggleEditSourceDetailFields);

        editTerritorySelect.addEventListener('change', function() {
            const territory = cachedTerritories.find(t => String(t.id) === String(editTerritorySelect
                .value));
            populateLocationSelect(editLocationSelect, territory);
        });

        editModalEl.addEventListener('click', function(e) {
            const target = e.target;
            if (target && target.matches && target.matches('input[type="date"]') && typeof target
                .showPicker === 'function') {
                try {
                    target.showPicker();
                } catch (_) {}
            }
        });

        btnEditInfo.addEventListener('click', function() {
            if (!currentApplicant) return;

            editFullNameInput.value = currentApplicant.full_name ?? '';

            populateTerritorySelect(editTerritorySelect, cachedTerritories);
            editRoleSelect.innerHTML = '<option value="">Select role</option>' +
                cachedRoles.map(r => `<option value="${r.id}">${r.name}</option>`).join("");
            editSourceSelect.innerHTML = '<option value="">Select source</option>' +
                cachedSources.map(s => `<option value="${s.id}">${s.name}</option>`).join("");

            editRoleSelect.value = currentApplicant.role_id != null ? String(currentApplicant.role_id) : '';
            editSourceSelect.value = currentApplicant.source_id != null ? String(currentApplicant
                .source_id) : '';
            toggleEditSourceDetailFields();

            // Source detail: prefill whichever conditional input applies
            // (Employee Referral name / Other specify).
            if (!editSourceReferralNameWrap.classList.contains('hidden')) {
                editSourceReferralNameInput.value = currentApplicant.source_detail ?? '';
            } else if (!editSourceOtherSpecifyWrap.classList.contains('hidden')) {
                editSourceOtherSpecifyInput.value = currentApplicant.source_detail ?? '';
            }

            if (currentApplicant.territory_id) {
                editTerritorySelect.value = String(currentApplicant.territory_id);
                const territory = cachedTerritories.find(t => String(t.id) === String(currentApplicant
                    .territory_id));
                populateLocationSelect(editLocationSelect, territory);
                editLocationSelect.value = currentApplicant.location_id != null ? String(currentApplicant
                    .location_id) : '';
            } else {
                editTerritorySelect.value = '';
                populateLocationSelect(editLocationSelect, null);
            }

            editPhoneInput.value = currentApplicant.phone ?? '';
            editEmailInput.value = currentApplicant.email ?? '';

            // date_of_birth arrives pre-formatted ("January 1, 2001") from
            // show() - best-effort parse back to YYYY-MM-DD for the
            // <input type=date>; leave blank if it can't be parsed. Built
            // from local date parts (not toISOString) to avoid a timezone
            // day-shift.
            editDobInput.value = '';
            if (currentApplicant.date_of_birth) {
                const parsed = new Date(currentApplicant.date_of_birth);
                if (!isNaN(parsed.getTime())) {
                    editDobInput.value = parsed.getFullYear() + '-' +
                        String(parsed.getMonth() + 1).padStart(2, '0') + '-' +
                        String(parsed.getDate()).padStart(2, '0');
                }
            }

            initSideModal({
                modalId: 'editApplicantSideModal'
            });
        });

        saveEditInfoBtn.addEventListener('click', async function() {
            const fullName = editFullNameInput.value.trim();

            if (!fullName) {
                showMessage({
                    status: 'error',
                    title: 'Missing required fields',
                    message: 'Full Name required.'
                });
                return;
            }

            const payload = {
                full_name: fullName,
                role_id: editRoleSelect.value ? Number(editRoleSelect.value) : null,
                source_id: editSourceSelect.value ? Number(editSourceSelect.value) : null,
                source_detail: editSourceReferralNameWrap.classList.contains('hidden') ?
                    (editSourceOtherSpecifyWrap.classList.contains('hidden') ? null : (
                        editSourceOtherSpecifyInput.value.trim() || null)) : (
                        editSourceReferralNameInput.value.trim() || null),
                territory_id: editTerritorySelect.value ? Number(editTerritorySelect.value) : null,
                location_id: editLocationSelect.value ? Number(editLocationSelect.value) : null,
                phone: editPhoneInput.value.trim() || null,
                email: editEmailInput.value.trim() || null,
                date_of_birth: editDobInput.value || null,
            };

            const res = await apiCall({
                mode: 'PATCH',
                isJson: true,
                payload,
                url: `/api/applicants/${currentApplicantId}/info`,
                button: saveEditInfoBtn
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: apiErrorMessage(res)
                });
                return;
            }

            showMessage({
                status: 'success',
                title: 'Applicant updated'
            });

            closeSideModal('editApplicantSideModal');
            await loadApplicant(currentApplicantId);
            table.reload();
        });

        // ===================== INTERVIEW MODAL =====================

        const INPUT_CLASSES =
            "w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-orange-500 transition";
        const LABEL_CLASSES = "text-[11px] font-medium uppercase tracking-widest text-zinc-400";

        const interviewModalEl = document.getElementById('interviewApplicantSideModal');
        const interviewLoadingEl = interviewModalEl.querySelector('#interviewFormLoading');
        const interviewErrorEl = interviewModalEl.querySelector('#interviewFormError');
        const interviewFormEl = interviewModalEl.querySelector('#interviewForm');
        const interviewFieldsContainer = interviewModalEl.querySelector('#interviewFieldsContainer');
        const submitInterviewBtn = interviewModalEl.querySelector('#submitInterviewBtn');

        const outcomeModalEl = document.getElementById('interviewOutcomeModal');
        const interviewPassBtn = outcomeModalEl.querySelector('#interviewPassBtn');
        const interviewFailBtn = outcomeModalEl.querySelector('#interviewFailBtn');

        let currentFields = [];

        // 'interview' (Interview button flow: territory/location row +
        // pass/fail/incomplete) or 'edit' (Edit Answers flow: dynamic
        // fields only, PATCHes /answers, no outcome).
        let interviewMode = 'interview';

        function requiredMark(field) {
            return field.is_required ? ' <span class="text-red-500">*</span>' : '';
        }

        function helpTextHtml(field) {
            return field.help_text ? `<p class="text-xs text-zinc-400">${field.help_text}</p>` : '';
        }

        const FIELD_RENDERERS = {
            text: (field) =>
                `<input type="text" class="${INPUT_CLASSES}" name="form_data[${field.field_key}]" ${field.is_required ? 'required' : ''}>`,
            number: (field) =>
                `<input type="number" class="${INPUT_CLASSES}" name="form_data[${field.field_key}]" ${field.is_required ? 'required' : ''}>`,
            textarea: (field) =>
                `<textarea rows="3" class="${INPUT_CLASSES}" name="form_data[${field.field_key}]" ${field.is_required ? 'required' : ''}></textarea>`,
            date: (field) =>
                `<input type="date" class="${INPUT_CLASSES}" name="form_data[${field.field_key}]" ${field.is_required ? 'required' : ''}>`,
            select: (field) => `
                <select class="${INPUT_CLASSES}" name="form_data[${field.field_key}]" ${field.is_required ? 'required' : ''}>
                    <option value="">Select ${field.label}</option>
                    ${(field.options ?? []).map(opt => `<option value="${opt}">${opt}</option>`).join("")}
                </select>
            `,
            radio: (field) => `
                <div class="flex flex-wrap gap-4">
                    ${(field.options ?? []).map(opt => `
                        <label class="flex items-center gap-1.5 text-sm text-zinc-700 dark:text-zinc-200 cursor-pointer">
                            <input type="radio" name="${field.field_key}" value="${opt}" class="text-orange-500 focus:ring-orange-400">
                            ${opt}
                        </label>
                    `).join("")}
                </div>
            `,
            checkbox: (field) => `
                <div class="flex flex-wrap gap-4">
                    ${(field.options ?? []).map(opt => `
                        <label class="flex items-center gap-1.5 text-sm text-zinc-700 dark:text-zinc-200 cursor-pointer">
                            <input type="checkbox" name="form_data[${field.field_key}][]" value="${opt}" class="rounded border-zinc-300 text-orange-500 focus:ring-orange-400">
                            ${opt}
                        </label>
                    `).join("")}
                </div>
            `,
            file: (field) =>
                `<input type="file" class="${INPUT_CLASSES}" name="files[${field.field_key}]">`,
        };

        function renderField(field) {
            const renderer = FIELD_RENDERERS[field.type] ?? FIELD_RENDERERS.text;
            const conditionAttrs = field.condition_field_key ?
                ` data-condition-field="${field.condition_field_key}" data-condition-value="${field.condition_value}"` :
                '';
            return `
                <div class="flex flex-col gap-1" data-field-key="${field.field_key}" data-field-type="${field.type}"${conditionAttrs}>
                    <label class="${LABEL_CLASSES}">${field.label}${requiredMark(field)}</label>
                    ${renderer(field)}
                    ${helpTextHtml(field)}
                </div>
            `;
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

        function territoryLocationRowHtml() {
            return `
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="${LABEL_CLASSES}">Territory</label>
                        <select id="interviewTerritorySelect" class="${INPUT_CLASSES}">
                            <option value="">Select territory</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="${LABEL_CLASSES}">Location</label>
                        <select id="interviewLocationSelect" class="${INPUT_CLASSES}">
                            <option value="">Select a territory first</option>
                        </select>
                    </div>
                </div>
            `;
        }

        function setupTerritoryLocationRow() {
            const territorySelect = interviewFieldsContainer.querySelector('#interviewTerritorySelect');
            const locationSelect = interviewFieldsContainer.querySelector('#interviewLocationSelect');
            if (!territorySelect || !locationSelect) return;

            populateTerritorySelect(territorySelect, cachedTerritories);

            territorySelect.addEventListener('change', function() {
                const territory = cachedTerritories.find(t => String(t.id) === String(territorySelect
                    .value));
                populateLocationSelect(locationSelect, territory);
            });

            if (currentApplicant && currentApplicant.territory_id) {
                territorySelect.value = String(currentApplicant.territory_id);
                const territory = cachedTerritories.find(t => String(t.id) === String(currentApplicant
                    .territory_id));
                populateLocationSelect(locationSelect, territory);
                locationSelect.value = currentApplicant.location_id != null ? String(currentApplicant
                    .location_id) : '';
            }
        }

        function renderInterviewFields(fields, options) {
            options = options || {};
            currentFields = fields ?? [];
            const dynamicHtml = orderFieldsWithConditionalChildren(currentFields).map(renderField).join("");
            interviewFieldsContainer.innerHTML = (options.includeTerritoryLocation ?
                territoryLocationRowHtml() : '') + dynamicHtml;
            applyConditions();

            if (options.includeTerritoryLocation) setupTerritoryLocationRow();
        }

        function getFieldContainer(fieldKey) {
            return interviewFieldsContainer.querySelector(`[data-field-key="${fieldKey}"]`);
        }

        function getFieldValue(fieldKey) {
            const container = getFieldContainer(fieldKey);
            if (!container) return '';

            const type = container.dataset.fieldType;

            if (type === 'radio') {
                const checked = container.querySelector('input[type="radio"]:checked');
                return checked ? checked.value : '';
            }

            if (type === 'checkbox') {
                const checked = container.querySelector('input[type="checkbox"]:checked');
                return checked ? checked.value : '';
            }

            const input = container.querySelector('input, textarea, select');
            return input ? input.value : '';
        }

        function applyConditions() {
            interviewFieldsContainer.querySelectorAll('[data-condition-field]').forEach(wrapper => {
                const conditionField = wrapper.dataset.conditionField;
                const conditionValue = wrapper.dataset.conditionValue;
                const currentValue = getFieldValue(conditionField);
                const show = String(currentValue) === String(conditionValue);

                wrapper.classList.toggle('hidden', !show);

                if (!show) {
                    wrapper.querySelectorAll('input, textarea, select').forEach(input => {
                        if (input.type === 'checkbox' || input.type === 'radio') {
                            input.checked = false;
                        } else {
                            input.value = '';
                        }
                    });
                }
            });
        }

        interviewFormEl.addEventListener('input', applyConditions);
        interviewFormEl.addEventListener('change', applyConditions);

        function validateRequiredFields() {
            const missing = [];

            currentFields.forEach(field => {
                if (!field.is_required) return;
                const container = getFieldContainer(field.field_key);
                if (!container) return;
                if (container.classList.contains('hidden')) return;

                if (field.type === 'file') {
                    const input = container.querySelector('input[type="file"]');
                    if (!input || !input.files.length) missing.push(field.label);
                    return;
                }

                if (field.type === 'radio') {
                    const checked = container.querySelector('input[type="radio"]:checked');
                    if (!checked) missing.push(field.label);
                    return;
                }

                if (field.type === 'checkbox') {
                    const checked = container.querySelectorAll('input[type="checkbox"]:checked');
                    if (!checked.length) missing.push(field.label);
                    return;
                }

                const input = container.querySelector('input, textarea, select');
                if (!input || !input.value.trim()) missing.push(field.label);
            });

            return missing;
        }

        function buildAnswersMap(answers) {
            const map = {};
            (answers || []).forEach(a => {
                map[a.field_key] = a.value;
            });
            return map;
        }

        function prefillInterviewFields(answersMap) {
            currentFields.forEach(field => {
                if (field.type === 'file') return;

                const container = getFieldContainer(field.field_key);
                if (!container) return;

                const value = answersMap[field.field_key];
                if (value === undefined || value === null) return;

                if (field.type === 'radio') {
                    container.querySelectorAll('input[type="radio"]').forEach(r => {
                        r.checked = (String(r.value) === String(value));
                    });
                    return;
                }

                if (field.type === 'checkbox') {
                    const values = Array.isArray(value) ? value.map(String) : [String(value)];
                    container.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                        cb.checked = values.includes(String(cb.value));
                    });
                    return;
                }

                const input = container.querySelector('input, textarea, select');
                if (input) input.value = value;
            });

            applyConditions();
        }

        function appendCurrentFieldsToFormData(formData) {
            currentFields.forEach(field => {
                const container = getFieldContainer(field.field_key);
                if (!container) return;
                if (container.classList.contains('hidden')) return;

                if (field.type === 'file') {
                    const input = container.querySelector('input[type="file"]');
                    if (input && input.files.length) formData.append(`files[${field.field_key}]`, input
                        .files[0]);
                    return;
                }

                if (field.type === 'radio') {
                    const checked = container.querySelector('input[type="radio"]:checked');
                    if (checked) formData.append(`form_data[${field.field_key}]`, checked.value);
                    return;
                }

                if (field.type === 'checkbox') {
                    container.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
                        formData.append(`form_data[${field.field_key}][]`, cb.value);
                    });
                    return;
                }

                const input = container.querySelector('input, textarea, select');
                if (input && input.value !== '') formData.append(`form_data[${field.field_key}]`, input
                    .value);
            });
        }

        function buildInterviewFormData(outcome) {
            const formData = new FormData();
            appendCurrentFieldsToFormData(formData);

            const territorySelect = interviewFieldsContainer.querySelector('#interviewTerritorySelect');
            const locationSelect = interviewFieldsContainer.querySelector('#interviewLocationSelect');
            if (territorySelect && territorySelect.value) formData.append('territory_id', territorySelect.value);
            if (locationSelect && locationSelect.value) formData.append('location_id', locationSelect.value);

            formData.append('outcome', outcome);
            formData.append('_method', 'PATCH');

            return formData;
        }

        // Used by the Edit Answers flow (interviewMode === 'edit') - answers
        // only, no outcome/territory/location, PATCHes /answers instead of
        // /interview.
        function buildAnswersFormData() {
            const formData = new FormData();
            appendCurrentFieldsToFormData(formData);
            formData.append('_method', 'PATCH');
            return formData;
        }

        async function submitIncompleteInterview(button) {
            const territorySelect = interviewFieldsContainer.querySelector('#interviewTerritorySelect');
            const locationSelect = interviewFieldsContainer.querySelector('#interviewLocationSelect');

            const formData = new FormData();
            formData.append('incomplete', '1');
            formData.append('_method', 'PATCH');
            if (territorySelect && territorySelect.value) formData.append('territory_id', territorySelect
                .value);
            if (locationSelect && locationSelect.value) formData.append('location_id', locationSelect.value);

            const res = await apiCall({
                mode: 'POST',
                isJson: false,
                payload: formData,
                url: `/api/applicants/${currentApplicantId}/interview`,
                button
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: apiErrorMessage(res)
                });
                return;
            }

            closeSideModal('interviewApplicantSideModal');

            showMessage({
                status: 'success',
                title: 'Applicant marked as rejected.'
            });

            await loadApplicant(currentApplicantId);
            table.reload();
        }

        async function ensureFormFieldsLoaded() {
            let fields = cachedFormFields;

            if (!fields) {
                const res = await apiCall({
                    mode: 'GET',
                    url: '/api/applicants/formConfig'
                });

                if (!res || res.success !== true) return null;

                cachedFormFields = res.data.fields ?? [];
                cachedTerritories = res.data.territories ?? cachedTerritories;
                fields = cachedFormFields;
            }

            return fields;
        }

        async function openInterviewModal() {
            if (!currentApplicantId) return;

            interviewMode = 'interview';
            submitInterviewBtn.textContent = 'Submit Interview';

            initSideModal({
                modalId: 'interviewApplicantSideModal'
            });

            interviewLoadingEl.classList.remove('hidden');
            interviewErrorEl.classList.add('hidden');
            interviewFormEl.classList.add('hidden');

            const fields = await ensureFormFieldsLoaded();

            if (!fields) {
                interviewLoadingEl.classList.add('hidden');
                interviewErrorEl.classList.remove('hidden');
                return;
            }

            renderInterviewFields(fields, {
                includeTerritoryLocation: true
            });
            prefillInterviewFields(buildAnswersMap(currentApplicant?.answers));

            interviewLoadingEl.classList.add('hidden');
            interviewFormEl.classList.remove('hidden');
        }

        async function openEditAnswersModal() {
            if (!currentApplicantId) return;

            interviewMode = 'edit';
            submitInterviewBtn.textContent = 'Save Answers';

            initSideModal({
                modalId: 'interviewApplicantSideModal'
            });

            interviewLoadingEl.classList.remove('hidden');
            interviewErrorEl.classList.add('hidden');
            interviewFormEl.classList.add('hidden');

            const fields = await ensureFormFieldsLoaded();

            if (!fields) {
                interviewLoadingEl.classList.add('hidden');
                interviewErrorEl.classList.remove('hidden');
                return;
            }

            renderInterviewFields(fields, {
                includeTerritoryLocation: false
            });
            prefillInterviewFields(buildAnswersMap(currentApplicant?.answers));

            interviewLoadingEl.classList.add('hidden');
            interviewFormEl.classList.remove('hidden');
        }

        btnEditAnswers.addEventListener('click', function() {
            openEditAnswersModal();
        });

        interviewModalEl.addEventListener('click', function(e) {
            const target = e.target;
            if (target && target.matches && target.matches('input[type="date"]') && typeof target
                .showPicker === 'function') {
                try {
                    target.showPicker();
                } catch (_) {}
            }
        });

        submitInterviewBtn.addEventListener('click', async function(e) {
            e.preventDefault();

            if (interviewMode === 'edit') {
                const formData = buildAnswersFormData();

                const res = await apiCall({
                    mode: 'POST',
                    isJson: false,
                    payload: formData,
                    url: `/api/applicants/${currentApplicantId}/answers`,
                    button: this
                });

                if (!res || res.success !== true) {
                    showMessage({
                        status: 'error',
                        title: 'Error',
                        message: apiErrorMessage(res)
                    });
                    return;
                }

                closeSideModal('interviewApplicantSideModal');

                showMessage({
                    status: 'success',
                    title: 'Answers saved'
                });

                await loadApplicant(currentApplicantId);
                table.reload();
                return;
            }

            const missing = validateRequiredFields();

            if (missing.length) {
                const ok = await customConfirm(
                    'This interview form is incomplete. Submit anyway? The applicant will be marked Rejected.'
                );
                if (!ok) return;

                await submitIncompleteInterview(this);
                return;
            }

            initModal({
                modalId: 'interviewOutcomeModal'
            });
        });

        async function submitInterviewOutcome(outcome, button) {
            const formData = buildInterviewFormData(outcome);

            const res = await apiCall({
                mode: 'POST',
                isJson: false,
                payload: formData,
                url: `/api/applicants/${currentApplicantId}/interview`,
                button
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: apiErrorMessage(res)
                });
                return;
            }

            document.querySelector('#interviewOutcomeModal .modal-close').click();
            closeSideModal('interviewApplicantSideModal');

            showMessage({
                status: 'success',
                title: outcome === 'pass' ? 'Interview passed!' : 'Interview marked as failed.'
            });

            await loadApplicant(currentApplicantId);
            table.reload();
        }

        interviewPassBtn.addEventListener('click', function() {
            submitInterviewOutcome('pass', this);
        });

        interviewFailBtn.addEventListener('click', function() {
            submitInterviewOutcome('fail', this);
        });

        // ===================== ORIENTATION MODAL =====================

        const orientationModalEl = document.getElementById('orientationModal');
        const orientationDateInput = orientationModalEl.querySelector('#orientationDateInput');
        const saveOrientationBtn = orientationModalEl.querySelector('#saveOrientationBtn');
        const btnScheduleOrientation = viewModalEl.querySelector('#btnScheduleOrientation');

        function updateScheduleOrientationButton() {
            if (!currentApplicant || currentApplicant.status !== 'Orientation') {
                btnScheduleOrientation.classList.add('hidden');
                return;
            }

            btnScheduleOrientation.classList.remove('hidden');

            if (currentApplicant.orientation && currentApplicant.orientation.scheduled_date) {
                btnScheduleOrientation.textContent =
                    `Reschedule — ${formatDateOnly(currentApplicant.orientation.scheduled_date)}`;
            } else {
                btnScheduleOrientation.textContent = 'Schedule Orientation';
            }
        }

        btnScheduleOrientation.addEventListener('click', function() {
            orientationDateInput.value = currentApplicant?.orientation?.scheduled_date ?
                String(currentApplicant.orientation.scheduled_date).slice(0, 10) : '';

            initModal({
                modalId: 'orientationModal'
            });
        });

        orientationModalEl.addEventListener('click', function(e) {
            const target = e.target;
            if (target && target.matches && target.matches('input[type="date"]') && typeof target
                .showPicker === 'function') {
                try {
                    target.showPicker();
                } catch (_) {}
            }
        });

        saveOrientationBtn.addEventListener('click', async function() {
            const value = orientationDateInput.value;

            if (!value) {
                orientationDateInput.focus();
                return;
            }

            const res = await apiCall({
                mode: 'PUT',
                isJson: true,
                payload: {
                    scheduled_date: value
                },
                url: `/api/applicants/${currentApplicantId}/orientation`,
                button: saveOrientationBtn
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: apiErrorMessage(res)
                });
                return;
            }

            showMessage({
                status: 'success',
                title: 'Orientation scheduled!'
            });

            document.querySelector('#orientationModal .modal-close').click();
            currentApplicant.orientation = res.data;
            updateScheduleOrientationButton();
        });

        // ===================== NOTES =====================

        const notesListEl = viewModalEl.querySelector('#notesList');
        const noteComposerEl = viewModalEl.querySelector('#noteComposer');
        const noteInputEl = viewModalEl.querySelector('#noteInput');
        const btnAddNote = viewModalEl.querySelector('#btnAddNote');
        const saveNoteBtn = viewModalEl.querySelector('#saveNoteBtn');
        const cancelNoteBtn = viewModalEl.querySelector('#cancelNoteBtn');

        let currentNotes = [];

        function noteRowHtml(note) {
            return `
                <div class="flex flex-col gap-0.5 py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <p class="text-sm text-zinc-800 dark:text-zinc-100">${note.note}</p>
                    <p class="text-xs text-zinc-400">— ${note.created_by_name ?? '—'} · ${formatDate(note.created_at)}</p>
                </div>
            `;
        }

        function renderNotes() {
            if (!currentNotes.length) {
                notesListEl.innerHTML = '<p class="text-sm text-zinc-400">No notes yet.</p>';
                return;
            }

            notesListEl.innerHTML = currentNotes.map(noteRowHtml).join("");
        }

        async function loadNotes(id) {
            const res = await apiCall({
                mode: 'GET',
                url: `/api/applicants/${id}/notes`
            });

            if (!res || res.success !== true) {
                currentNotes = [];
                renderNotes();
                return;
            }

            currentNotes = Array.isArray(res.data) ? res.data : [];
            renderNotes();
        }

        // ===================== ACTIVITY HISTORY =====================

        const activityListEl = viewModalEl.querySelector('#activityList');

        function activityRowHtml(entry) {
            return `
                <div class="py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <p class="text-sm text-zinc-800 dark:text-zinc-100">${entry.description}</p>
                    <p class="text-xs text-zinc-400">— ${entry.actor_name ?? 'System'} · ${formatDate(entry.created_at)}</p>
                </div>
            `;
        }

        async function loadActivity(id) {
            const res = await apiCall({
                mode: 'GET',
                url: `/api/applicants/${id}/activity`
            });

            const entries = (res && res.success === true && Array.isArray(res.data)) ? res.data : [];

            activityListEl.innerHTML = entries.length ?
                entries.map(activityRowHtml).join("") :
                '<p class="text-sm text-zinc-400">No activity yet.</p>';
        }

        btnAddNote.addEventListener('click', function() {
            noteInputEl.value = '';
            noteComposerEl.classList.remove('hidden');
            noteInputEl.focus();
        });

        cancelNoteBtn.addEventListener('click', function() {
            noteComposerEl.classList.add('hidden');
            noteInputEl.value = '';
        });

        saveNoteBtn.addEventListener('click', async function() {
            const text = noteInputEl.value.trim();

            if (!text) {
                noteInputEl.focus();
                return;
            }

            const res = await apiCall({
                mode: 'POST',
                isJson: true,
                payload: {
                    note: text
                },
                url: `/api/applicants/${currentApplicantId}/notes`,
                button: saveNoteBtn
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: apiErrorMessage(res)
                });
                return;
            }

            showMessage({
                status: 'success',
                title: 'Note added!'
            });

            currentNotes.unshift(res.data);
            renderNotes();

            noteComposerEl.classList.add('hidden');
            noteInputEl.value = '';
        });

        // ===================== EXPORT =====================

        const exportBtn = document.getElementById('btnExportApplicants');
        const exportPanel = document.getElementById('exportPanel');
        const exportFromInput = document.getElementById('exportFrom');
        const exportToInput = document.getElementById('exportTo');
        const exportStatusFilterEl = document.getElementById('exportStatusFilter');

        function toISODateLocal(d) {
            return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d
                .getDate()).padStart(2, '0');
        }

        function parseISODateLocal(s) {
            if (!s) return null;
            const parts = s.split('-');
            if (parts.length !== 3) return null;
            return new Date(+parts[0], +parts[1] - 1, +parts[2]);
        }

        function getMondayOfWeek(d) {
            const day = (d.getDay() + 6) % 7;
            const monday = new Date(d);
            monday.setDate(d.getDate() - day);
            return monday;
        }

        let exportCalendar = null;
        if (typeof flatpickr === 'function') {
            exportCalendar = flatpickr('#exportCalendar', {
                mode: 'range',
                inline: true,
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates) {
                    if (selectedDates.length >= 1) exportFromInput.value = toISODateLocal(selectedDates[
                        0]);
                    if (selectedDates.length === 2) exportToInput.value = toISODateLocal(selectedDates[
                        1]);
                }
            });
        }

        function setExportRange(from, to) {
            exportFromInput.value = toISODateLocal(from);
            exportToInput.value = toISODateLocal(to);
            if (exportCalendar) exportCalendar.setDate([from, to], false);
        }

        [exportFromInput, exportToInput].forEach(input => {
            input.addEventListener('change', function() {
                const from = parseISODateLocal(exportFromInput.value);
                const to = parseISODateLocal(exportToInput.value);
                if (exportCalendar && from && to) exportCalendar.setDate([from, to], false);
            });
        });

        exportBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            exportPanel.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!exportPanel.classList.contains('hidden') && !exportPanel.contains(e.target) && e.target !==
                exportBtn) {
                exportPanel.classList.add('hidden');
            }
        });

        document.getElementById('exportPresetToday').addEventListener('click', function() {
            const t = new Date();
            setExportRange(t, t);
        });

        document.getElementById('exportPresetThisWeek').addEventListener('click', function() {
            const monday = getMondayOfWeek(new Date());
            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6);
            setExportRange(monday, sunday);
        });

        document.getElementById('exportPresetLastWeek').addEventListener('click', function() {
            const monday = getMondayOfWeek(new Date());
            monday.setDate(monday.getDate() - 7);
            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6);
            setExportRange(monday, sunday);
        });

        document.getElementById('exportRunBtn').addEventListener('click', function() {
            const fmt = document.getElementById('exportFormat').value;
            const from = exportFromInput.value;
            const to = exportToInput.value;
            const status = exportStatusFilterEl ?
                Array.from(exportStatusFilterEl.querySelectorAll('.export-status-checkbox:checked'))
                .map(cb => cb.value).join(',') : '';

            if (!from) {
                exportFromInput.focus();
                return;
            }
            if (!to) {
                exportToInput.focus();
                return;
            }

            const scope = (scopeToggle && !scopeToggle.checked) ? 'mine' : 'team';

            let url = '/api/applicants/export?format=' + encodeURIComponent(fmt) +
                '&from=' + encodeURIComponent(from) + '&to=' + encodeURIComponent(to) +
                '&scope=' + encodeURIComponent(scope);
            if (status) url += '&status=' + encodeURIComponent(status);

            window.location.href = url;
            exportPanel.classList.add('hidden');
        });
    })();
</script>
