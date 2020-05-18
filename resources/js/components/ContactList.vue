<template>
    <div class="contact-list">
        <ul>
            <li v-for="(contact,index) in contacts" :key="contact.id" @click="selectContact(index, contact)"
                :class="{'selected' : index === selected}">
                <div class="avator">
                    <img :src="contact.image" :alt="contact.name">
                </div>
                <div class="contact">
                    <p class="name">{{contact.name}}</p>
                    <p class="">{{contact.phone}}</p>
                </div>
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
            }
        },
        methods:{
            selectContact(index, contact){
                // console.log(typeof contact);
                this.selected = index;
                this.$emit('selected', contact);
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
