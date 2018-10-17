import FilterSelector from './components/FilterSelector'

Nova.booting(Vue => {
    Vue.component('filter-selector', Vue.component('filter-selector').extend(FilterSelector));
});
