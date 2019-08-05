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

    public function __construct()
    {
        $this->withMeta([
            'colorMap' => [],
            'showSearch' => false,
            'showDots' => true
        ]);
    }

    public function colors($map) {
        return $this->withMeta(['colorMap' => $map]);
    }

    public function showSearch() {
        return $this->withMeta(['showSearch' => true]);
    }

    public function hideDots() {
        return $this->withMeta(['showDots' => false]);
    }
}
