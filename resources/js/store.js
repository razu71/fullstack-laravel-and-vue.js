import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        count: 10,
        deleteObj: {
            deleteModal: false,
            deleteIndex: -1,
            deleteUrl: '',
            data: null,
            isDeleted : false,
        },
        imageObject:{
            showImageList: false,
            iconImage:''
        },
        user:false
    },
    //get data or value to state variable or object
    getters: {
        getDeleteModalObj(state) {
            return state.deleteObj
        },
        getIconImage(state){
            return state.imageObject;
        }
    },
    //set data or value to state variable or object
    mutations: {
        setDeleteObj(state, data){
            const deleteModalObj = {
                isDeleted : data.isDeleted,
                deleteIndex : data.deleteIndex,
            }
            state.deleteObj = deleteModalObj
        },
        setDeletingModalObj(state, data){
            state.deleteObj = data
        },
        setImageObject(state, data){
            state.imageObject = data
        },
        updateUser(state, data){
            state.user = data
        }
    },
    /*Actions work asynchronously that's why it is mostly use for API*/
    actions: {

    }
})
