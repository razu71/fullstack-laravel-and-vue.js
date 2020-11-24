<template>
    <div>
        <div class="container">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                <div class="space">
                    <Input type="text" v-model="user.email" placeholder="Email">
                        <Icon type="ios-mail" slot="prepend"></Icon>
                    </Input>
                </div>

                <div class="space">
                    <Input type="password" v-model="user.password" placeholder="Password">
                        <Icon type="ios-lock-outline" slot="prepend"></Icon>
                    </Input>
                </div>
                <Button type="primary" long @click="login" :loading="loading_modal">Signin</Button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "login.vue",
    data() {
        return {
            user: {
                email: '',
                password: '',
            },
            loading_modal: false
        }
    },
    methods: {
        async login() {
            this.loading_modal = true;
            if (this.user.email.trim() == '') return this.error('Error', 'Email can\'t be empty')
            if (this.user.password.trim() == '') return this.error('Error', 'Password can\'t be empty')

            const response = await this.callApi('post', 'login', this.user)
            console.log(this.user)
            console.log(response)
            //if (res.status === 200) {
                //window.location = '/';
            //     this.success('Great', 'Logged in successfully')
            // } else {
            //     this.error('Error', res.data.message);
            // }
        }
    }
}
</script>

<style scoped>
.container {
    max-width: 100% !important;
}

._1adminOverveiw_table_recent {
    margin: 0 auto;
    width: 30%;
    margin-top: 200px;
    border-radius: 5px;
}
</style>
