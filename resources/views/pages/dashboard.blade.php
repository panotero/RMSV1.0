{{-- Dashboard --}}
{{-- Blade SPA Page | Laravel 10 | Tailwind CSS | Chart.js (bundled via resources/js/app.js) --}}

<div id="dashboard-page" class="container mx-auto p-3">

    {{-- PAGE HEADER --}}
    <div class="flex flex-wrap justify-between items-center gap-3 mb-5 p-2">
        <div>
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p class="text-zinc-500 text-sm">Recruitment pipeline overview</p>
        </div>
        @if(auth()->user()->is_team_leader)
            <label class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300 cursor-pointer">
                <input type="checkbox" id="dashScopeAllToggle" checked
                    class="rounded border-zinc-300 text-orange-500 focus:ring-orange-400">
                Show all team members' applicants
            </label>
        @endif
    </div>

    {{-- KPI ROW --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-4">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Total Applicants</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1" id="kpiTotal">—</p>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">New This Week</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1" id="kpiNewThisWeek">—</p>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">In Pipeline</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1" id="kpiInPipeline">—</p>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Hired</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1" id="kpiHired">—</p>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Pending Checklist</p>
            <div class="flex items-center gap-1.5 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-4 h-4 shrink-0 text-[#c98500] dark:text-[#fab219]">
                    <path fill-rule="evenodd"
                        d="M9.401 3.003c1.155-2 4.043-2 5.198 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-2xl font-bold text-zinc-900 dark:text-white" id="kpiPendingChecklist">—</p>
            </div>
            <p class="text-[11px] text-[#c98500] dark:text-[#fab219] mt-0.5">Needs attention</p>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Orientations (7d)</p>
            <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1" id="kpiUpcomingOrientations">—</p>
        </div>
    </div>

    {{-- CHARTS ROW --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Applicants Added — Last 30 Days</p>
            <p class="text-xs text-zinc-400 mb-2">Daily intake trend</p>
            <div class="relative h-64">
                <canvas id="chartTrend"></canvas>
                <p id="chartTrendEmpty"
                    class="hidden absolute inset-0 flex items-center justify-center text-sm text-zinc-400">
                    No applicants added yet.</p>
            </div>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Pipeline by Status</p>
            <p class="text-xs text-zinc-400 mb-2">Where candidates stand today</p>
            <div class="relative h-64">
                <canvas id="chartStatus"></canvas>
                <p id="chartStatusEmpty"
                    class="hidden absolute inset-0 flex items-center justify-center text-sm text-zinc-400">
                    No applicants yet.</p>
            </div>
        </div>
    </div>

    {{-- BREAKDOWN ROW --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

        {{-- Territory chart --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Applicants by Territory</p>
            <p class="text-xs text-zinc-400 mb-2">Top locations</p>
            <div class="relative h-56">
                <canvas id="chartTerritory"></canvas>
                <p id="chartTerritoryEmpty"
                    class="hidden absolute inset-0 flex items-center justify-center text-sm text-zinc-400">
                    No territory data yet.</p>
            </div>
        </div>

        {{-- Upcoming orientations --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Upcoming Orientations</p>
                <button type="button" id="dashViewOrientations"
                    class="text-[11px] font-medium text-orange-500 hover:text-orange-600">View all</button>
            </div>
            <div id="listUpcomingOrientations" class="space-y-1 max-h-56 overflow-y-auto">
                <p class="text-sm text-zinc-400 p-2">Loading…</p>
            </div>
        </div>

        {{-- Recent applicants --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-100">Recent Applicants</p>
                <button type="button" id="dashViewApplicants"
                    class="text-[11px] font-medium text-orange-500 hover:text-orange-600">View all</button>
            </div>
            <div id="listRecentApplicants" class="space-y-1 max-h-56 overflow-y-auto">
                <p class="text-sm text-zinc-400 p-2">Loading…</p>
            </div>
        </div>
    </div>

    {{-- ORGANIZATION STRIP --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Users</p>
            <p class="text-xl font-bold text-zinc-900 dark:text-white mt-1" id="kpiTotalUsers">—</p>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4">
            <p class="text-[11px] font-medium uppercase tracking-widest text-zinc-400">Teams</p>
            <p class="text-xl font-bold text-zinc-900 dark:text-white mt-1" id="kpiTotalTeams">—</p>
        </div>
    </div>
</div>

<script>
    (function () {

        // ── dataviz-derived constants ──────────────────────────────────
        // Sequential blue ramp (steps 100..700), used for ordinal shading
        // (ordered pipeline stages) and as the flat single-series hue.
        const SEQ_STEPS = ['#cde2fb', '#b7d3f6', '#9ec5f4', '#86b6ef', '#6da7ec', '#5598e7', '#3987e5', '#2a78d6', '#256abf', '#1c5cab', '#184f95', '#104281', '#0d366b'];

        const THEME = {
            light: {
                textPrimary: '#0b0b0b',
                textSecondary: '#52514e',
                muted: '#898781',
                grid: '#e1e0d9',
                surface: '#fcfcfb',
                series1: '#2a78d6',
                ordinalLo: 3,  // step 250 — the near-surface floor on a light bg
                ordinalHi: 12, // step 700
            },
            dark: {
                textPrimary: '#ffffff',
                textSecondary: '#c3c2b7',
                muted: '#898781',
                grid: '#2c2c2a',
                surface: '#1a1a19',
                series1: '#3987e5',
                ordinalLo: 0,  // step 100
                ordinalHi: 10, // step 600 — the near-surface floor on a dark bg
            },
        };

        function currentMode() {
            return (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
        }

        function ordinalRamp(n, theme) {
            if (n <= 0) return [];
            if (n === 1) return [SEQ_STEPS[Math.round((theme.ordinalLo + theme.ordinalHi) / 2)]];
            const out = [];
            for (let i = 0; i < n; i++) {
                const idx = theme.ordinalLo + Math.round((i * (theme.ordinalHi - theme.ordinalLo)) / (n - 1));
                out.push(SEQ_STEPS[idx]);
            }
            return out;
        }

        function hexToRgba(hex, alpha) {
            const h = hex.replace('#', '');
            const r = parseInt(h.substring(0, 2), 16);
            const g = parseInt(h.substring(2, 4), 16);
            const b = parseInt(h.substring(4, 6), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        function tooltipBase(theme) {
            return {
                backgroundColor: theme.surface,
                titleColor: theme.textPrimary,
                bodyColor: theme.textSecondary,
                borderColor: theme.grid,
                borderWidth: 1,
                padding: 10,
                displayColors: false,
                titleFont: { weight: '600' },
            };
        }

        function shortDateLabel(isoDate) {
            const parts = isoDate.split('-');
            const d = new Date(Date.UTC(+parts[0], +parts[1] - 1, +parts[2]));
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', timeZone: 'UTC' });
        }

        let charts = { trend: null, status: null, territory: null };

        function destroyCharts() {
            Object.keys(charts).forEach((k) => {
                if (charts[k]) { charts[k].destroy(); charts[k] = null; }
            });
        }

        function renderTrendChart(trend) {
            const theme = THEME[currentMode()];
            const canvas = document.getElementById('chartTrend');
            const empty = document.getElementById('chartTrendEmpty');
            if (!canvas) return;

            const total = trend.reduce((sum, d) => sum + d.count, 0);
            if (total === 0) {
                canvas.classList.add('hidden');
                empty.classList.remove('hidden');
                return;
            }
            canvas.classList.remove('hidden');
            empty.classList.add('hidden');

            charts.trend = new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: trend.map((d) => shortDateLabel(d.date)),
                    datasets: [{
                        label: 'Applicants Added',
                        data: trend.map((d) => d.count),
                        borderColor: theme.series1,
                        backgroundColor: hexToRgba(theme.series1, 0.12),
                        fill: true,
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: theme.series1,
                        pointHoverBorderColor: theme.surface,
                        pointHoverBorderWidth: 2,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: tooltipBase(theme),
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: theme.muted, maxRotation: 0, autoSkip: true, maxTicksLimit: 8 },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: theme.grid },
                            ticks: { color: theme.muted, precision: 0 },
                        },
                    },
                },
            });
        }

        function renderStatusChart(byStatus) {
            const theme = THEME[currentMode()];
            const canvas = document.getElementById('chartStatus');
            const empty = document.getElementById('chartStatusEmpty');
            if (!canvas) return;

            const total = byStatus.reduce((sum, s) => sum + s.count, 0);
            if (total === 0) {
                canvas.classList.add('hidden');
                empty.classList.remove('hidden');
                return;
            }
            canvas.classList.remove('hidden');
            empty.classList.add('hidden');

            charts.status = new Chart(canvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: byStatus.map((s) => s.status),
                    datasets: [{
                        label: 'Applicants',
                        data: byStatus.map((s) => s.count),
                        backgroundColor: ordinalRamp(byStatus.length, theme),
                        borderRadius: 4,
                        borderSkipped: false,
                        maxBarThickness: 22,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: tooltipBase(theme),
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: theme.grid },
                            ticks: { color: theme.muted, precision: 0 },
                        },
                        y: {
                            grid: { display: false },
                            ticks: { color: theme.textSecondary },
                        },
                    },
                },
            });
        }

        function renderTerritoryChart(byTerritory) {
            const theme = THEME[currentMode()];
            const canvas = document.getElementById('chartTerritory');
            const empty = document.getElementById('chartTerritoryEmpty');
            if (!canvas) return;

            if (!byTerritory.length) {
                canvas.classList.add('hidden');
                empty.classList.remove('hidden');
                return;
            }
            canvas.classList.remove('hidden');
            empty.classList.add('hidden');

            charts.territory = new Chart(canvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: byTerritory.map((t) => t.name),
                    datasets: [{
                        label: 'Applicants',
                        data: byTerritory.map((t) => t.count),
                        backgroundColor: theme.series1,
                        borderRadius: 4,
                        borderSkipped: false,
                        maxBarThickness: 36,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: tooltipBase(theme),
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: theme.muted, autoSkip: false, maxRotation: 20, minRotation: 0 },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: theme.grid },
                            ticks: { color: theme.muted, precision: 0 },
                        },
                    },
                },
            });
        }

        function renderList(containerId, items, emptyText, rowBuilder) {
            const container = document.getElementById(containerId);
            if (!container) return;
            container.innerHTML = '';

            if (!items.length) {
                const p = document.createElement('p');
                p.className = 'text-sm text-zinc-400 p-2';
                p.textContent = emptyText;
                container.appendChild(p);
                return;
            }

            items.forEach((item) => container.appendChild(rowBuilder(item)));
        }

        function renderUpcomingOrientations(items) {
            renderList('listUpcomingOrientations', items, 'No upcoming orientations.', (item) => {
                const row = document.createElement('button');
                row.type = 'button';
                row.className = 'w-full flex items-center justify-between gap-2 p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 text-left transition';

                const left = document.createElement('div');
                left.className = 'min-w-0';

                const name = document.createElement('p');
                name.className = 'text-sm font-medium text-zinc-800 dark:text-zinc-100 truncate';
                name.textContent = item.full_name || '—';

                const loc = document.createElement('p');
                loc.className = 'text-[11px] text-zinc-400 truncate';
                loc.textContent = item.location_name || 'Unspecified location';

                left.appendChild(name);
                left.appendChild(loc);

                const right = document.createElement('p');
                right.className = 'text-[11px] font-medium text-zinc-500 dark:text-zinc-400 shrink-0 whitespace-nowrap';
                right.textContent = item.scheduled_date || '—';

                row.appendChild(left);
                row.appendChild(right);

                row.addEventListener('click', () => {
                    if (typeof window.loadPage === 'function') {
                        window.loadPage({ title: 'Orientation Schedule', link: '/page_orientation_schedule' });
                    }
                });

                return row;
            });
        }

        function renderRecentApplicants(items) {
            renderList('listRecentApplicants', items, 'No applicants yet.', (item) => {
                const row = document.createElement('button');
                row.type = 'button';
                row.className = 'w-full flex items-center justify-between gap-2 p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 text-left transition';

                const left = document.createElement('div');
                left.className = 'min-w-0';

                const name = document.createElement('p');
                name.className = 'text-sm font-medium text-zinc-800 dark:text-zinc-100 truncate';
                name.textContent = item.full_name || '—';

                const loc = document.createElement('p');
                loc.className = 'text-[11px] text-zinc-400 truncate';
                loc.textContent = item.location_name || 'Unspecified location';

                left.appendChild(name);
                left.appendChild(loc);

                const badge = document.createElement('span');
                badge.className = 'text-[11px] font-medium px-2 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 shrink-0 whitespace-nowrap';
                badge.textContent = item.status || '—';

                row.appendChild(left);
                row.appendChild(badge);

                row.addEventListener('click', () => {
                    if (typeof window.loadPage === 'function') {
                        window.loadPage({ title: 'Applicants', link: '/page_applicants' });
                    }
                });

                return row;
            });
        }

        function setText(id, value) {
            const el = document.getElementById(id);
            if (el) el.textContent = value;
        }

        async function loadDashboard() {
            const toggle = document.getElementById('dashScopeAllToggle');
            const scope = (toggle && !toggle.checked) ? 'mine' : '';
            const url = '/api/dashboard/summary' + (scope ? `?scope=${scope}` : '');

            const res = await apiCall({ url, mode: 'GET' });

            if (!res || res.success !== true) {
                showMessage({
                    status: 'error',
                    title: 'Error',
                    message: 'Unable to load dashboard data.',
                });
                return;
            }

            const data = res.data;

            setText('kpiTotal', data.counts.total_applicants);
            setText('kpiNewThisWeek', data.counts.new_this_week);
            setText('kpiInPipeline', data.counts.in_pipeline);
            setText('kpiHired', data.counts.hired);
            setText('kpiPendingChecklist', data.counts.pending_checklist);
            setText('kpiUpcomingOrientations', data.counts.upcoming_orientations_7d);
            setText('kpiTotalUsers', data.team.total_users);
            setText('kpiTotalTeams', data.team.total_teams);

            destroyCharts();
            renderTrendChart(data.trend_30d);
            renderStatusChart(data.by_status);
            renderTerritoryChart(data.by_territory);

            renderUpcomingOrientations(data.upcoming_orientations);
            renderRecentApplicants(data.recent_applicants);
        }

        function boot() {
            const scopeToggle = document.getElementById('dashScopeAllToggle');
            if (scopeToggle) {
                scopeToggle.addEventListener('change', loadDashboard);
            }

            const viewOrientationsBtn = document.getElementById('dashViewOrientations');
            if (viewOrientationsBtn) {
                viewOrientationsBtn.addEventListener('click', () => {
                    if (typeof window.loadPage === 'function') {
                        window.loadPage({ title: 'Orientation Schedule', link: '/page_orientation_schedule' });
                    }
                });
            }

            const viewApplicantsBtn = document.getElementById('dashViewApplicants');
            if (viewApplicantsBtn) {
                viewApplicantsBtn.addEventListener('click', () => {
                    if (typeof window.loadPage === 'function') {
                        window.loadPage({ title: 'Applicants', link: '/page_applicants' });
                    }
                });
            }

            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', loadDashboard);
            }

            loadDashboard();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', boot);
        } else {
            boot();
        }

    })();
</script>
