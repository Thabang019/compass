<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8" x-data="{ activeTab: 'students' }">
        <h1 class="text-2xl font-bold mb-4">Root Dashboard</h1>

        <!-- Pill Tabs -->
        <div class="mb-6">
            <nav class="flex space-x-4">
                <button 
                    @click="activeTab = 'students'"
                    :class="{'bg-blue-500 text-white': activeTab === 'students', 'bg-gray-200 text-gray-700': activeTab !== 'students'}"
                    class="px-4 py-2 rounded-full focus:outline-none">
                    Students
                </button>
                <button 
                    @click="activeTab = 'schedules'"
                    :class="{'bg-blue-500 text-white': activeTab === 'schedules', 'bg-gray-200 text-gray-700': activeTab !== 'schedules'}"
                    class="px-4 py-2 rounded-full focus:outline-none">
                    Schedules
                </button>
                <button 
                    @click="activeTab = 'instructors'"
                    :class="{'bg-blue-500 text-white': activeTab === 'instructors', 'bg-gray-200 text-gray-700': activeTab !== 'instructors'}"
                    class="px-4 py-2 rounded-full focus:outline-none">
                    Instructors
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div>
            <div x-show="activeTab === 'students'" class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">Students</h2>
                <p>Total Students: 50</p>
                <!-- Add more student related details here -->
            </div>
            <div x-show="activeTab === 'schedules'" class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">Schedules</h2>
                <p>Upcoming Classes: 5</p>
                <!-- Add more schedule related details here -->
            </div>
            <div x-show="activeTab === 'instructors'" class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">Instructors</h2>
                <p>Total Instructors: 10</p>
                <!-- Add more instructor related details here -->
            </div>
        </div>
    </div>
</x-app-layout>
