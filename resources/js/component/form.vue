<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <form @submit="test('fgf')">
                    <Input v-model="formInline.user"></Input>
                    <div class="space"></div>
                    <Input v-model="formInline.use"></Input>
                    <div class="space"></div>
                    <Button type="info" @click="test">Submit</Button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            formInline: {
                user: '',
                use: ''
            }
        }
    },
    methods: {
        test(t){
            this.info(t)
            this.info(this.formInline.use)
        }
    }
}
</script>
