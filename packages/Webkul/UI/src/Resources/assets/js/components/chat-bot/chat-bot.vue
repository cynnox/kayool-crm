<style>
.chat-button-container {
    position: fixed;
    z-index: 1000;
    bottom: 15px;
    right: 10px;
}
.chat-button-container button{
        border: none;
    background-color: transparent;
}
.round-button {
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 100%;
    cursor: pointer;
    height: 50px;
    width: 50px;
    font-size: 20px;
}
.button-shadow {
    box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.75);
    -webkit-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.75);
}
.bubble-text-animation {
    position: relative;
    animation: bubble 1s infinite linear;
}
@keyframes bubble {
    50% {
        font-size: 25px;
    }
}
.chat-button {
    color: white;
    background-color: #299d8f;
}
.chat-container {
    min-height: 300px;
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
.badge {
    color: white;
    background-color: #e02323;
    height: 20px;
    min-width: 20px;
    border-radius: 100%;
    font-size: 13px;
    position: absolute;
    top: 0px;
    right: 0px;
    font-weight: bold;
}
.chat-box-header {
    height: 100px;
    display: flex;
    border-bottom: 1px solid #eaeef3;
}
.chat-box-header .chat-button{
    margin: 15px;
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
    flex: 1 1 0;
    padding: 10px;
    overflow-y: scroll;
}
.message-input-container {
    display: flex;
    border: 1px solid #ced4da !important;
    border-left: 0;
    border-right: 0;
    background-color: #fff;
}
.message-input-container input {
    width: 100%;
    height: 40px;
    border-radius: 0;
    color: #495057;
    flex: 1;
    border: none;
}
.message-item {
    background-color: white;
    padding: 5px;
    font-size: 14px;
    margin-bottom: 5px;
}
.message-item img {
    object-fit: contain;
    width: 100%;
    border-radius: 3px;
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
    cursor: not-allowed;
    font-size: 17px;
    margin-right: 5px;
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
.close-button{
    color: black;font-weight: bold; 
    font-size: 20px;
}

</style>

<template>
    <div class="chat-button-container">
        <button
            @click="onChatBoxOpenBtnClick"
            id="chatOpenBtn"
            v-if="!chatBoxOpen"
        >
            <div class="chat-button round-button button-shadow" :class="{ 'bubble-text-animation': !chatBoxOpened }">
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
                <span v-if="!chatBoxOpened" class="badge">1</span>
            </div>
        </button>

        <!-- chat box -->
        <div v-if="chatBoxOpen" class="chat-container" :style="{ height: chatBoxHeight }">
            <!-- header -->
            <div class="chat-box-header">
                <div class="chat-button round-button">
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
                </div>

                <div style="flex: 1">
                    <h2 class="user-name">ChatBot</h2>
                    <h5 class="online-status">Online</h5>
                </div>
                <div>
                    <button
                        @click="onChatBoxCloseBtnClick"
                        class="round-button close-button"
                    >
                    &#x2715
                    </button>
                </div>
            </div>
            <!-- messages -->
            <div class="chat-box-content">
                <div class="message-preview" v-chat-scroll>
                    <div
                        v-for="msg in messages"
                        class="message-item"
                        :class="{
                            'message-item-right': msg.sender == 0,
                            'message-item-left': msg.sender == 1,
                        }"
                    >
                        <div v-if="msg.message">{{ msg.message }}</div>
                        <div v-if="msg.image">
                            <img v-bind:src="msg.image" />
                        </div>
                        <div
                            v-if="!(msg.message || msg.image)"
                            class="loader"
                        ></div>
                    </div>
                </div>
                <div class="message-input-container">
                    <input
                        type="text"
                        placeholder="Ask something here.."
                        v-model="message"
                        @keyup.enter="onSendMessage"
                        v-on:focus="adjustDialogHeight"
                        v-on:blur="adjustDialogHeight"
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
            <!-- footer -->
            <div class="chat-box-footer">
                <b
                    >Powered by
                    <a href="https://www.kayool.com" target="_blank"
                        >Kayool</a
                    ></b
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ChatBot",
    mounted() {
        console.log("Chat bot mounted...");
        // fetch("/admin/api/dashboard/user", {
        //     method: "GET",
        //     headers: {
        //         "X-CSRF-TOKEN": document.head.querySelector(
        //             'meta[name="csrf-token"]'
        //         ).content,
        //     },
        // })
        //     .then((res) => res.json())
        //     .then((data) => {
        //         console.log(data);
        //     })
        //     .catch((err) => console.error(err));

        // Listen for the keyboard open event
        window.addEventListener('resize', this.adjustDialogHeight.bind(this));
    },
    destroyed() {
        console.log('chatbot destroyed');
         window.removeEventListener('resize', this.adjustDialogHeight.bind(this));
    },
    data() {
        return {
            chatBoxOpen: false,
            message: "",
            messages: [],
            chatBoxOpened: false,
            chatBoxHeight: `calc(${window.innerHeight}px * 0.80)`,
        };
    },
    methods: {
        onChatBoxOpenBtnClick() {
            this.chatBoxOpen = true;
            this.chatBoxOpened = true;
            if (this.messages.length == 0) {
                setTimeout(() => {
                    this.messages.push({
                        message: "Hi, How can i help you?",
                        sender: 1,
                        image: "",
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
            let req = {
                sender: "test_user_8",
                message: this.message,
                metadata: {},
            };
            this.messages.push({ message: this.message, sender: 0, image: "" });
            this.message = "";
            setTimeout(() => {
                let msg = {
                    message: "",
                    sender: 1,
                };
                this.messages.push(msg);
                fetch("https://chat.kayool.com/webhooks/rest/webhook", {
                    method: "POST",
                    body: JSON.stringify(req),
                })
                    .then((res) => res.json())
                    .then((data) => {
                        console.log(data);
                        if (data.length > 0) {
                            for (let index = 0; index < data.length; index++) {
                                const m = data[index];
                                if (index == 0) {
                                    msg.message = m.text;
                                    msg.image = m.image;
                                } else {
                                    this.messages.push({
                                        message: m.text,
                                        sender: 1,
                                        image: m.image,
                                    });
                                }
                            }
                        } else {
                            msg.message =
                                "Sorry, I don’t have a data source related to your question or request. I am still under development , but I am learning new things every day. I hope that we can have many interesting and informative conversations in the future.";
                        }
                    })
                    .catch((err) => {
                        console.error(err);
                        msg.message =
                            "Sorry, I don’t have a data source related to your question or request. I am still under development , but I am learning new things every day. I hope that we can have many interesting and informative conversations in the future.";
                    });
            }, 100);
        },
        adjustDialogHeight() {
            // Calculate the available space for the dialog (subtract keyboard height)
            this.chatBoxHeight = `calc(${window.innerHeight}px * 0.80)`;
        }
    },
};
</script>
