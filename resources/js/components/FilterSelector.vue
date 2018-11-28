<template>
    <div>
        <h3 class="text-sm uppercase tracking-wide text-80 bg-30 p-3">
            {{ filter.name }}
        </h3>

        <div class="p-2">
            <select-multiple slot="select"
                :dusk="filter.name + '-filter-select'"
                :multiple="filter.multiple"
                :options="filter.options"
                :value="filter.currentValue"
                @change="filterUpdate(filter, $event)"
                class="block w-full form-control-sm form-select"
            />
        </div>
    </div>
</template>

<script>
    import SelectMultiple from './SelectMultiple'

    export default {
        components: {
            SelectMultiple
        },
        methods: {
            filterUpdate(filter, currentValue) {
                this.filterChanged(Object.assign(filter, {
                    currentValue
                }));
            }
        },
    }
</script>
