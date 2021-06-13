<template>
    <v-app id="inspire">
        <navigation-drawer :username="username"></navigation-drawer>
        <v-main>
            <v-container fluid scroll-region>
                <v-breadcrumbs large class="pt-1 pl-1" v-if="$root.breadcrumbs" :items="$root.breadcrumbs">
                    <template v-slot:item="{ item }">
                        <v-breadcrumbs-item :href="item.href" @click.prevent="visitPage(item.href)" :disabled="item.disabled" >
                            {{ item.text }}
                        </v-breadcrumbs-item>
                    </template>
                    <template v-slot:divider>
                        <v-icon>fa-chevron-right</v-icon>
                    </template>
                </v-breadcrumbs>
                <flash-message></flash-message>
                <slot/>
            </v-container>
        </v-main>
    </v-app>
</template>
<script>
    import NavigationDrawer from "../components/NavigationDrawer"
    import FlashMessage from "../components/FlashMessage";

    export default {
        components: {
            NavigationDrawer,
            FlashMessage
        },
        created() {
            this.username = this.$page.props.auth.user ? this.$page.props.auth.user.name : 'Bienvenue';
        },
        methods: {
            visitPage(link) {
                this.$inertia.visit(link);
            }
        }
    };
</script>
