<template>
    <div class="form-select-multiple" ref="toggle">

        <div v-if="(selected.length === 0) || !multiple" ref="selected" class="selected">{{ displayValue }}</div>

        <ul v-else ref="selected" class="selected">
            <li v-for="option, index in selected" @click="remove(index)">
                {{ option.name }}
            </li>
        </ul>

        <ul v-if="optionsShown && availableOptions.length > 0" class="options">
            <li v-for="option in availableOptions" @click="select(option)">{{ option.name }}</li>
        </ul>

    </div>
</template>

<script>
    export default {
        props: {
            multiple: {
                type: Boolean,
                default: false
            },
            options: {
                type: Array,
                default: []
            },
            value: {
                default: ''
            }
        },
        data: () => ({
            emptyValue: {
                name: '—',
                value: ''
            },
            optionsShown: false,
            selected: [],
        }),
        computed: {
            availableOptions() {
                return this.multiple ?
                    this.options.filter(option => !this.selected.includes(option)) :
                    [this.emptyValue].concat(this.options);
            },
            displayValue() {
                return this.selected.length === 1 ? this.selected[0].name : this.emptyValue.name;
            },
            effectiveValue() {
                const values = this.selected.map(e => e.value);
                if(values.length === 0) return '';
                else if(values.length === 1 && !this.multiple) return values[0];
                else return values;
            },
        },
        methods: {
            select(option) {
                this.optionsShown = false;

                if(this.multiple) {
                    this.selected.push(option);
                }
                else {
                    this.selected = [option];
                }
            },
            remove(index) {
                this.selected.splice(index, 1);
            },
            toggle(event) {
                if([this.$refs.toggle, this.$refs.selected].includes(event.target) && this.availableOptions.length > 0) {
                    this.optionsShown = !this.optionsShown;
                }
                else {
                    this.optionsShown = false;
                }
            }
        },
        mounted() {
            document.addEventListener('click', this.toggle);
            this.selected = this.options.filter(option => {
                return this.multiple ?
                    this.value.includes(option.value) :
                    this.value === option.value;
            });
        },
        watch: {
            selected: function() {
                this.$emit('change', this.effectiveValue);
            }
        }
    }
</script>

<style lang="scss">

    .form-select-multiple
    {
        display: flex;
        min-height: 2rem;
        height: auto;

        div.selected
        {
            margin: auto 0;
        }

        ul
        {
            list-style-type: none;
            padding: 0;

            &.selected
            {
                margin-left: -.5rem;

                & > li
                {
                    background-color: var(--primary);
                    border-radius: .25em;
                    color: var(--white);
                    display: inline-flex;
                    margin: 0 .25em .25em 0;
                    padding: .125rem .35rem;

                    &:first-child
                    {
                        margin-top: .25rem;
                    }

                    &:hover
                    {
                        background-color: var(--primary-dark);
                    }
                }
            }

            &.options
            {
                background-color: #f0f0f0;
                border-radius: .5rem;
                border: 1px solid #ccc;
                color: var(--90);
                left: .1rem;
                padding: .25rem 0;
                position: absolute;
                width: calc(100% - 1.5rem);

                & > li
                {
                    padding: .25rem .75rem;

                    &:hover
                    {
                        background-color: var(--primary);
                        color: var(--white);
                    }
                }
            }
        }
    }

</style>
