<?php

namespace App\Orchid\Layouts\Project;

use Orchid\Screen\Layouts\Chart;

class EmployeesRolesByProject extends Chart
{
    /**
     * Add a title to the Chart.
     *
     * @var string
     */
    protected $title = 'Команда проекта';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'pie';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the chart.
     *
     * @var string
     */
    protected $target = 'employeesByProjectChart';

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
