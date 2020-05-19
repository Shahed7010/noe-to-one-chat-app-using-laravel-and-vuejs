<template>
    <div class="contact-list">
        <input type="text" class="form-control" v-model="search" placeholder="search name..">
        <ul>
            <li v-for="(contact) in sortedContacts" :key="contact.id" @click="selectContact(contact)"
                :class="{'selected' : contact === selected}">
                <div class="avator">
                    <img :src="contact.image" :alt="contact.name">
                </div>
                <div class="contact">
                    <p class="name">{{contact.name}}</p>
                    <p class="">{{contact.phone}}</p>
                </div>
                <span v-if="contact.unread">{{contact.unread}}</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "ContactList",
        props:{
            contacts:{
                type: Array,
                default: [],
            }
        },
        data(){
            return{
                selected: null,
                search:'',
            }
        },
        methods:{
            selectContact(contact){
                // console.log(typeof contact);
                this.selected = contact;
                this.$emit('selected', contact);
            }
        },
        computed:{
            sortedContacts(){
                var unreadContacts = _.sortBy(this.contacts, [(contact)=>{
                    if (this.selected === contact){
                        return Infinity;
                    }
                    return contact.unread
                }]).reverse();
                return unreadContacts.filter((contact)=>{
                    return contact.name.toLowerCase().match(this.search.toLowerCase())
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .contact-list{
        flex: 3;
        max-height: 420px;
        overflow-y: scroll;
        border-left: 1px solid slateblue;
    }
    ul{
        list-style: none;
        padding-left: 0px;
    }
    li{
        display: flex;
        border-bottom: 1px solid  black;
        position: relative;
        height: 65px;
        cursor: pointer;
        padding: 4px 0px 0px 2px;
        &.selected{
            background: #95c5ed;
        }
        span{
            background: #1d68a7;
            color: #f8fafc;
            position: absolute;
            top: 15px;
            right: 10px;
            min-width: 20px;
            border-radius: 40%;
            display: flex;
            justify-content: center;
            padding: 3px;
            font-size: 10px;
        }
        .avator{
            flex: 1;
            display: flex;
            align-items: center;
            img{
                width: 40px;
                border-radius: 50%;
                margin: 0 auto;
            }
        }
        .contact{
            display: flex;
            justify-content: center;
            flex: 3;
            overflow: hidden;
            flex-direction: column;
            font-size: 12px;
            p{
                margin: 0;
                &.name{
                    font-weight: bold;
                }
            }
        }
    }
</style>
