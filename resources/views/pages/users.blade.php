<x-app-layout>
    <div class="w-full">
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 ">
            <!--- Table --->
            <div class="flex justify-between items-center w-full pb-6">
                <p> Users Table</p>
            </div>
            <div class="overflow-auto">
                <livewire:data-table
                    :model="$modelClass"
                    :custom="[
                        [
                            'name'  => 'E-Mail',
                            'column'=> 'email'
                        ]
                    ]"
                    :exclude="['password', 'email_verified_at', 'remember_token']"
                    :include="[
                        [
                            'name' => 'Role',
                            'column' => 'role.name'
                        ]
                    ]"
                />
            </div>
        </div>
    </div>
</x-app-layout>
