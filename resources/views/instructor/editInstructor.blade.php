<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!--Tabs navigation-->
                <ul
                class="mb-5 flex list-none flex-row flex-wrap border-b-0 ps-0"
                role="tablist"
                data-twe-nav-ref>
                
                </ul>

                <!--Tabs content-->
                <div class="mb-6">
                <div
                    class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-home01"
                    role="tabpanel"
                    aria-labelledby="tabs-home-tab01"
                    data-twe-tab-active>
                    Tab 1 content
                </div>
                <div
                    class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-profile01"
                    role="tabpanel"
                    aria-labelledby="tabs-profile-tab01">
                    Tab 2 content
                </div>
                <div
                    class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-messages01"
                    role="tabpanel"
                    aria-labelledby="tabs-profile-tab01">
                    Tab 3 content
                </div>
                <div
                    class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[twe-tab-active]:block"
                    id="tabs-contact01"
                    role="tabpanel"
                    aria-labelledby="tabs-contact-tab01">
                    Tab 4 content
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
