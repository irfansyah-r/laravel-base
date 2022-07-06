<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DataTable extends DataTableComponent
{
    public $model;
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
        foreach ($attributes['fillable'] as $attribute) {
            if ($attribute !== 'password') {
                $column[] = Column::make($attribute)
                    ->sortable()
                    ->searchable();
            }
        }
        return $column;
    }
}
