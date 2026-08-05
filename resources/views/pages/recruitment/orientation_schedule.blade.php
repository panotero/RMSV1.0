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

    @if(auth()->user()->is_team_leader)
        <div class="mt-3 p-2">
            <label class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300 cursor-pointer">
                <input type="checkbox" id="scopeAllToggle" checked
                    class="rounded border-zinc-300 text-orange-500 focus:ring-orange-400">
                Show all team members' scheduled orientations
            </label>
        </div>
    @endif

</div>

{{-- JS --}}
<script>
    (function() {
        function formatDate(value) {
            if (!value) return '—';
            const date = new Date(value);
            return isNaN(date.getTime()) ? value : date.toLocaleString();
        }

        // ===================== LIST / TABLE =====================

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
                title: 'Scheduled By',
                render: (row) => row.scheduled_by_name ?? '—',
            },
        ];

        const table = renderRemoteTable({
            url: '/api/applicantOrientations',
            tableId: 'orientationTable',
            thead: thead,
        });

        table.load(1);

        const scopeToggle = document.getElementById('scopeAllToggle');
        if (scopeToggle) {
            scopeToggle.addEventListener('change', function() {
                table.setFilter('scope', scopeToggle.checked ? 'team' : 'mine');
            });
        }
    })();
</script>
