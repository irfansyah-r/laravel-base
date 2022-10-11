<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DataTable extends DataTableComponent
{
    public $model;
    public $custom = [];
    public $include = [];
    public $exclude = [];
    // protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDebugStatus(true);
    }

    public function columns(): array
    {
        $model = app($this->model);
        $column = [];
        $attributes = $model->getAllAttributes()['all'];

        foreach ($attributes as $attribute) {
            if (!in_array($attribute['column'], $this->exclude)) {
                if(!in_array($attribute['column'], array_column($this->custom, 'column')) || str_contains($attribute['column'], '.')){
                    if($model->isFK($model->getTable(), $attribute['column'])){
                        continue;
                        // $fkModel = $model->getForeignModel($model->getTable(), $attribute['column']);
                        // $attribute['name'] = $fkModel[0];
                        // $attribute['column'] = strtolower($fkModel[0]).'.name';
                    }
                }else{
                    $customKey = array_search($attribute['column'], array_column($this->custom, 'column'));
                    $attribute['name'] = $this->custom[$customKey]['name'];
                    $attribute['column'] = $this->custom[$customKey]['column'];
                }
                $column[] = Column::make($attribute['name'], $attribute['column'])
                    ->sortable()
                    ->searchable();
            }
        }

        if(!empty($this->include)){
            foreach($this->include as $included){
                $column[] = Column::make($included['name'], $included['column'])
                    ->sortable()
                    ->searchable();
            }
        }
        return $column;
    }
}
