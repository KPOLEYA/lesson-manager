<template>
    <div>
        <v-alert v-if="$page.props.flash.success" v-model="show" type="success" dismissible>
            {{ $page.props.flash.success }}
        </v-alert>

        <v-alert v-if="$page.props.flash.error" v-model="show" type="error" dismissible>
            {{ $page.props.flash.error }}
        </v-alert>

        <v-alert v-if="$page.props.flash.info" v-model="show" type="info" dismissible>
            {{ $page.props.flash.info }}
        </v-alert>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                show: true,
            }
        },
        watch: {
            '$page.flash': {
                handler() {
                    this.show = true
                },
                deep: true,
            }
        },
    }
</script>
