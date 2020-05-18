<template>
    <div class="composer">
        <textarea v-model="message" @keydown.enter="send" placeholder="enter message.."></textarea>
    </div>
</template>

<script>
    export default {
        name: "MessageCompose",
        data(){
            return{
                message:'',
            }
        },
        methods:{
            send(e){
                e.preventDefault();
                if (this.message !== '' && $.trim(this.message) !== ''){
                    this.$emit('send', this.message);
                    this.message = ''
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .composer textarea{
        width: 98%;
        resize: none;
        border-radius: 4px;
        padding: 3px;
    }
</style>
