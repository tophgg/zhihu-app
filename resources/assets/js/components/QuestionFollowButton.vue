<template xmlns:on="http://www.w3.org/1999/xhtml">
    <button
            class="btn btn-default"
            v-text="text"
            v-bind:class="{'btn-success':followed}"
            v-on:click="follow"
    >
    </button>
</template>

<script>
    export default {
        props:['question'],
        mounted() {
            console.log('Component mounted.')
            this.$http.post('/api/question/follower',{'question':this.question}).then(response =>{
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
                return this.followed ? '已关注' : '关注问题'
            }
        },
        methods: {
            follow(){
                this.$http.post('/api/question/follow',{'question':this.question}).then(response =>{
                    console.log(response.data);
                    this.followed = response.data.followed;
                })
            }
        }
    }
</script>
