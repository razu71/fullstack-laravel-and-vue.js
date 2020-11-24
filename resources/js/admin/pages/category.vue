<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->

                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Categories
                        <Button type="dashed" @click="showAddModal">
                            <Icon type="ios-add"/>
                            Add category
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table" :loading="modal_loading">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Id</th>
                                <th>Icon Image</th>
                                <th>Category Name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->
                            <!-- ITEMS -->
                            <tr v-for="(category,i) in categories" :key="i" v-if="categories.length">
                                <td>{{ category.id }}</td>
                                <td class="table_image">
                                    <img :src="`uploads/${category.iconImage}`"/>
                                </td>
                                <td>{{ category.categoryName }}</td>
                                <td>{{ category.created_at }}</td>
                                <td>
                                    <Button type="primary" @click="editModal(category, i)">Edit</Button>
                                    <Button type="error" @click="showModalDelete(category, i)">Delete</Button>
                                </td>
                            </tr>
                            <tr v-if="categories.length <= 0">
                                <td colspan="5">No data found</td>
                            </tr>
                        </table>
                    </div>

                    <Modal v-model="showModal" :title="modal_title" :mask-closable="false">
                        <Input v-model="data.categoryName" @submit="addCategory" placeholder="Enter a category name"/>
                        <div class="space"></div>
                        <imageModal></imageModal>
                        <div slot="footer">
                            <Button type="error" @click="showModal = false">Close</Button>
                            <Button type="info" @click="addCategory" @submit="addCategory" :loading="modal_loading">
                                Add
                            </Button>
                        </div>
                    </Modal>

                    <deleteModal></deleteModal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import deleteModal from '../components/deleteModal.vue';
import imageModal from '../components/imageUpload.vue';
import {mapGetters} from "vuex";

export default {
    name: "category.vue",
    components: {
        deleteModal,
        imageModal
    },
    data() {
        return {
            data: {
                categoryName: '',
                iconImage: ''
            },
            delete_data: {
                id: ''
            },
            returnData: {},
            categories: [],
            modal_title: '',
            category_store: false,
            showModal: false,
            deleteModal: false,
            modal_loading: false,
            index: -1,
        }
    },
    async created() {
        //after create dom show all category list
        const res = await this.callApi('get', 'category/list');
        if (res.status === 200) {
            this.categories = res.data;
            this.showModal = false;
        } else {
            this.swr();
        }
    },
    methods: {
        //show add modal
        showAddModal() {
            this.modal_title = 'Add category';
            this.showModal = true
            this.category_store = true
            this.data.categoryName = ''
        },
        //show edit modal
        editModal(category, i) {
            this.modal_title = 'Edit category';
            this.showModal = true;
            // this.$store.state.showImageList = true;

            let obj = {
                id: category.id,
                categoryName: category.categoryName,
                iconImage: category.iconImage
            }
            this.$store.commit('setImageObject',{
                showImageList: true,
                iconImage: category.iconImage
            })
            // this.$store.state.imageObject.iconImage = category.iconImage;
            this.data = obj;
            this.index = i;
        },

        //create or update a category
        async addCategory() {
            this.modal_loading = true;

            if (this.data.categoryName.trim() === '') {
                this.error('error', 'category name Can not be empty');
                this.modal_loading = false;
            }

            if (this.index !== -1) {
                const edit = await this.callApi('post', 'category/edit', this.data);
                this.returnData = edit;
                if (this.returnData.status === 200) {
                    this.categories[this.index].categoryName = this.data.categoryName;
                    this.categories[this.index].iconImage = this.data.iconImage;
                    this.success('success', 'Category updated successfully');
                    this.showModal = false;
                    this.modal_loading = false;
                }
            } else {
                const create = await this.callApi('post', 'category/create', this.data);
                this.returnData = create;
                if (this.returnData.status === 201) {
                    // this.categories.unshift(create.data);
                    this.categories.push(this.returnData.data)
                    this.success('success', 'Category created successfully');
                    this.showModal = false;
                    this.data.categoryName = '';
                    this.data.iconImage = '';
                    this.modal_loading = false;
                }
            }

            if (this.returnData.status === 422) {
                if (this.returnData.data.errors.categoryName) {
                    this.error('error', this.returnData.data.errors.categoryName[0]);
                    this.modal_loading = false;
                }
            }
        },


        showModalDelete(category, i) {
            // this.this.modal_loading = true;
            const deleteObj = {
                deleteModal: true,
                deleteIndex: i,
                deleteUrl: 'category/delete',
                data: category,
                isDeleted: false
            }
            this.$store.commit('setDeletingModalObj', deleteObj)
        },

    },
    computed: {
        ...mapGetters(['getDeleteModalObj', 'getIconImage']),
        // ...mapMutations(['setIconImage'])
    },
    watch: {
        getIconImage(obj){
          // console.log(obj);
            this.data.iconImage = obj.iconImage
        },
        getDeleteModalObj(obj) {
            console.log(obj)
            if (obj.isDeleted) {
                this.categories.splice(obj.deleteIndex, 1);
            }
        }
    }
}
</script>
