<template>
    <div class="message-area" ref="area">
    <ul v-if="contact">
        <li v-for="message in messages" :key="message.id" :class="`message${message.to === contact.id? ' sent' : ' received'}`">
            <div class="text">
                {{message.text}}
            </div>
        </li>
    </ul>
    </div>
</template>

<script>
    export default {
        name: "MessageArea",
        props:{
            contact:{
                type:Object,
            },
            messages:{
                type: Array,
                required: true,
            }
        },
        methods:{
            scrollToBottom(){
                setTimeout(()=>{
                    this.$refs.area.scrollTop = this.$refs.area.scrollHeight - this.$refs.area.clientHeight;
                },50)
            }
        },
        watch:{
            contact(contact){
                this.scrollToBottom()
            },
            messages(messages){
                this.scrollToBottom()
            }
        }
    }
</script>

<style lang="scss" scoped>
    .message-area{
        height: 100%;
        background: #e2f0fb;
        max-height: 315px;
        margin: 0px;
        overflow-y: scroll;
        ul{
            padding: 5px;
            list-style-type: none;
            li{
                &.message{
                    margin: 15px 0px;
                    width: 100%;
                    .text{
                        max-width: 250px;
                        border-radius: 5px;
                        padding: 10px;
                        display: inline-block;
                    }

                    &.sent{
                        text-align: right;
                        .text{
                            background: #cacaca;
                        }
                    }
                    &.received{
                        text-align: left;
                        .text{
                            background: #98dfb6;
                        }
                    }
                }
            }
        }
    }
</style>
