<?php

namespace App\DataTables;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StudentDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'student.action')
            ->addIndexColumn()
            ->editColumn('course_id', function ($data) {
                $course_name = Course::where('id', $data->course_id)->first();
                return $course_name->name;
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans(); // human readable format
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->diffForHumans(); // human readable format
            })
            ->editColumn('action', function ($data) {
                return
                    '<div class="d-flex action-btn">
                        <a class="btn btn-icon btn-success" style="margin-right: 5px;" href="' . route('student.edit', $data->id) . '"><i class="ft-edit"></i></a> 
                    </div>';
            })
            ->rawColumns(['action', 'status', 'image'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Student $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->addIndex()
                    ->setTableId('data-table')->addTableClass('table table-striped table-bordered zero-configuration dataTable')->autoWidth()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->serverSide(true)
                    ->dom('lBfrtip')
                    ->orderBy(0)
                    ->buttons(
                        Button::make('copy')->addClass('btn-secondary'),
                        Button::make('print')->addClass('btn-secondary'),
                        Button::make('pdf')->addClass('btn-secondary'),
                        Button::make('excel')->addClass('btn-secondary'),
                        Button::make('colvis')->text('Show')->addClass('btn-secondary'),
                    );
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('SL')->orderable(false)->searchable(false),
            // Column::make('image'),
            // Column::make('image')->searchable(false),
            Column::make('name')->searchable(false),
            Column::make('email'),
            Column::make('phone'),
            Column::make('course_id'),
            Column::make('status')->searchable(false),
            Column::make('created_at')->searchable(false),
            Column::make('updated_at')->searchable(false),
            Column::computed('action')->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('table-actions'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Student_' . date('YmdHis');
    }
}
