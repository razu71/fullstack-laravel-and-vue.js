<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <p>Method : {{ todoMethod }}</p>
                    <ol>
                        <li v-for="tests in test">
                            {{ tests }}
                        </li>
                    </ol>
                    <br>
                    <Button type="warning" size='large' @click="addATodo">Add todo</Button>
                    <h3>{{ commentIds }}</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            todo: {},
            test: []
        }
    },
    props: {
        title: String,
        likes: Number,
        isPublished: Boolean,
        commentIds: Array,
        author: Object,
        callback: Function,
        contactsPromise: Promise
    },
    watch: {
        todo(new_test) {
            this.test = new_test
        }
    },
    computed: {
        count() {
            return this.$store.state.count
        }
        ,
        doneTodosCount() {
            return this.$store.getters.doneTodosCount
        }
        ,
        todoMethod() {
            return this.addATodo()
        }
    }
    ,
    methods: {
        addATodo() {
            const id = this.doneTodosCount
            const todo = {id: id, text: '...', done: true}
            this.test.push(todo)
            this.$store.commit('addTodo', {
                list: todo
            })
            return todo
        }
        ,
        increment() {
            this.$store.dispatch('incrementAsync')
        }
        ,
        decrement() {
            this.$store.commit('decrement')
        }
    }
}
</script>
