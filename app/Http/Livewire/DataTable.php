<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
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
                if($model->isFK($model->getTable(), $attribute['column'])){
                    continue;
                    // $fkModel = $model->getForeignModel($model->getTable(), $attribute['column']);
                    // $attribute['name'] = $fkModel[0];
                    // $attribute['column'] = strtolower($fkModel[0]).'.name';
                }
                if(in_array($attribute['column'], array_column($this->custom, 'column'))){
                    $customKey = array_search($attribute['column'], array_column($this->custom, 'column'));
                    $attribute = $this->custom[$customKey];
                }

                if(!empty($attribute['type']) && $attribute['type'] === "boolean"){
                    $column[] = $this->addBoolean($attribute);
                }else{
                    $col = Column::make($attribute['label'], $attribute['column'])
                        ->sortable()
                        ->searchable();

                    if(!empty($attribute['format'])){
                        $column[] = $this->formatColumn($attribute, $col);
                    }else{
                        $column[] = $col;
                    }
                }
            }
        }

        if(!empty($this->include)){
            foreach($this->include as $included){
                if(!empty($included['type']) || !empty($included['links'])){
                    if(!empty($included['links'])){
                        $column[] = $this->addLink($included);
                    }elseif($included['type'] === "boolean"){
                        $column[] = $this->addBoolean($included);
                    }
                }else{
                    $col = Column::make($included['label'], $included['column'])
                        ->sortable()
                        ->searchable();

                    if(!empty($included['format'])){
                        $column[] = $this->formatColumn($included, $col);
                    }else{
                        $column[] = $col;
                    }
                }
            }
        }
        return $column;
    }

    function formatColumn($attribute, $custom){
        $formatted = $custom->format(is_string($attribute['format']) ? (fn($value, $row, Column $column) => $attribute['format']) : $attribute['format']);
        if(!empty($attribute['formatType']) && $attribute['formatType'] === 'html'){
            return $formatted->html();
        }else{
            return $formatted;
        }
    }

    function addBoolean($attribute){
        return BooleanColumn::make($attribute['label']);
    }

    function addLink($included){
        $linkColumns = [];
        foreach($included['links'] as $link){
            $class = '';
            if(!empty($link['type'])){
                if($link['type'] === 'link'){
                    $class = 'underline text-blue-500 hover:no-underline';
                }elseif($link['type'] === 'button'){
                    $class = 'bg-gray-200 hover:bg-gray-300 rounded-md px-2 py-1';
                }else{
                    $class = 'cursor-default';
                }
            }
            $linkColumns[] = LinkColumn::make(ucwords($included['label']))
                ->title(is_string($link['title']) ? fn($row) => $link['title'] : $link['title'])
                ->location(empty($link['link']) ? fn($row) => '' : (is_string($link['link']) ? fn($row) => $link['link'] : $link['link']))
                ->attributes(fn($row) => [
                    'class' => !empty($link['class']) ? $link['class'] : $class,
                    'onclick' => 'return false',
                    'target'=> '_blank'
                ]);
        }
        return ButtonGroupColumn::make($included['label'])
            ->attributes(function($row) {
                return [
                    'class' => 'space-x-2',
                ];
            })->buttons($linkColumns);
    }
}
