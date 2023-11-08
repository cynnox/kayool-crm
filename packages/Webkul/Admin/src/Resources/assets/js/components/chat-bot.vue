<style>
.chat-button-container {
    position: absolute;
    z-index: 99999;
    bottom: 50px;
    right: 0px;
}
.round-button {
    border: none;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 20px;
    margin: 20px;
    cursor: pointer;
    padding-top: 5px;
    height: 40px;
    width: 40px;
}
.chat-button {
    color: white;
    background-color: #299d8f;
}
.chat-container {
    height: 80vh;
    width: 350px;
    background-color: white;
    box-shadow: 1px 1px 5px 0px rgba(0, 0, 0, 0.75);
    -webkit-box-shadow: 1px 1px 5px 0px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 1px 1px 5px 0px rgba(0, 0, 0, 0.75);
    margin-right: 10px;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
}
.chat-box-header {
    height: 100px;
    display: flex;
    border-bottom: 1px solid #eaeef3;
}
.chat-box-content {
    background-color: #eaeef3;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.chat-box-footer {
    margin-bottom: 5px;
    margin-top: 5px;
    text-align: center;
}
.chat-box-footer b {
    font-size: 10px;
    color: gray;
}
.user-name {
    margin-inline-end: 0;
    margin-bottom: 0;
}
.online-status {
    margin: 0;
}
.message-preview {
    flex: 1;
    padding: 10px;
    max-height: 54vh;
    overflow-y: scroll;
}
.message-input-container input {
    width: 100%;
    height: 40px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    color: #495057;
}
.message-item {
    background-color: white;
    padding: 5px;
    font-size: 14px;
    margin-bottom: 10px;
}
.message-item-left {
    border-radius: 10px 10px 10px 0px;
    margin-right: 30px;
}
.message-item-right {
    border-radius: 10px 10px 0px 10px;
    margin-left: 30px;
}
</style>

<template>
    <div class="chat-button-container">
        <button
            class="chat-button round-button"
            @click="onChatBoxOpenBtnClick"
            id="chatOpenBtn"
            v-if="!chatBoxOpen"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                height="1em"
                viewBox="0 0 512 512"
                fill="currentColor"
            >
                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path
                    d="M160 368c26.5 0 48 21.5 48 48v16l72.5-54.4c8.3-6.2 18.4-9.6 28.8-9.6H448c8.8 0 16-7.2 16-16V64c0-8.8-7.2-16-16-16H64c-8.8 0-16 7.2-16 16V352c0 8.8 7.2 16 16 16h96zm48 124l-.2 .2-5.1 3.8-17.1 12.8c-4.8 3.6-11.3 4.2-16.8 1.5s-8.8-8.2-8.8-14.3V474.7v-6.4V468v-4V416H112 64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H448c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H309.3L208 492z"
                />
            </svg>
        </button>

        <!-- chat box -->
        <div v-if="chatBoxOpen" class="chat-container">
            <div class="chat-box-header">
                <div>
                    <div class="chat-button round-button">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="1em"
                            viewBox="0 0 512 512"
                            fill="currentColor"
                            style="margin-top: 7px"
                        >
                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M160 368c26.5 0 48 21.5 48 48v16l72.5-54.4c8.3-6.2 18.4-9.6 28.8-9.6H448c8.8 0 16-7.2 16-16V64c0-8.8-7.2-16-16-16H64c-8.8 0-16 7.2-16 16V352c0 8.8 7.2 16 16 16h96zm48 124l-.2 .2-5.1 3.8-17.1 12.8c-4.8 3.6-11.3 4.2-16.8 1.5s-8.8-8.2-8.8-14.3V474.7v-6.4V468v-4V416H112 64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H448c35.3 0 64 28.7 64 64V352c0 35.3-28.7 64-64 64H309.3L208 492z"
                            />
                        </svg>
                    </div>
                </div>
                <div style="flex: 1">
                    <h2 class="user-name">ChatBot</h2>
                    <h5 class="online-status">Online</h5>
                </div>
                <div>
                    <button
                        @click="onChatBoxCloseBtnClick"
                        class="round-button"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="1em"
                            viewBox="0 0 384 512"
                        >
                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"
                            />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="chat-box-content">
                <div class="message-preview" v-chat-scroll>
                    <div
                        v-for="msg in messages"
                        class="message-item"
                        :class="{
                            'message-item-right': msg?.sender == 0,
                            'message-item-left': msg?.sender == 1,
                        }"
                    >
                        {{ msg?.message }}
                    </div>
                </div>
                <div class="message-input-container">
                    <input
                        type="text"
                        placeholder="Ask something here.."
                        v-model="message"
                        @keyup.enter="onSendMessage"
                    />
                </div>
            </div>
            <div class="chat-box-footer">
                <b
                    >Powered by
                    <a href="https://connectnow.ai" target="_blank"
                        >ConnectNow</a
                    ></b
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "chatBot",
    mounted() {
        console.log("Chat bot mounted...");
    },
    data() {
        return {
            chatBoxOpen: false,
            message: "",
            messages: [],
        };
    },
    methods: {
        onChatBoxOpenBtnClick() {
            this.chatBoxOpen = true;
            if (this.messages.length == 0) {
                setTimeout(() => {
                    this.messages.push({
                        message: "Hi, How can i help you?",
                        sender: 1,
                    });
                }, 500);
            }

            console.log("chat box open");
        },
        onChatBoxCloseBtnClick() {
            this.chatBoxOpen = false;
        },
        onSendMessage() {
            if (!this.message) {
                return;
            }
            this.messages.push({ message: this.message, sender: 0 });
            this.message = "";
            setTimeout(() => {
                this.messages.push({
                    message:
                        "Thank you for contacting us. We will get back to you soon..",
                    sender: 1,
                });
            }, 500);
        },
    },
};
</script>
