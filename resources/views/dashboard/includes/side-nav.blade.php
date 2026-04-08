@php
if(__('direction') == 'ltr'){
$classNav = "border-r";
} else {
$classNav = "border-l";
}

function isActiveRoute($routeName)
{
return request()->routeIs($routeName) ? 'bg-neon-purple/20' : '';
}

@endphp

<div id="nav-container" class="animate__animated hidden md:flex w-80 flex-col items-center justify-between gap-3 min-w-fit h-[100vh] overflow-hidden text-on-surface bg-surface-container-low {{ $classNav }} border-outline-variant/30 overflow-y-auto z-20 shadow-2xl transition-all duration-500">
    <div class="w-full px-2">
        <div class="flex justify-start my-8 mx-6">

            @if(settings()->get('logo'))
            <a href="{{ route('dashboard.index') }}">
                <img class="w-36 drop-shadow-[0_0_15px_rgba(216,185,255,0.3)]" src="{{ asset('storage/site/'.basename(settings()->get('logo'))) }}" />
            </a>
            @else
            <a class="text-2xl font-epilogue font-black text-neon-purple tracking-tighter uppercase" href="{{ route('dashboard.index') }}">{{ settings()->get('name') }}</a>
            @endif
        </div>

        <div class="flex flex-col items-center w-full mt-6" id="side-list">
            <x-nav-list title="{{ __('Dashboard') }}" :link="route('dashboard.index')" :active="isActiveRoute('dashboard.index')" icon="fas-house" :has_menu="false"></x-nav-list>

            @php
            $mangasActive =
            isActiveRoute('dashboard.mangas.index')
            || isActiveRoute('dashboard.mangas.create')
            || isActiveRoute('dashboard.mangas.deleted')
            || isActiveRoute('dashboard.mangas_types.index')
            || isActiveRoute('dashboard.mangas_types.create')
            || isActiveRoute('dashboard.mangas_status.index')
            || isActiveRoute('dashboard.mangas_status.create');
            @endphp
            <x-nav-list title="{{ __('Mangas') }}" :active="$mangasActive" icon="fas-list">
                <x-nav-item route="dashboard.mangas.index">{{ __('Mangas List') }}</x-nav-item>
                <x-nav-item route="dashboard.mangas.create">{{ __('Add New Manga') }}</x-nav-item>
                <x-nav-item route="dashboard.mangas.deleted">{{ __('Deleted Mangas') }}</x-nav-item>
                <x-nav-item route="dashboard.mangas_types.index">{{ __('Types List') }}</x-nav-item>
                <x-nav-item route="dashboard.mangas_types.create">{{ __('Add New Type') }}</x-nav-item>
                <x-nav-item route="dashboard.mangas_status.index">{{ __('Status List') }}</x-nav-item>
                <x-nav-item route="dashboard.mangas_status.create">{{ __('Add New Status') }}</x-nav-item>
            </x-nav-list>

            @php
            $chaptersActive =
            isActiveRoute('dashboard.chapters.index')
            || isActiveRoute('dashboard.chapters.create')
            || isActiveRoute('dashboard.chapters.bulk_create')
            @endphp
            <x-nav-list title="{{ __('Chapters') }}" :active="$chaptersActive" icon="fas-book">
                <x-nav-item route="dashboard.chapters.index">{{ __('Chapters List') }}</x-nav-item>
                <x-nav-item route="dashboard.chapters.create">{{ __('Add New Chapter') }}</x-nav-item>
                <x-nav-item route="dashboard.chapters.bulk_create">{{ __('Bulk Add Chapters') }}</x-nav-item>
            </x-nav-list>

            @php
            $genresActive =
            isActiveRoute('dashboard.genres.index')
            || isActiveRoute('dashboard.genres.create')
            @endphp
            <x-nav-list title="{{ __('Genres') }}" :active="$genresActive" icon="fas-list">
                <x-nav-item route="dashboard.genres.index">{{ __('Genres List') }}</x-nav-item>
                <x-nav-item route="dashboard.genres.create">{{ __('Add New Genre') }}</x-nav-item>
            </x-nav-list>

            <x-nav-list title="{{ __('Comments List') }}" :link="route('dashboard.comments.index')" :active="isActiveRoute('dashboard.comments.index')" icon="fas-comments" :has_menu="false"></x-nav-list>

            @php
            $pagesActive =
            isActiveRoute('dashboard.pages.index')
            || isActiveRoute('dashboard.pages.create')
            || isActiveRoute('dashboard.pages.deleted')
            @endphp
            <x-nav-list title="{{ __('Pages') }}" :active="$pagesActive" icon="fas-paste">
                <x-nav-item route="dashboard.pages.index">{{ __('Pages List') }}</x-nav-item>
                <x-nav-item route="dashboard.pages.create">{{ __('Add New Page') }}</x-nav-item>
                <x-nav-item route="dashboard.pages.deleted">{{ __('Deleted Pages') }}</x-nav-item>
            </x-nav-list>


            @php
            $usersActive =
            isActiveRoute('dashboard.users.index')
            || isActiveRoute('dashboard.users.create')
            || isActiveRoute('dashboard.users.deleted')
            @endphp
            <x-nav-list title="{{ __('Users') }}" :active="$usersActive" icon="fas-users">
                <x-nav-item route="dashboard.users.index">{{ __('Users List') }}</x-nav-item>
                <x-nav-item route="dashboard.users.create">{{ __('Add New User') }}</x-nav-item>
                <x-nav-item route="dashboard.users.deleted">{{ __('Deleted Users') }}</x-nav-item>
            </x-nav-list>

            @php
            $rolesActive =
            isActiveRoute('dashboard.roles.index')
            || isActiveRoute('dashboard.roles.create')
            @endphp
            <x-nav-list title="{{ __('Roles') }}" :active="$rolesActive" icon="fas-user-tag">
                <x-nav-item route="dashboard.roles.index">{{ __('Roles List') }}</x-nav-item>
                <x-nav-item route="dashboard.roles.create">{{ __('Add New Role') }}</x-nav-item>
            </x-nav-list>


            @php
            $adsActive =
            isActiveRoute('dashboard.ads.index')
            || isActiveRoute('dashboard.ads.create')
            @endphp
            <x-nav-list title="{{ __('Ads Settings') }}" :active="$adsActive" icon="fas-ad">
                <x-nav-item route="dashboard.ads.index">{{ __('Ads List') }}</x-nav-item>
                <x-nav-item route="dashboard.ads.create">{{ __('Add New Ad') }}</x-nav-item>
            </x-nav-list>

            @php
            $themesActive =
            isActiveRoute('dashboard.settings.index_theme')
            || isActiveRoute('dashboard.menus.index')
            || isActiveRoute('dashboard.menus.create')
            @endphp
            <x-nav-list title="{{ __('Theme Settings') }}" :active="$themesActive" icon="fas-font">
                <x-nav-item route="dashboard.settings.index_theme">{{ __('Theme Settings') }}</x-nav-item>
                {{-- <x-nav-item route="dashboard.menus.index">{{ __('Menus Settings') }}</x-nav-item>
                <x-nav-item route="dashboard.menus.create">{{ __('Add New Menu') }}</x-nav-item> --}}
            </x-nav-list>

            @php
            $settingsActive =
            isActiveRoute('dashboard.settings.index_site')
            || isActiveRoute('dashboard.settings.index_mail')
            || isActiveRoute('dashboard.settings.index_seo')
            || isActiveRoute('dashboard.settings.index_upload')
            || isActiveRoute('dashboard.settings.clear_cache')
            @endphp
            <x-nav-list title="{{ __('Settings') }}" :active="$settingsActive" icon="fas-cog">
                <x-nav-item route="dashboard.settings.index_site">{{ __('Site Settings') }}</x-nav-item>
                <x-nav-item route="dashboard.settings.index_mail">{{ __('Mail Settings') }}</x-nav-item>
                <x-nav-item route="dashboard.settings.index_seo">{{ __('Seo Settings') }}</x-nav-item>
                <x-nav-item route="dashboard.settings.index_upload">{{ __('Upload Settings') }}</x-nav-item>
                <x-nav-item route="dashboard.settings.clear_cache">{{ __('Clear Cache') }}</x-nav-item>
            </x-nav-list>
        </div>

    </div>
    <div class="flex flex-col w-full pb-6 border-t border-outline-variant/30">
        <x-nav-list title="{{ __('Back to website') }}" :link="route('home')" icon="fas-arrow-left" active="false" :has_menu="false"></x-nav-list>
        <x-nav-list title="{{ __('Logout') }}" :link="route('logout')" icon="fas-sign-out-alt" active="false" :has_menu="false"></x-nav-list>
    </div>
</div>
