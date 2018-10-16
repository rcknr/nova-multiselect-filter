<?php

namespace Acme\Filters;

use Laravel\Nova\Filters\Filter;

abstract class MultiselectFilter extends Filter
{
    /**
     * Prepare the filter for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_add(parent::jsonSerialize(), 'multiple', true);
    }
}
