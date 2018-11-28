import FilterSelector from './components/FilterSelector'

Nova.booting(Vue => {
    Vue.component('select-filter', Vue.component('select-filter').extend(FilterSelector));
});
