

<template>
    <div>
        <button
                class="btn btn-default pull-right"
                v-bind:class="{'btn-success':voted}"
                @click="showSendMessageForm"
        >发送私信</button>
        <!-- Access Token Modal -->
        <div class="modal fade" id="modal-send-message" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            发送私信
                        </h4>
                    </div>

                    <div class="modal-body">
                        <textarea class="form-control" name="body" id="body" v-model="body" v-if="!status" cols="30" rows="10"></textarea>
                        <div class="alert alert-success" v-if="status">
                            <strong>私信发送成功</strong>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="store">
                            发送私信
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props:['user'],

        data() {
            return {
                body: '',
                status: false
            }
        },
        methods: {
            store(){
                this.$http.post('/api/message/store',{'user':this.user,'body':this.body}).then(response =>{
                    console.log(response.data);

                    this.status = response.data.status;
                    setTimeout(function(){
                        $('#modal-send-message').modal('hide');
                    },2000);

                })
            },
            showSendMessageForm() {
                $('#modal-send-message').modal('show');
            },
        }
    }
</script>
