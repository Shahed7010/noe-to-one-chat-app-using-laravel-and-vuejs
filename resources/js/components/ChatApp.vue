<template>
    <div class="chat-app">
        <conversation :messages="messages" :contact="selectedContact" @new="newMessage"></conversation>
        <contact-list :contacts="contacts" @selected="startConversationWith"></contact-list>
    </div>
</template>

<script>
    import ContactList from "./ContactList";
    import Conversation from "./Conversation";
    export default {
        components:{
          ContactList,
          Conversation,
        },
        props:{
            user:{
                type: Object,
                required: true,
            }
        },
        data(){
            return{
                selectedContact:'',
                contacts:[],
                messages:[],
            }
        },
        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('SendMessage', (e) => {
                    console.log(e.message);
                    this.handleIncoming(e.message)
                })
            // console.log(this.user);
            axios.get('/contacts').then(response =>{
                this.contacts = response.data;
            })
        },


        methods:{
            startConversationWith(contact){
                axios.get(`conversation/${contact.id}`).then(response =>{
                    this.messages = response.data;
                    this.selectedContact = contact;
                })
            },
            newMessage(message){
                console.log(message.text);
                this.messages.push(message);
            },
            handleIncoming(message){
                if (this.selectedContact && message.from === this.selectedContact.id){
                    this.newMessage(message);
                }
            }
        }

    }
</script>
<style lang="scss">
    .chat-app{
        display:flex;
    }
</style>
