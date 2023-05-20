<?php

namespace HexGad\Articles\Http\DataTables;

use HexGad\Articles\Models\Article;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ArticlesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->rawColumns(['title'])
            ->editColumn('title', function (Article $article){
                $image = $article->getFirstMediaUrl('articles');
                return '
                <span>
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                            <div class="symbol-label">
                                    <img src="'.$image.'" alt="Emma Smith" class="w-100">
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <p class="text-start fw-bolder text-muted fs-7 text-uppercase gs-0 lh-1">'. $article->title.'</p>
                            <p class="text-start fw-bolder text-muted fs-7 gs-0 lh-1">'. strip_tags($article->content) .'</p>
                        </div>
                    </div>
                </span>
                ';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Article $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Article $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('articles-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->className('text-start text-muted fw-bold fs-7 text-uppercase gs-0 fw-bolder'),
            Column::make('title')->className('text-start text-muted fw-bold fs-7 text-uppercase gs-0 fw-bolder'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Articles_' . date('YmdHis');
    }
}
