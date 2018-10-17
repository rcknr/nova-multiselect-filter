<template>
    <div>
        <filter-select v-for="filter in filters" :key="filter.name">
            <h3 slot="default" class="text-sm uppercase tracking-wide text-80 bg-30 p-3">
                {{ filter.name }}
            </h3>

            <select-multiple slot="select"
                :dusk="filter.name + '-filter-select'"
                :multiple="filter.multiple"
                :options="filter.options"
                :value="filter.currentValue"
                @change="filterUpdate(filter, $event)"
                class="block w-full form-control-sm form-select"
            />
        </filter-select>
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
