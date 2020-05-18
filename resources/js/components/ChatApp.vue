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
                    // console.log(e.message);
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
                    this.updateUnreadContact(contact, true)
                })
            },
            newMessage(message){
                console.log(message.text);
                this.messages.push(message);
            },
            handleIncoming(message){
                if (this.selectedContact && message.from === this.selectedContact.id){
                    this.newMessage(message);
                    return;
                }
                console.log(message);
                this.updateUnreadContact(message.from_contact, false)
            },
            updateUnreadContact(contact, reset){
                this.contacts = this.contacts.map((person)=>{
                    if (person.id !== contact.id){
                        return person;
                    }
                    if (reset)
                        person.unread = 0;
                    else{
                        person.unread = person.unread + 1;
                    }
                    return person;
                })
            }
        }

    }
</script>
<style lang="scss">
    .chat-app{
        display:flex;
    }
</style>
