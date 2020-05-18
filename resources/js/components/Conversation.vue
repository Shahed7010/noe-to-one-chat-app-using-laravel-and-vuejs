<template>
    <div class="conversation">
        <h1>{{contact ? contact.name : 'Select a Contact...'}}</h1>
        <message-area :messages="messages" :contact="contact"></message-area>
        <message-compose @send="sendMessage"></message-compose>
    </div>
</template>

<script>
    import MessageArea from "./MessageArea";
    import MessageCompose from "./MessageCompose";
    export default {
        name: "Conversation",
        components:{
          MessageCompose,
          MessageArea
        },
        props:{
            contact:{
                type: Object,
                default: null,
            },
            messages:{
                type: Array,
                default: [],
            }
        },
        methods:{
            sendMessage(text){
                axios.post(`/conversation/send`,{
                    contact_id : this.contact.id,
                    message : text
                }).then(response => {
                    // console.log(response);
                    this.$emit('new', response.data)
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .conversation{
        flex: 5;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        h1{
            font-size: 20px;
            font-weight: bold;
            border-bottom: 1px solid #1b4b72;
        }
    }
</style>

