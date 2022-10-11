<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

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
                    $attribute['label'] = $this->custom[$customKey]['label'];
                    $attribute['column'] = $this->custom[$customKey]['column'];
                }
                $column[] = Column::make($attribute['label'], $attribute['column'])
                    ->sortable()
                    ->searchable();
            }
        }

        if(!empty($this->include)){
            foreach($this->include as $included){
                if(!empty($included['links'])){
                    $linkColumns = [];
                    foreach($included['links'] as $link){
                        // dd($link['title']);
                        $linkColumns[] = LinkColumn::make(ucwords($included['label']))
                            ->title(is_string($link['title']) ? fn($row) => $link['title'] : $link['title'])
                            ->location(is_string($link['link']) ? fn($row) => $link['link'] : $link['link'])
                            ->attributes(fn($row) => [
                                'type'  => 'button',
                                'class' => 'underline text-blue-500 hover:no-underline',
                                'target'=> '_blank'
                            ]);
                    }
                    $column[] = ButtonGroupColumn::make($included['label'])
                        ->attributes(function($row) {
                            return [
                                'class' => 'space-x-2',
                            ];
                        })->buttons($linkColumns);
                }else{
                    $column[] = Column::make($included['label'], $included['column'])
                        ->sortable()
                        ->searchable();
                }
            }
        }
        return $column;
    }
}
