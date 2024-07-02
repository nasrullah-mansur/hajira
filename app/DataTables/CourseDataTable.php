<?php

namespace App\DataTables;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CourseDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'course.action')
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
                return $data->created_at->diffForHumans(); // human readable format
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->diffForHumans(); // human readable format
            })
            ->editColumn('action', function ($data) {

                $student_exist = Student::where('course_id', $data->id)->first();

                if($student_exist) {
                    return
                    '<div class="d-flex action-btn">
                        <a class="btn btn-icon btn-success" style="margin-right: 5px;" href="' . route('course.edit', $data->id) . '"><i class="ft-edit"></i></a> 
                    </div>';
                }

                return
                    '<div class="d-flex action-btn">
                        <a class="btn btn-icon btn-success" style="margin-right: 5px;" href="' . route('course.edit', $data->id) . '"><i class="ft-edit"></i></a>
                        <a data-id="' . $data->id . '" class="btn btn-icon btn-danger delete-data" style="margin-right: 5px;" href="#"><i class="ft-trash-2"></i></a> 
                    </div>';
            })
            ->rawColumns(['action', 'status', 'image'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Course $model): QueryBuilder
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
            Column::make('name'),
            Column::make('total_class'),
            Column::make('total_module'),
            Column::make('total_exam'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
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
        return 'Course_' . date('YmdHis');
    }
}
