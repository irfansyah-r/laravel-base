<x-app-layout>
    <div class="w-full">
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 ">
            <!--- Table --->
            <div class="flex justify-between items-center w-full pb-6">
                <p> Roles Table</p>
            </div>
            <div class="overflow-auto">
                <livewire:data-table :model="$modelClass"
                    :include="['id', 'name', 'created_at', 'updated_at']"
                />
            </div>
        </div>
    </div>
</x-app-layout>
