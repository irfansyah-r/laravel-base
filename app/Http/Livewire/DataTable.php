<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DataTable extends DataTableComponent
{
    public $model;
    public $include = [];
    public $exclude = [];
    // protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        $model = new $this->model;
        $attributes = $model->getAllAttributes();
        $column = [];
        if(empty($this->include)){
            foreach (array_keys($attributes['all']) as $attribute) {
                if (!in_array($attribute, $this->exclude)) {
                    $column[] = Column::make($attribute)
                        ->sortable()
                        ->searchable();
                }
            }
        }else{
            foreach($this->include as $attribute){
                if(in_array($attribute, array_keys($attributes['all']))){
                    $column[] = Column::make($attribute)
                        ->sortable()
                        ->searchable();
                }
            }
        }
        // dd($model->isFK($model->getTable(), "role_id"));
        // if($class->isFK($class->getTable(), $col)){
        //     dd(explode('.', $col));
        //     // $relationClass = ucwords(explode('.', $col))
        //     // dd($class->getRelations());
        //     // dd($class->{'role'}());
        // }else{
        //     $column[] = Column::make(ucwords($col))
        //         ->sortable()
        //         ->searchable();
        // }
        return $column;
    }
}
