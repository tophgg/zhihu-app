<template>
    <button
            class="btn btn-default"
            v-text="text"
            v-bind:class="{'btn-success':voted}"
            v-on:click="vote"
    >
    </button>
</template>

<script>
    export default {
        props:['answer','count'],
        mounted() {
            this.$http.post('/api/answer/' + this.answer + '/votes/users').then(response =>{
                this.voted = response.data.voted;
            })
        },
        data() {
            return {
                voted: false,
            }
        },
        computed: {
            text() {
                return this.count;
            }
        },
        methods: {
            vote(){
                this.$http.post('/api/answer/vote',{'answer':this.answer}).then(response =>{
                    console.log(response.data);

                    this.voted = response.data.voted;
//                    this.myCount = response.data.voted ? this.count++ : this.count--;
                })
            }
        },
    }
</script>
