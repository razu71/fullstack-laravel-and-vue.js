<template>
    <div>
        <Upload type="drag"
                ref="uploads"
                :headers="{'x-csrf-token' : token, 'X-Requested-With' : 'XMLHttpRequested'}"
                :on-success="handleSuccess"
                :on-error="handleError"
                :on-format-error="handleFormatError"
                :on-exceeded-size="handleMaxSize"
                :max-size="2048"
                action="/category/upload">
            <div style="padding: 20px 0">
                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                <p>Click or drag files here to upload</p>
            </div>
        </Upload>
        <div class="demo-upload-list" v-if="$store.state.imageObject.showImageList">
            <img :src="`uploads/${getIconImage.iconImage}`">
            <div class="demo-upload-list-cover">
                <Icon type="ios-trash-outline" @click.native="deleteImage"></Icon>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: "imageUpload.vue",
    data() {
        return {
            index: -1,
        }
    },
    methods: {
        handleSuccess(res, file) {
            // this.$store.state.imageObject.showImageList = true;
            this.$store.commit('setImageObject', {
                showImageList: true,
                iconImage: res
            })
        },
        handleError(res, file) {
            this.warning('error', file.file[0]);
        },
        handleFormatError(file) {
            this.warning({
                title: 'Incorrect file format',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize(file) {
            this.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },

        async deleteImage() {
            var image = this.data.iconImage;
            this.data.iconImage = '';
            this.$refs.uploads.clearFiles()
            const res = await this.callApi('post', 'upload/deleteimage', {imageName: image});
            if (res.status != 200) {
                this.data.iconImage = image;
                this.swr()
            }
        },
    },
    computed: {
        ...mapGetters(['getIconImage'])
    },
    watch: {}
}
</script>

