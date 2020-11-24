<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <p class="_title0">
                    Users
                    <Button type="dashed" @click="showUserAddModal = true">
                        <Icon type="ios-add"/>
                        Add user
                    </Button>
                </p>
                <Table border :columns="user_column" :data="userList" :no-data-text="not_found" :loading="loading">
                    <template slot-scope="{ row }" slot="fullName">
                        <strong>{{ row.fullName }}</strong>
                    </template>
                    <template slot-scope="{ row, index }" slot="action">
                        <Button type="primary" size="small" style="margin-right: 5px" @click="viewUser(index)">
                            <Tooltip content="View" placement="top">
                                <Icon type="ios-eye"/>
                            </Tooltip>
                        </Button>
                        <Button type="info" size="small" @click="showEditModal(row, index)">
                            <Tooltip content="Edit" placement="top">
                                <Icon type="md-create" />
                            </Tooltip>
                        </Button>
                        <Button type="error" size="small" @click="deleteUser(row, index)">
                            <Tooltip content="Delete" placement="top">
                                <Icon type="ios-trash"/>
                            </Tooltip>
                        </Button>
                    </template>
                </Table>
                <Modal v-model="showUserAddModal" :title="modal_title" :mask-closable="false">
                    <Input type="text" v-model="userModel.fullName" placeholder="Username">
                        <Icon type="ios-person-outline" slot="prepend"></Icon>
                    </Input>
                    <div class="space"></div>
                    <Input type="email" v-model="userModel.email" placeholder="Email">
                        <Icon type="ios-mail" slot="prepend"></Icon>
                    </Input>
                    <div class="space"></div>
                    <Input type="password" v-model="userModel.password" placeholder="Password">
                        <Icon type="ios-lock-outline" slot="prepend"></Icon>
                    </Input>
                    <div class="space"></div>
                    <Select v-model="userModel.userType" :placeholder="user_type_placeholder" prefix="ios-contacts">
                        <Option v-for="type in types" :value="type.name" :key="type.value">{{ type.name }}</Option>
                    </Select>
                    <div slot="footer">
                        <Button type="error" @click="showUserAddModal = false">Close</Button>
                        <Button type="info" @click="addUser()" @submit="addUser()"
                                :loading="loading">Add
                        </Button>
                    </div>
                </Modal>
                <delete-modal></delete-modal>
                <BackTop :height="100" :bottom="200">
                    <div class="top"><Icon type="ios-arrow-up" /></div>
                </BackTop>
            </div>
        </div>
    </div>
</template>

<script>
import deleteModal from "../components/deleteModal";
import {mapGetters} from "vuex";

export default {
    name: "users",
    components: {
        'delete-modal': deleteModal
    },
    data() {
        return {
            userList: [],
            user_type_placeholder: 'Select user type',
            types: [
                {name: 'Admin', value: 1},
                {name: 'User', value: 2}
            ],
            userModel: {
                id: '',
                fullName: '',
                email: '',
                password: '',
                userType: '',
            },
            not_found: 'Data not found',
            user_column: [
                {
                    title: 'Full name',
                    slot: 'fullName'
                },
                {
                    title: 'Email',
                    key: 'email'
                },
                {
                    title: 'User type',
                    key: 'userType'
                },
                {
                    title: 'Action',
                    slot: 'action',
                    width: 150,
                    align: 'center'
                }
            ],
            showUserAddModal: false,
            loading: false,
            modal_title: "Add user",
            edit_index:-1,
            edit_user_list: {},
        }
    },
    async created() {
        this.loading = true;
        //after create dom show all tag list
        const res = await this.callApi("get", "user/list");
        if (res.status === 200) {
            this.userList = res.data;
            this.loading = false;
        } else {
            this.swr();
        }
    },
    methods: {
        viewUser(index) {
            this.$Modal.info({
                title: 'User Info',
                content: `Full name：${this.userList[index].fullName}<br>Email：${this.userList[index].email}<br>User type：${this.userList[index].userType}`,
                okText: 'Ok'
            })
        },

        async addUser() {
            this.loading = true
            // if (this.userModel.fullName.trim() == '') this.error('Error', 'Full name is required')
            // if (this.userModel.email.trim() == '') this.error('Error', 'Email is required')
            // if (this.userModel.password.trim() == '') this.error('Error', 'Password is required')

            if (this.edit_index != -1){
                const res = await this.callApi("post", "user/edit", this.userModel);
                this.edit_user_list = res
                if (this.edit_user_list.status === 200) {
                    console.log(this.userModel)
                    console.log(this.userList[this.edit_index])
                    this.userList[this.edit_index].fullName = this.userModel.fullName;
                    this.userList[this.edit_index].email = this.userModel.email;
                    this.userList[this.edit_index].userType = this.userModel.userType;
                    this.success('success', 'User updated successfully');
                    this.showUserAddModal = false
                    this.loading = false
                    this.userModel = ''
                } else {
                    this.loading = false
                    this.showUserAddModal = false
                    this.error('Error!', 'Something went wrong');
                }
            }else{
                const res = await this.callApi("post", "user/create", this.userModel);
                if (res.data.success === true) {
                    this.success('success', res.data.message);
                    this.userList.unshift(res.data.data)
                    this.showUserAddModal = false
                    this.loading = false
                    this.userModel = ''
                } else {
                    this.loading = false
                    this.showUserAddModal = false
                    this.error('Error!', 'Something went wrong');
                }
            }
        },
        showEditModal(user, index){
            this.showUserAddModal = true;

            let obj = {
                id: user.id,
                fullName: user.fullName,
                email: user.email,
                password: user.password,
                userType: user.userType,
            }
            this.userModel = obj;
            this.edit_index = index
        },

        async deleteUser(user, index) {
            const deleteObj = {
                deleteModal: true,
                deleteIndex: index,
                deleteUrl: 'user/delete',
                data: user,
                isDeleted: false
            }
            this.$store.commit('setDeletingModalObj', deleteObj)
        }
    },
    computed: {
        ...mapGetters(['getDeleteModalObj']),
    },
    watch: {
        getDeleteModalObj(obj) {
            if (obj.isDeleted) {
                this.userList.splice(obj.deleteIndex, 1);
            }
        }
    }
}
</script>

<style scoped>
.top{
    padding: 2px;
    background: rgba(0, 153, 229, .7);
    color: #fff;
    text-align: center;
    border-radius: 2px;
}
</style>
