<template>
    <div>
        <div v-if="$store.state.user">
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu">
                <div class="_1side_menu_logo">
                    <h3 style="text-align:center;">Logo Image</h3>
                    <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content">
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">Admin</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">

                            <li><router-link :to="{ name: 'home'}">Home</router-link></li>
                            <li><router-link :to="{ name: 'tag'}">Tag</router-link></li>
                            <li><router-link :to="{ name: 'category'}">Category</router-link></li>
                            <li><router-link :to="{ name: 'click'}">Practice 1</router-link></li>
                            <li><router-link :to="{ name: 'user'}">Users</router-link></li>
                            <li><router-link :to="{ name: 'slots'}">Slots</router-link></li>
                            <li><router-link :to="{ name: 'form'}">Form</router-link></li>
                            <li><a href="/logout">Logout</a></li>

<!--                            <li>-->
<!--                                <router-link><Icon type="ios-speedometer"/>Logout</router-link>-->
<!--                            </li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li>
                                <Icon type="ios-list" @click="sideBar = !sideBar"/>
                            </li>
                            <!--<li><Icon type="ios-albums" /></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
        <router-view/>
    </div>
</template>

<script>
export default {
    props:['user'],
    created() {
        console.log(this.user)
        this.$store.commit('updateUser', this.user)
    }
}
</script>
