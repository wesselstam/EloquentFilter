<?php
namespace WStam\EloquentFilter;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class FilterCollection extends Collection
{
    /**
     * The collection of all the filters.
     *
     * @var Collection
     */
    protected $filters;

    /**
     * The default pagination view.
     *
     * @var string
     */
    public static $defaultView = 'eloquentfilter::container';

    public function __construct($items = [], Collection $filters)
    {
        parent::__construct($items);

        $this->filters = $filters;
    }

    /**
     * Render the filters using the given view.
     *
     * @param  string  $view
     * @param  array  $data
     * @return string
     */
    public function renderFilters($view = null, $data = [])
    {
        return new HtmlString(view($view ?: static::$defaultView, array_merge($data, [
            'FilterCollection' => $this,
            'filters' => $this->filters,
        ]))->render());
    }
}