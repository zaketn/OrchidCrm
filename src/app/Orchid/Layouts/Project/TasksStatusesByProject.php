<?php

namespace App\Orchid\Layouts\Project;

use Orchid\Screen\Layouts\Chart;

class TasksStatusesByProject extends Chart
{
    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'Выполнение задач';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'percentage';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the chart.
     *
     * @var string
     */
    protected $target = 'charts.tasksStatusesByProjectChart';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = false;

    /**
     * Colors used.
     *
     * @var array
     */
    protected $colors = [
        '#f9be14',
        '#eab094',
        '#18324f',
        '#5889a8',
        '#9babc4',
        '#304363',
    ];
}
