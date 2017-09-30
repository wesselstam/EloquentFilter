<?php
namespace WStam\EloquentFilter;

use Illuminate\Support\Collection;
use Request;
use Illuminate\Database\Eloquent\Builder;
use WStam\EloquentFilter\FilterCollection;
use stdClass;

trait EloquentFilterable
{

    /**
     * The collection for all the filters.
     *
     * @var Collection
     */
    protected $filters;

    function __construct()
    {
        $this->filters = collect();
    }

    /**
     * Adds a new filter to the query builder
     *
     * @param  Builder  $builder
     * @param  string  $column
     * @param  null|string  $label
     * @param  string  $type
     * @param  null|string  $default
     * @param  string  $comparison
     *
     * @return void
     */
    public function scopeAddFilter(Builder $query, $column, $label = null, $type = 'text', $default = null, $comparison = '=')
    {
        $filter = new EloquentFilter($column, $label ?: $column, $type, $default, $comparison);

        if($value = Request::input($filter->column)){
            $query->where($filter->column, $filter->comparison, $value);
            $filter->value = $value;
        } elseif($filter->default != null) {
            $query->where($filter->column, $filter->comparison, $filter->default);
            $filter->value = $filter->default;
        }

        // Add the filter to the object
        $this->filters->push($filter);
    }

    public function scopeFilterCollection(Builder $builder, $columns = ['*']){
        return new FilterCollection($builder->get($columns), $this->filters);
    }


}