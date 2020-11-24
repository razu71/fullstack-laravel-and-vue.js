<template>
    <div>
        <Modal v-model="getDeleteModalObj.deleteModal" :mask-closable="false" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="ios-information-circle"></Icon>
                <span>Delete confirmation</span>
            </p>
            <div style="text-align:center">
                <p>Would you want to delete it?</p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="modal_loading" @click="del">Delete</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    name: "deleteModal.vue",
    data() {
        return {
            modal_loading:false
        }
    },
    methods: {
        async del() {
            this.modal_loading = true;
            const delete_category = await this.callApi('post', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data);
            if (delete_category.status === 200) {
                this.success('success', 'Deleted successfully');
                this.$store.commit('setDeleteObj', {
                    isDeleted : true,
                    deleteIndex : this.getDeleteModalObj.deleteIndex
                })
            } else {
                if (delete_category.status === 422) {
                    this.error('error', delete_category.data.errors.message);
                    this.$store.commit('setDeleteObj', {
                        isDeleted : false,
                        deleteIndex : -1
                    })
                } else {
                    this.swr();
                    this.$store.commit('setDeleteObj', {
                        isDeleted : false,
                        deleteIndex : -1
                    })
                }
            }
            this.modal_loading = false;
        }
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    }
}
</script>
