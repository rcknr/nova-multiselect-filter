<template>
    <div class="form-select-multiple" ref="toggle">

        <div v-if="selected.length === 0" class="empty"></div>
        <ul v-else ref="selected" class="selected">
            <li v-for="option, index in selected" @click="remove(index)">
                {{ option.name }}
            </li>
        </ul>

        <ul v-if="showDropdown && availableOptions.length > 0" class="options">
            <li v-for="option in availableOptions" @click="select(option)" :class="{selected: selected.includes(option)}">
                {{ option.name }}
            </li>
        </ul>

    </div>
</template>

<script>
    export default {
        props: {
            options: {
                type: Array,
                default: []
            },
            value: {
                default: ''
            }
        },
        data: () => ({
            showDropdown: false,
            selected: [],
        }),
        computed: {
            availableOptions() {
                return this.options.filter(option => !this.selected.includes(option));
            },
            effectiveValue() {
                const values = this.selected.map(e => e.value);
                return values.length === 0 ? '' : values;
            },
        },
        methods: {
            select(option) {
                this.showDropdown = false;
                this.selected.push(option);
            },
            remove(index) {
                this.selected.splice(index, 1);
            },
            toggle(event) {
                if([this.$refs.toggle, this.$refs.selected].includes(event.target) && this.availableOptions.length > 0) {
                    this.showDropdown = !this.showDropdown;
                }
                else {
                    this.showDropdown = false;
                }
            }
        },
        mounted() {
            document.addEventListener('click', this.toggle);
            this.selected = this.options.filter(option => {
                return this.value.includes(option.value);
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

        .empty
        {
            margin: auto 0;

            &:before
            {
                content: '\2014';
            }
        }

        ul
        {
            list-style-type: none;
            padding: 0;

            &.selected
            {
                display: flex;
                flex-wrap: wrap;
                margin-left: -.75rem;
                padding: .125rem;

                & > li
                {
                    background-color: var(--primary);
                    border-radius: .25rem;
                    color: var(--white);
                    margin: .125rem;
                    padding: .125rem .35rem;

                    &:hover
                    {
                        background-color: var(--primary-dark);
                    }
                }
            }

            &.options
            {
                position:relative;
                margin-top: 20px;
                background-color: var(\--30);
                border-radius: .5rem;
                border: 1px solid var(\--60);
                left: .1rem;
                padding: .25rem 0;
                position: absolute;
                margin-top:35px;
                max-height: 185px;
                overflow-y: auto;
                z-index: 1000;
                width: calc(100%);

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
