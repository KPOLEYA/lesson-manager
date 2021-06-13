<template>
    <v-app id="inspire">
        <v-main class="mb-10">
            <v-container class="fill-height" fluid>
                <slot/>
            </v-container>
        </v-main>
        <v-footer padless color="primary" dark absolute class="font-weight-light text-caption">
            <v-col class="text-center" cols="12">
                {{ new Date().getFullYear() }} - Version {{ $page.props.version }} - Propulsé par Kévin POLEYA
            </v-col>
        </v-footer>
    </v-app>
</template>

<script>
    export default {
        
    }
</script>
