<?php

namespace rcknr\Nova\Filters;

use Laravel\Nova\Filters\Filter;

abstract class MultiselectFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'multiselect-filter';
}
