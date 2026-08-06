<div class="container mx-auto p-3">

    {{-- PAGE HEADER --}}
    <div class="flex justify-between items-center mb-5 p-2">
        <div>
            <h1 class="text-2xl font-bold">Orientation Schedule</h1>
            <p class="text-zinc-500">Scheduled orientations across the recruitment pipeline</p>
        </div>
    </div>

    {{-- TABLE --}}
    <x-table id="orientationTable" />

    <div class="mt-3 p-2 flex items-center justify-between">
        <div>
            @if (auth()->user()->is_team_leader)
                <label class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300 cursor-pointer">
                    <input type="checkbox" id="scopeAllToggle" checked
                        class="rounded border-zinc-300 text-orange-500 focus:ring-orange-400">
                    Show all team members' scheduled orientations
                </label>
            @endif
        </div>

        {{-- EXPORT --}}
        <div class="relative">
            <button type="button" id="btnOrientationExport"
                class="px-4 py-2 rounded-lg text-sm font-medium border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                Export
            </button>

            <div id="orientExportPanel"
                class="hidden absolute z-20 bottom-full right-0 mb-2 w-[90vw] lg:w-[40vw] max-w-[95vw] bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-lg p-4">

                <div class="flex flex-col-reverse lg:flex-row gap-4">

                    {{-- LEFT: inputs + actions --}}
                    <div class="flex-1 flex flex-col gap-3">
                        <div class="flex flex-wrap gap-2">
                            <button type="button" id="orientExportPresetToday"
                                class="px-3 py-1.5 text-xs font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                                Today
                            </button>
                            <button type="button" id="orientExportPresetThisWeek"
                                class="px-3 py-1.5 text-xs font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                                This Week
                            </button>
                            <button type="button" id="orientExportPresetLastWeek"
                                class="px-3 py-1.5 text-xs font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                                Last Week
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">From</label>
                                <input type="date" id="orientExportFrom"
                                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-2 py-1.5 text-xs text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label
                                    class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">To</label>
                                <input type="date" id="orientExportTo"
                                    class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-2 py-1.5 text-xs text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">File
                                Type</label>
                            <select id="orientExportFormat"
                                class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                                <option value="csv" selected>CSV</option>
                                <option value="xlsx">Excel</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>

                        <div class="flex gap-2 mt-auto">
                            <button type="button" id="orientExportCancelBtn"
                                class="flex-1 px-4 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 rounded-lg transition">
                                Cancel
                            </button>
                            <button type="button" id="orientExportRunBtn"
                                class="flex-1 px-4 py-1.5 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                                Export
                            </button>
                        </div>
                    </div>

                    {{-- RIGHT: calendar --}}
                    <div class="flex-1">
                        <div id="orientExportCalendar" class="p-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CALENDAR --}}
    <div class="mt-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-3">
                <button type="button" id="calPrevBtn"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                    ‹
                </button>
                <h2 id="calMonthLabel"
                    class="text-base font-semibold text-zinc-800 dark:text-zinc-100 w-40 text-center">
                </h2>
                <button type="button" id="calNextBtn"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                    ›
                </button>
            </div>
            <button type="button" id="calTodayBtn"
                class="text-xs font-medium px-3 py-1.5 rounded-lg border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                Today
            </button>
        </div>

        <div
            class="grid grid-cols-7 gap-px bg-zinc-200 dark:bg-zinc-800 rounded-t-lg overflow-hidden text-[11px] font-medium uppercase tracking-widest text-zinc-400">
            <div class="bg-zinc-50 dark:bg-zinc-900 py-2 text-center">Sun</div>
            <div class="bg-zinc-50 dark:bg-zinc-900 py-2 text-center">Mon</div>
            <div class="bg-zinc-50 dark:bg-zinc-900 py-2 text-center">Tue</div>
            <div class="bg-zinc-50 dark:bg-zinc-900 py-2 text-center">Wed</div>
            <div class="bg-zinc-50 dark:bg-zinc-900 py-2 text-center">Thu</div>
            <div class="bg-zinc-50 dark:bg-zinc-900 py-2 text-center">Fri</div>
            <div class="bg-zinc-50 dark:bg-zinc-900 py-2 text-center">Sat</div>
        </div>
        <div id="calGrid" class="grid grid-cols-7 gap-px bg-zinc-200 dark:bg-zinc-800 rounded-b-lg overflow-hidden">
        </div>

        <div class="flex items-center gap-4 mt-3 text-xs text-zinc-500 dark:text-zinc-400">
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                Scheduled</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                Rescheduled</span>
        </div>
    </div>

</div>

{{-- DAY ORIENTATIONS MODAL --}}
<x-modal id="dayOrientationsModal">
    <div class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
        <p class="text-lg font-semibold dark:text-white" id="dayOrientationsTitle">—</p>
        <button class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200">✕</button>
    </div>
    <div class="p-5 max-h-[60vh] overflow-y-auto">
        <div id="dayOrientationsList" class="space-y-2"></div>
    </div>
</x-modal>

{{-- ORIENTATION DETAIL SIDE MODAL --}}
<x-side-modal id="orientationDetailModal">

    {{-- Header --}}
    <div
        class="p-5 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900 z-10">
        <div>
            <p class="text-[11px] font-medium text-zinc-400 uppercase tracking-widest">Orientation</p>
            <p class="text-lg font-semibold dark:text-white mt-0.5" id="orientationApplicantName">—</p>
        </div>
        <button
            class="modal-close text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 w-8 h-8 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
            ✕
        </button>
    </div>

    {{-- Body --}}
    <div class="p-5">

        <div id="orientationLoading"
            class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-8 text-center text-sm text-zinc-400">
            Loading orientation...
        </div>

        <div id="orientationContent" class="hidden space-y-5">

            {{-- Applicant info --}}
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400 mb-3">Applicant</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Name</p>
                        <p id="orientationApplicantNameField" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5">
                        </p>
                    </div>
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Role</p>
                        <p id="orientationRole" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5"></p>
                    </div>
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Location</p>
                        <p id="orientationLocation" class="text-sm text-zinc-800 dark:text-zinc-100 mt-0.5"></p>
                    </div>
                    <div>
                        <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Status</p>
                        <span id="orientationStatusBadge" class="inline-block mt-0.5"></span>
                    </div>
                </div>
            </div>

            {{-- Schedule / reschedule --}}
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400 mb-2">Schedule</p>
                <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-3">
                    Currently scheduled for <strong id="orientationCurrentDate"
                        class="text-zinc-900 dark:text-zinc-100"></strong>
                    <span class="text-zinc-400">· scheduled by <span id="orientationScheduledBy"></span></span>
                </p>
                <div class="flex items-end gap-2">
                    <div class="flex-1 flex flex-col gap-1">
                        <label class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">New
                            date</label>
                        <input type="date" id="orientationRescheduleDate"
                            class="w-full bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                    </div>
                    <button type="button" id="orientationRescheduleBtn"
                        class="px-4 py-2 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 rounded-lg transition">
                        Reschedule
                    </button>
                </div>
            </div>

            {{-- History --}}
            <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-4">
                <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400 mb-2">History</p>
                <div id="orientationHistoryList" class="divide-y divide-zinc-100 dark:divide-zinc-800"></div>
            </div>

        </div>
    </div>

</x-side-modal>

{{-- JS --}}
<script>
    (function() {
        // The API already sends dates pre-formatted ("January 1, 2001" or
        // "January 1, 2001, 1:00 AM" - see App\Support\FriendlyDate) - this
        // just supplies the "—" fallback, no re-parsing.
        function formatDate(value) {
            return value || '—';
        }

        function statusBadge(status) {
            const cls = status === 'Rescheduled' ?
                'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' :
                'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300';
            return `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${cls}">${status ?? '—'}</span>`;
        }

        // ===================== LIST / TABLE =====================

        function handleRowClick(row) {
            row.addEventListener('click', function() {
                const data = JSON.parse(row.dataset.row);
                openOrientationModal(data.id);
            });
        }

        const thead = [{
                title: 'Date',
                render: (row) => formatDate(row.scheduled_date),
            },
            {
                title: 'Applicant',
                render: (row) => row.applicant_name ?? '—',
            },
            {
                title: 'Territory / Location',
                render: (row) => row.location_name ?? '—',
            },
            {
                title: 'Status',
                render: (row) => statusBadge(row.status),
            },
            {
                title: 'Scheduled By',
                render: (row) => row.scheduled_by_name ?? '—',
            },
        ];

        const table = renderRemoteTable({
            url: '/api/applicantOrientations',
            tableId: 'orientationTable',
            afterRenderFunction: handleRowClick,
            thead: thead,
        });

        table.load(1);

        const scopeToggle = document.getElementById('scopeAllToggle');
        if (scopeToggle) {
            scopeToggle.addEventListener('change', function() {
                table.setFilter('scope', scopeToggle.checked ? 'team' : 'mine');
                loadCalendar();
            });
        }

        // ===================== CALENDAR =====================

        const calMonthLabelEl = document.getElementById('calMonthLabel');
        const calGridEl = document.getElementById('calGrid');
        const today = new Date();
        let calYear = today.getFullYear();
        let calMonth = today.getMonth(); // 0-indexed

        function toISODate(d) {
            return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d
                .getDate()).padStart(2, '0');
        }

        function getMonthGridRange(year, month) {
            const firstOfMonth = new Date(year, month, 1);
            const lastOfMonth = new Date(year, month + 1, 0);
            const gridStart = new Date(firstOfMonth);
            gridStart.setDate(gridStart.getDate() - gridStart.getDay());
            const gridEnd = new Date(lastOfMonth);
            gridEnd.setDate(gridEnd.getDate() + (6 - gridEnd.getDay()));
            return {
                firstOfMonth,
                lastOfMonth,
                gridStart,
                gridEnd
            };
        }

        let calEventsByDate = {};

        function renderCalendarGrid(range, events) {
            calEventsByDate = {};
            events.forEach(ev => {
                const key = ev.scheduled_date_raw;
                if (!calEventsByDate[key]) calEventsByDate[key] = [];
                calEventsByDate[key].push(ev);
            });

            const todayKey = toISODate(new Date());
            const cells = [];
            const cursor = new Date(range.gridStart);

            while (cursor <= range.gridEnd) {
                const key = toISODate(cursor);
                const dayEvents = calEventsByDate[key] || [];
                const isOtherMonth = cursor.getMonth() !== range.firstOfMonth.getMonth();
                const isToday = key === todayKey;

                cells.push(`
                    <div class="bg-white dark:bg-zinc-900 min-h-[104px] flex flex-col ${isOtherMonth ? 'opacity-40' : ''}">
                        <button type="button" class="cal-day-header text-left px-1.5 pt-1.5 pb-1 shrink-0 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition"
                            data-date="${key}" ${dayEvents.length ? '' : 'disabled'}>
                            <span class="text-xs font-medium ${isToday ? 'inline-flex items-center justify-center w-5 h-5 rounded-full bg-orange-500 text-white' : 'text-zinc-500 dark:text-zinc-400'}">${cursor.getDate()}</span>
                        </button>
                        <div class="flex-1 flex flex-col gap-0.5 px-1.5 pb-1.5 overflow-y-auto max-h-[88px]">
                            ${dayEvents.map(ev => `
                                <button type="button" class="cal-event-chip text-left text-[11px] leading-tight px-1.5 py-0.5 rounded truncate shrink-0 ${ev.status === 'Rescheduled' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300' : 'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300'}" data-orientation-id="${ev.id}" title="${ev.applicant_name ?? ''}">
                                    ${ev.applicant_name ?? '—'}
                                </button>
                            `).join('')}
                        </div>
                    </div>
                `);

                cursor.setDate(cursor.getDate() + 1);
            }

            calGridEl.innerHTML = cells.join('');
        }

        async function loadCalendar() {
            const range = getMonthGridRange(calYear, calMonth);
            calMonthLabelEl.textContent = range.firstOfMonth.toLocaleDateString('en-US', {
                month: 'long',
                year: 'numeric'
            });

            const params = new URLSearchParams({
                from: toISODate(range.gridStart),
                to: toISODate(range.gridEnd),
            });
            if (scopeToggle && !scopeToggle.checked) params.set('scope', 'mine');

            const res = await apiCall({
                mode: 'GET',
                url: `/api/applicantOrientations?${params.toString()}`
            });

            const events = (res && res.success && Array.isArray(res.data)) ? res.data : [];
            renderCalendarGrid(range, events);
        }

        calGridEl.addEventListener('click', (e) => {
            const chip = e.target.closest('.cal-event-chip');
            if (chip) {
                openOrientationModal(chip.dataset.orientationId);
                return;
            }

            const header = e.target.closest('.cal-day-header');
            if (header && !header.disabled) {
                openDayOrientationsModal(header.dataset.date);
            }
        });

        document.getElementById('calPrevBtn').addEventListener('click', () => {
            calMonth--;
            if (calMonth < 0) {
                calMonth = 11;
                calYear--;
            }
            loadCalendar();
        });

        document.getElementById('calNextBtn').addEventListener('click', () => {
            calMonth++;
            if (calMonth > 11) {
                calMonth = 0;
                calYear++;
            }
            loadCalendar();
        });

        document.getElementById('calTodayBtn').addEventListener('click', () => {
            calYear = today.getFullYear();
            calMonth = today.getMonth();
            loadCalendar();
        });

        loadCalendar();

        // ===================== DAY SUMMARY MODAL =====================

        function openDayOrientationsModal(dateKey) {
            const dayEvents = calEventsByDate[dateKey] || [];

            const labelDate = new Date(dateKey + 'T00:00:00');
            document.getElementById('dayOrientationsTitle').textContent = labelDate.toLocaleDateString('en-US', {
                weekday: 'long',
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });

            const listEl = document.getElementById('dayOrientationsList');
            listEl.innerHTML = dayEvents.length ? dayEvents.map(ev => `
                <button type="button" class="day-orientation-item w-full flex items-center justify-between gap-3 text-left px-3 py-2.5 rounded-lg border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition"
                    data-orientation-id="${ev.id}">
                    <span class="text-sm text-zinc-800 dark:text-zinc-100 truncate">${ev.applicant_name ?? '—'}</span>
                    ${statusBadge(ev.status)}
                </button>
            `).join('') : '<p class="text-sm text-zinc-400 py-4 text-center">No orientations this day.</p>';

            initModal({
                modalId: 'dayOrientationsModal'
            });
        }

        document.getElementById('dayOrientationsList').addEventListener('click', (e) => {
            const item = e.target.closest('.day-orientation-item');
            if (!item) return;

            document.getElementById('dayOrientationsModal').classList.add('hidden');
            openOrientationModal(item.dataset.orientationId);
        });

        // ===================== DETAIL / RESCHEDULE MODAL =====================

        const orientationLoadingEl = document.getElementById('orientationLoading');
        const orientationContentEl = document.getElementById('orientationContent');
        let currentOrientationId = null;
        let currentOrientationApplicantId = null;

        function renderOrientationDetail(data) {
            currentOrientationApplicantId = data.applicant_id;

            document.getElementById('orientationApplicantName').textContent = data.applicant_name ?? '—';
            document.getElementById('orientationApplicantNameField').textContent = data.applicant_name ?? '—';
            document.getElementById('orientationRole').textContent = data.role_name ?? '—';
            document.getElementById('orientationLocation').textContent = data.location_name ?? '—';
            document.getElementById('orientationStatusBadge').innerHTML = statusBadge(data.status);
            document.getElementById('orientationCurrentDate').textContent = data.scheduled_date ?? '—';
            document.getElementById('orientationScheduledBy').textContent = data.scheduled_by_name ?? '—';
            document.getElementById('orientationRescheduleDate').value = data.scheduled_date_raw ?? '';

            const historyEl = document.getElementById('orientationHistoryList');
            if (!data.history || !data.history.length) {
                historyEl.innerHTML = '<p class="text-sm text-zinc-400 py-2">No history yet.</p>';
            } else {
                historyEl.innerHTML = data.history.map(h => `
                    <div class="py-2 first:pt-0 last:pb-0">
                        <p class="text-sm text-zinc-800 dark:text-zinc-100">${h.event_type === 'rescheduled' ? 'Rescheduled to' : 'Scheduled for'} ${h.scheduled_date}</p>
                        <p class="text-xs text-zinc-400 mt-0.5">${h.changed_by_name ?? '—'} · ${h.created_at}</p>
                    </div>
                `).join('');
            }
        }

        async function openOrientationModal(orientationId) {
            currentOrientationId = orientationId;

            orientationLoadingEl.classList.remove('hidden');
            orientationContentEl.classList.add('hidden');

            initSideModal({
                modalId: 'orientationDetailModal',
                confirmClose: false
            });

            const res = await apiCall({
                mode: 'GET',
                url: `/api/applicantOrientations/${orientationId}`
            });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: 'Failed to load this orientation.'
                });
                closeSideModal('orientationDetailModal');
                return;
            }

            renderOrientationDetail(res.data);

            orientationLoadingEl.classList.add('hidden');
            orientationContentEl.classList.remove('hidden');
        }

        document.getElementById('orientationRescheduleBtn').addEventListener('click', async function() {
            const dateInput = document.getElementById('orientationRescheduleDate');
            const newDate = dateInput.value;

            if (!newDate) {
                dateInput.focus();
                return;
            }

            const res = await apiCall({
                mode: 'PUT',
                isJson: true,
                payload: {
                    scheduled_date: newDate
                },
                url: `/api/applicants/${currentOrientationApplicantId}/orientation`,
                button: this,
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
                title: 'Orientation updated!'
            });

            await openOrientationModal(currentOrientationId);
            table.reload();
            loadCalendar();
        });

        function apiErrorMessage(res) {
            const err = (res && res.response) ? res.response : (res || {});
            return err.invalid_fields ?
                Object.values(err.invalid_fields).flat().join(' ') : (err.message || 'Request failed.');
        }

        // ===================== EXPORT =====================

        const orientExportBtn = document.getElementById('btnOrientationExport');
        const orientExportPanel = document.getElementById('orientExportPanel');
        const orientExportFromInput = document.getElementById('orientExportFrom');
        const orientExportToInput = document.getElementById('orientExportTo');

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

        let orientExportCalendar = null;
        if (typeof flatpickr === 'function') {
            orientExportCalendar = flatpickr('#orientExportCalendar', {
                mode: 'range',
                inline: true,
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates) {
                    if (selectedDates.length >= 1) orientExportFromInput.value = toISODate(
                        selectedDates[0]);
                    if (selectedDates.length === 2) orientExportToInput.value = toISODate(selectedDates[
                        1]);
                }
            });
        }

        function setOrientExportRange(from, to) {
            orientExportFromInput.value = toISODate(from);
            orientExportToInput.value = toISODate(to);
            if (orientExportCalendar) orientExportCalendar.setDate([from, to], false);
        }

        [orientExportFromInput, orientExportToInput].forEach(input => {
            input.addEventListener('change', function() {
                const from = parseISODateLocal(orientExportFromInput.value);
                const to = parseISODateLocal(orientExportToInput.value);
                if (orientExportCalendar && from && to) orientExportCalendar.setDate([from, to],
                    false);
            });
        });

        orientExportBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (orientExportPanel.classList.contains('hidden')) {
                showFlyout(orientExportPanel, orientExportBtn, {
                    hAlign: 'left'
                });
            } else {
                hideFlyout(orientExportPanel);
            }
        });

        document.getElementById('orientExportCancelBtn').addEventListener('click', function() {
            hideFlyout(orientExportPanel);
        });

        document.addEventListener('click', function(e) {
            if (!orientExportPanel.classList.contains('hidden') && !orientExportPanel.contains(e.target) &&
                e
                .target !== orientExportBtn) {
                hideFlyout(orientExportPanel);
            }
        });

        document.getElementById('orientExportPresetToday').addEventListener('click', function() {
            const t = new Date();
            setOrientExportRange(t, t);
        });

        document.getElementById('orientExportPresetThisWeek').addEventListener('click', function() {
            const monday = getMondayOfWeek(new Date());
            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6);
            setOrientExportRange(monday, sunday);
        });

        document.getElementById('orientExportPresetLastWeek').addEventListener('click', function() {
            const monday = getMondayOfWeek(new Date());
            monday.setDate(monday.getDate() - 7);
            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6);
            setOrientExportRange(monday, sunday);
        });

        document.getElementById('orientExportRunBtn').addEventListener('click', function() {
            const fmt = document.getElementById('orientExportFormat').value;
            const from = orientExportFromInput.value;
            const to = orientExportToInput.value;

            if (!from) {
                orientExportFromInput.focus();
                return;
            }
            if (!to) {
                orientExportToInput.focus();
                return;
            }

            const scope = (scopeToggle && !scopeToggle.checked) ? 'mine' : 'team';

            window.location.href = '/api/applicantOrientations/export?format=' + encodeURIComponent(fmt) +
                '&from=' + encodeURIComponent(from) + '&to=' + encodeURIComponent(to) +
                '&scope=' + encodeURIComponent(scope);

            hideFlyout(orientExportPanel);
        });
    })();
</script>
