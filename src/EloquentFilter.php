<?php
namespace WStam\EloquentFilter;

class EloquentFilter
{
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
    function __construct($column, $label = null, $type = 'text', $default = null, $comparison = '=')
    {
        $this->column = $column;
        $this->label = $label;
        $this->type = $type;
        $this->default = $default;
        $this->comparison = $comparison;
    }
}