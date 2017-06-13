<template xmlns:on="http://www.w3.org/1999/xhtml">
    <button
            class="btn btn-default pull-left"
            v-text="text"
            v-bind:class="{'btn-success':followed}"
            v-on:click="follow"
    >
    </button>
</template>

<script>
    export default {
        props:['user'],
        mounted() {
            console.log('Component mounted.')
            this.$http.get('/api/user/followers/' + this.user).then(response =>{
                console.log(response.data);
                this.followed = response.data.followed;
            })
        },
        data() {
            return {
                followed: false
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注' : '关注他'
            }
        },
        methods: {
            follow(){
                this.$http.post('/api/user/follow',{'user':this.user}).then(response =>{
                    console.log(response.data);
                    this.followed = response.data.followed;
                })
            }
        }
    }
</script>
