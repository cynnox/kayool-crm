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
.message-input-container {
    display: flex;
}
.message-input-container input {
    width: 100%;
    height: 40px;
    border: 1px solid #ced4da;
    /* border-radius: 0.25rem; */
    color: #495057;
    flex: 1;
    border-right: 0;
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
.send-msg-button {
    color: grey;
    height: 40px;
    width: 40px;
    border: none;
    cursor: not-allowed;
    font-size: 17px;
    border: 1px solid #ced4da;
    border-left: 0;
    background-color: white;
}
.send-msg-button.enabled {
    color: #299d8f;
    cursor: pointer;
}
.loader {
    width: 30px; /* control the size */
    aspect-ratio: 8/5;
    --_g: no-repeat radial-gradient(#000 68%, #0000 71%);
    -webkit-mask: var(--_g), var(--_g), var(--_g);
    -webkit-mask-size: 25% 40%;
    background: black;
    animation: load 2s infinite linear;
    transition: 500ms;
}

@keyframes load {
    0% {
        -webkit-mask-position: 0% 100%, 50% 0%, 100% 0%;
    }
    /* 16.67% {
        -webkit-mask-position: 0% 100%, 50% 0%, 100% 0%;
    }
    33.33% {
        -webkit-mask-position: 0% 100%, 50% 100%, 100% 0%;
    } */
    50% {
        -webkit-mask-position: 0% 0%, 50% 100%, 100% 100%;
    }
    /* 66.67% {
        -webkit-mask-position: 0% 0%, 50% 100%, 100% 100%;
    }
    83.33% {
        -webkit-mask-position: 0% 0%, 50% 0%, 100% 100%;
    } */
    100% {
        -webkit-mask-position: 0% 100%, 50% 0%, 100% 0%;
    }
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
                        <div v-if="msg?.message">{{ msg?.message }}</div>
                        <div v-if="!msg?.message" class="loader"></div>
                    </div>
                </div>
                <div class="message-input-container">
                    <input
                        type="text"
                        placeholder="Ask something here.."
                        v-model="message"
                        @keyup.enter="onSendMessage"
                    />
                    <button
                        class="send-msg-button"
                        @click="onSendMessage"
                        :class="{
                            enabled: message,
                        }"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="1em"
                            viewBox="0 0 512 512"
                            fill="currentColor"
                        >
                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480V396.4c0-4 1.5-7.8 4.2-10.7L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4z"
                            />
                        </svg>
                    </button>
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
            let msg = {
                message: "",
                sender: 1,
            };
            setTimeout(() => {
                this.messages.push(msg);
                setTimeout(() => {
                    msg.message =
                        "Thank you for contacting us. We will get back to you soon..";
                }, 2000);
            }, 100);
        },
    },
};
</script>
