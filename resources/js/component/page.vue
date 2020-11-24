<template>
    <div>
        <hr>
        <blogPost v-bind:comment-ids="[234, 266, 273]"></blogPost>
    </div>
</template>

<script>
import blogPost from './click.vue'

export default {
    components: {
        'blogPost': blogPost,
        inheritAttrs: false,
    }
}
</script>
