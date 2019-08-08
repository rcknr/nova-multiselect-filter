<template>
    <div class="form-select-multiple" ref="toggle">

        <div v-if="selected.length === 0" class="empty"></div>
        <ul v-else ref="selected" class="selected">
            <li v-for="option, index in selected" @click="remove(index)"
                v-bind:style="{ backgroundColor: backgroundColor(option), color: textColor(option) }">
                {{ option.name }}
            </li>
        </ul>

        <ul v-if="showDropdown && (availableOptions.length > 0 || searchValue.length > 0)" class="options">
            <input v-model="searchValue" placeholder="Search" class="form-control form-input search-input" v-if="search"/>
            <li v-for="option in availableOptions" @click="select(option)"
                :class="{selected: selected.includes(option)}">
                <span v-if="Object.keys(colors).length > 0 && dots" class="inline-block rounded-full w-2 h-2" v-bind:style="{ backgroundColor: backgroundColor(option) }"></span> {{ option.name }}
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
            },
            colors: {
                type: Array,
                default: []
            },
            search: {
                type: Boolean,
                default: false
            },
            dots: {
                type: Boolean,
                default: true
            }
        },
        data: () => ({
            showDropdown: false,
            searchValue: '',
            selected: [],
        }),
        computed: {
            availableOptions() {
                return this.options.filter(option => !this.selected.includes(option) && option.name.toString().toLowerCase().includes(this.searchValue.toLowerCase()));
            },
            effectiveValue() {
                const values = this.selected.map(e => e.value);
                return values.length === 0 ? '' : values;
            }
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
                if (!event.target.classList.contains('form-input')) {
                    if ([this.$refs.toggle, this.$refs.selected].includes(event.target) && this.availableOptions.length > 0) {
                        this.showDropdown = !this.showDropdown;
                        this.searchValue = '';
                    } else {
                        this.showDropdown = false;
                    }
                }
            },
            backgroundColor: function (option) {
                if (!this.colors.hasOwnProperty(option.name)) {
                    return null;
                }

                let value = this.colors[option.name];

                if (value.hasOwnProperty('background')) {
                    return value.background;
                }

                return value;
            },
            textColor: function (option) {
                if (!this.colors.hasOwnProperty(option.name)) {
                    return null;
                }

                let value = this.colors[option.name];

                if (value.hasOwnProperty('color')) {
                    return value.color;
                }

                let color = value;

                //if only first half of color is defined, repeat it
                if (color.length < 5) {
                    color += color.slice(1);
                }

                color = (color.replace('#', '0x')) > (0xffffff / 2) ? '#333' : '#fff';

                return color;
            }
        },
        mounted() {
            document.addEventListener('click', this.toggle);
            this.selected = this.options.filter(option => {
                return this.value.includes(option.value);
            });
        },
        watch: {
            selected: function () {
                this.$emit('change', this.effectiveValue);
            }
        }
    }
</script>

<style lang="scss">
    .form-select-multiple {
        display: flex;
        min-height: 2rem;
        height: auto;

        .empty {
            margin: auto 0;

            &:before {
                content: '\2014';
            }
        }

        ul {
            list-style-type: none;
            padding: 0;

            &.selected {
                display: flex;
                flex-wrap: wrap;
                margin-left: -.75rem;
                padding: .125rem;

                & > li {
                    background-color: var(--primary);
                    border-radius: .25rem;
                    color: var(--white);
                    margin: .125rem;
                    padding: .125rem .35rem;

                    &:hover {
                        background-color: var(--primary-dark);
                    }
                }
            }

            &.options {
                background-color: var(\--30);
                border-radius: .5rem;
                border: 1px solid var(\--60);
                left: .1rem;
                padding: .25rem 0;
                position: absolute;
                width: calc(100% - 1.5rem);

                & > li {
                    padding: .25rem .75rem;

                    &:hover {
                        background-color: var(--primary);
                        color: var(--white);
                    }
                }
            }
        }

        .search-input {
            width: 100%;
            height: auto;
            margin-bottom: .25rem;
            margin-top: -.25rem;
        }
    }

</style>
