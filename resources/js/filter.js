import FilterSelector from './components/FilterSelector'

Nova.booting(Vue => {
    Vue.component('filter-selector', FilterSelector).extend(FilterSelector);
});
