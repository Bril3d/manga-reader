@section('title', __('Dashboard'))
@extends('dashboard.layout')
@section('content')
<div class="grid grid-cols-1 gap-6 md:grid-cols-4">
    <x-card title="{{ __('Total Mangas') }}" :value="$mangas" />
    <x-card title="{{ __('Total Chapters') }}" :value="$chapters" />
    <x-card title="{{ __('Total Categories') }}" :value="$genres" />
    <x-card title="{{ __('Total Members') }}" :value="$users" />
    <x-card title="{{ __('Total Mangas Views') }}" :value="$mangasViews" />
    <x-card title="{{ __('Total Chapters Views') }}" :value="$chaptersViews" />
    <x-card title="{{ __('Total Views') }}" :value="$mangasViews + $chaptersViews" />
    <x-card title="{{ __('Storage used') }}" :value="$size" />
    
    <div class="md:col-span-2 glass-card rounded-2xl p-6 border border-outline-variant/20 shadow-xl">
        <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/60 font-manrope mb-6">{{ __('User Registrations') }}</h4>
        <div class="relative h-[300px]">
            <canvas id="users-chart"></canvas>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 border border-outline-variant/20 shadow-xl">
        <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/60 font-manrope mb-6">{{ __('Manga Growth') }}</h4>
        <div class="relative h-[300px]">
            <canvas id="manga-chart"></canvas>
        </div>
    </div>
    <div class="glass-card rounded-2xl p-6 border border-outline-variant/20 shadow-xl">
        <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant/60 font-manrope mb-6">{{ __('Chapter Updates') }}</h4>
        <div class="relative h-[300px]">
            <canvas id="chapters-chart"></canvas>
        </div>
    </div>
</div>

<script>
    const usersLabels = @php echo json_encode($users_labels) @endphp;
    const usersData = @php echo json_encode($users_data) @endphp;

    const mangasLabels = @php echo json_encode($mangas_labels) @endphp;
    const mangasData = @php echo json_encode($mangas_data) @endphp;

    const chaptersLabels = @php echo json_encode($chapters_labels) @endphp;
    const chaptersData = @php echo json_encode($chapters_data) @endphp;

</script>
@vite(['resources/js/dashboard/index.js'])

@endsection
