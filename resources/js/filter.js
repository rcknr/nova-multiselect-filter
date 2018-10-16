Nova.booting(Vue => {
    Vue.component('select-multiple', require('./components/SelectMultiple'));
    Vue.component('filter-selector', Vue.component('filter-selector').extend(require('./components/FilterSelector')));
});
