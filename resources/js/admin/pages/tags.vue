<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->

                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Tags
                        <Button type="dashed" @click="showAddModal">
                            <Icon type="ios-add"/>
                            Add tag
                        </Button>
                    </p>
                    <!--                    <Table border :columns="columns1" :data="tags"></Table>-->

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Id</th>
                                <th>Tag Name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(tag,i) in tags" :key="i" v-if="tags.length">
                                <td>{{ tag.id }}</td>
                                <td>{{ tag.tagName }}</td>
                                <td>{{ tag.created_at }}</td>
                                <td>
                                    <Button type="primary" @click="editModal(tag, i)">Edit</Button>
                                    <Button type="error" @click="showModalDelete(tag, i)">Delete</Button>
                                </td>
                            </tr>
                            <tr v-if="tags.length <= 0">
                                <td :colspan="4" :header-row-style="{textAlign: 'center'}">No data found</td>
                            </tr>
                        </table>
                    </div>

                    <Modal v-model="showModal" :title="modal_title" :mask-closable="false">
                        <Input v-model="data.tagName" @submit="addTag" placeholder="Enter a tag"/>

                        <div slot="footer">
                            <Button type="error" @click="showModal = false">Close</Button>
                            <Button type="info" @click="addTag" @submit="addTag" :loading="modal_loading">Add</Button>
                            <!--                            <Button v-else type="info" @click="editTag" @submit="editTag" :loading="modal_loading">Edit</Button>-->
                        </div>
                    </Modal>

                    <delete-modal></delete-modal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import deleteModal from '../components/deleteModal.vue';
import {mapGetters} from "vuex";
export default {
    name: "tags.vue",
    components: {
        deleteModal
    },
    data() {
        return {
            data: {
                tagName: ''
            },
            delete_data: {
                id: ''
            },
            returnData: {},
            tags: [],
            modal_title: '',
            tag_store: false,
            showModal: false,
            deleteModal: false,
            modal_loading: false,
            index: -1,
        }
    },
    async created() {
        //after create dom show all tag list
        const res = await this.callApi('get', 'tag/list');
        console.log(res)
        if (res.status === 200) {
            this.tags = res.data;
            this.showModal = false;
        } else {
            this.swr();
        }
    },
    methods: {
        //show add modal
        showAddModal() {
            this.modal_title = 'Add tag';
            this.showModal = true
            this.tag_store = true
            this.data.tagName = ''
        },
        //show edit modal
        editModal(tag, i) {
            this.modal_title = 'Edit tag';
            this.showModal = true;

            let obj = {
                id: tag.id,
                tagName: tag.tagName
            }
            this.data = obj;
            // this.this.modal_loading = true;
            // this.showEditModal = true;
            this.index = i;
        },

        //create or update a tag
        async addTag() {
            this.modal_loading = true;

            // if (this.data.tagName.trim() === '') {
            //     this.error('error', 'Can not be empty');
            //     this.modal_loading = false;
            // }

            if (this.index !== -1) {
                const edit = await this.callApi('post', 'tag/edit', this.data);
                this.returnData = edit;
                if (this.returnData.status === 200) {
                    this.tags[this.index].tagName = this.data.tagName;
                    this.success('success', 'Tag updated successfully');
                    this.showModal = false;
                    this.modal_loading = false;
                }
            } else {
                const create = await this.callApi('post', 'tag/create', this.data);
                this.returnData = create;
                if (this.returnData.status === 201) {
                    // this.tags.unshift(create.data);
                    this.tags.push(this.returnData.data)
                    this.success('success', 'Tag created successfully');
                    this.showModal = false;
                    this.data.tagName = '';
                    this.modal_loading = false;
                }
            }

            if (this.returnData.status === 422) {
                if (this.returnData.data.errors.tagName) {
                    this.error('error', this.returnData.data.errors.tagName[0]);
                    this.modal_loading = false;
                }
            }
        },

        showModalDelete(tag, i) {
            // this.this.modal_loading = true;
            const deleteObj = {
                deleteModal: true,
                deleteIndex: i,
                deleteUrl: 'tag/delete',
                data: tag,
                isDeleted: false
            }
            this.$store.commit('setDeletingModalObj', deleteObj)
        },
    },
    computed: {
        ...mapGetters(['getDeleteModalObj']),
    },
    watch: {
        getDeleteModalObj(obj) {
            if (obj.isDeleted) {
                this.tags.splice(obj.deleteIndex, 1);
            }
        }
    }
}
</script>
