<template>
    <div>
        Connecté
    </div>
</template>

<script>
    import App from "../layouts/App";

    export default {
        layout: App,
        metaInfo: {
            title: 'Dashboard',
            breadcrumbs: [
                {
                    text: 'Dashboard',
                    disabled: true
                }
            ],
        },
    }
</script>