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
                            'label' => 'E-Mail',
                            'column'=> 'email'
                        ],
                    ]"
                    :exclude="['password', 'email_verified_at', 'remember_token', 'updated_at']"
                    :include="[
                        [
                            'label' => 'Role',
                            'column'=> 'role.name',
                            'format'=> fn($value, $row) => '<strong>'.ucwords($value).'</strong>',
                            'formatType' => 'html'
                        ],
                        [
                            'label' => 'Search Engine',
                            'links' => [
                                [
                                    'title' => fn($row) => $row->name.' Google',
                                    'link'  => fn($row) => 'https://google.com/search?q='.$row->name,
                                    'type'  => 'button',
                                ]
                            ],
                        ],
                        [
                            'label' => 'Social Media',
                            'links' => [
                                [
                                    'title' => 'Facebook',
                                    'link'  => 'https://facebook.com',
                                    'type'  => 'link'
                                ],
                                [
                                    'title' => 'Instagram',
                                    'link'  => 'https://instagram.com',
                                    'type'  => 'link'
                                ]
                            ]
                        ],
                        [
                            'label' => 'Email Provider',
                            'links' => [
                                [
                                    'title' => function($row){
                                        if(str_contains($row->email, 'gmail')){
                                            return 'Google';
                                        }elseif(str_contains($row->email, 'yahoo')){
                                            return 'Yahoo';
                                        }else{
                                            return 'Unidentified';
                                        }
                                    },
                                    'class' => 'cursor-pointer',
                                    'onclick'  => 'return false',
                                ]
                            ]
                        ]
                    ]"
                />
            </div>
        </div>
    </div>
</x-app-layout>
