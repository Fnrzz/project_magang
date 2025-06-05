<div class="d-flex flex-column gap-2">
    <a href="{{ route('home') }}"
        class="btn {{ Route::is('home') ? 'btn-primary' : 'btn-outline-primary' }}">Dashboard</a>
    <a href="{{ route('assessment.index') }}"
        class="btn {{ Route::is('assessment.index') ? 'btn-primary' : 'btn-outline-primary' }}">Data</a>
</div>
