<template>
    <div>
        <div v-if="loading">
            <b-spinner></b-spinner>
        </div>
        <div class="messaging">
  			<div class="inbox_msg">
				<div class="inbox_people">
	  				<div class="headind_srch">
						<div class="recent_heading">
		  					<h4>Recent</h4>
						</div>
						<div class="srch_bar">
		  					<div class="stylish-input-group">
								<input type="text" class="search-bar"  placeholder="Search">
							</div>
						</div>
	  				</div>
	  				<div class="inbox_chat scroll">
						<div :key="user.id" v-for="user in users" class="chat_list" v-on:click="getOldMessages(user.id)" v-bind:id="user.id"> <!-- active_chat -->
		  					<div class="chat_people">
								<div class="chat_img">
									<img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
								</div>
								<div class="chat_ib">
			  						<h5>{{user.name}}<span class="chat_date"><!-- Dec 25 --></span></h5>
									<p>
									<!-- Test, which is a new approach to have all solutions astrology under one roof. -->
									</p>
								</div>
		  					</div>
						</div>
					</div>
				</div>
				<div class="mesgs">
	  				<div id="chat" class="msg_history">
          				<div :key="message.id" v-for="message in messages" v-bind:class="{ 'incoming_msg': message.incoming, 'outgoing_msg': !(message.incoming) }">
                			<div v-if="message.incoming" class="incoming_msg_img">
								<img src="https://ptetutorials.com/images/user-profile.png" v-bind:alt="message.name">
							</div>
							<div v-if="message.incoming" class="recieved_msg">
								<div class="received_withd_msg">
									<p>
										{{ message.message }}
									</p>
									<span class="time_date"> {{ message.time }}   |    {{ message.date }} </span>
								</div>
							</div>
							<div v-if="!message.incoming" class="sent_msg">
								<p>
									{{ message.message }}
								</p>
								<span class="time_date"> {{ message.time }}   |    {{ message.date }} </span>
							</div>
          				</div>
				 	</div>
	  				<div class="type_msg">
						<form @submit.prevent="sendMessage" class="input_msg_write">
		  					<input v-model="message" type="text" class="write_msg" placeholder="Type a message">
		  					<button v-on:click="sendMessage" class="msg_send_btn" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
          					<input type="submit" value="" hidden> 
        				</form>
	  				</div>
				</div>
  			</div>
		</div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: "",
            newMessage: {
                sender_id: null,
                receiver_id: null,
                sender_name: "",
                receiver_name: "",
                message: "",
                incoming: false,
            },
            messages: [],
            oldMessages: [],
            users: [],
            currentUserId: 0,
            selectedUser: 0,
            loading: false,
        }
    },
    created() {
        this.messages.join('\n');
        this.update();
    },
    mounted() {
        var socket = io('http://192.168.11.145:3030');
        var app = this;
        
        socket.on("chat-channel." + this.$auth.user().id + ":App\\Events\\NewMessage", (data) => {
            let scroll = this.$el.querySelector("#chat").scrollHeight;
            this.newMessage = data.message;
            if (this.newMessage.sender_id === this.$auth.user().id) this.newMessage.incoming = false;
            else this.newMessage.incoming = true;
            this.messages.push(this.newMessage);
            this.message = "";
            if (scroll == this.$el.querySelector("#chat").scrollTop) setTimeout(() => {this.scrollToEnd();}, 300);
            else console.log("aaa");
        });
    },
    methods: {
        update() {
            this.loading = true;
            axios.post('/getRelations', {user: this.$auth.user()}).then((response) => {
                this.loading = false;
                this.users = response.data.users;
                console.dir(response.data.users);
            });
        },
        sendMessage() {
            // axios.post('/saveMessage', {message: this.message, sender_id: this.$auth.user().id, receiver_id: this.selectedUser}).then((response) => {
            //     console.log(response.data.status);
            // });
            axios.post('/sendChatMessage', {channel: 'chat-channel.' + this.selectedUser, message: this.message, sender_id: this.$auth.user().id, receiver_id: this.selectedUser}).then((response) => {
                this.newMessage = response.data.message;
                if (this.newMessage.sender_id === this.$auth.user().id) this.newMessage.incoming = false;
                else this.newMessage.incoming = true;
                this.messages.push(this.newMessage);
                this.message = "";
            }).finally(() => {
                this.scrollToEnd();
            });
            // setTimeout(() => {
            //     this.scrollToEnd();
            // }, 1000);
        },
        getOldMessages(selectedUser) {
            if (this.selectedUser === selectedUser) return;
            this.messages = [];
            if (this.selectedUser) document.getElementById(this.selectedUser).className = 'chat_list';
            this.selectedUser = selectedUser; 
            document.getElementById(this.selectedUser).className = 'chat_list active_chat';
            //if (selectedUser === 0) return;
            console.log(this.selectedUser);
            if (this.$auth.user().role === 0) {
                axios.post('/getOldMessages', {shop_id: this.$auth.user().id, vendor_id: this.selectedUser}).then((response) => {
                    this.oldMessages = response.data.messages;
                    this.oldMessages.forEach(oldMessage => {
                        this.newMessage = oldMessage;
                        if (this.newMessage.sender_id === this.$auth.user().id) this.newMessage.incoming = false;
                        else this.newMessage.incoming = true;
                        this.messages.push(this.newMessage);
                    });
                }).finally(() => {
                    this.scrollToEnd();
                });
            }
            else {
                axios.post('/getOldMessages', {shop_id: this.selectedUser, vendor_id: this.$auth.user().id}).then((response) => {
                    this.oldMessages = response.data.messages;
                    this.oldMessages.forEach(oldMessage => {
                        this.newMessage = oldMessage;
                        if (this.newMessage.sender_id === this.$auth.user().id) this.newMessage.incoming = false;
                        else this.newMessage.incoming = true;
                        this.messages.push(this.newMessage);
                    });
                }).finally(() => {
                    this.scrollToEnd();
                });
            }
            // setTimeout(() => {
            //     this.scrollToEnd();
            // }, 1000);
        },
        scrollToEnd() {    	
            var container = this.$el.querySelector("#chat");
            container.scrollTop = container.scrollHeight;
        },
    },
    computed: {
        getMessages() {
            return this.messages.join('\n');
        },
        chatList() {
            return {
                'chat_list': true,
                'active_chat': this.selectedUser === this.selectedUserId,
            }
        },
    }
}
</script>

<style scoped>
.container{
    max-width:900px;
}
.inbox_people {
	background: #fff;
	float: left;
	overflow: hidden;
	width: 30%;
	border-right: 1px solid #ddd;
}

.inbox_msg {
	border: 1px solid #ddd;
	clear: both;
	overflow: hidden;
}

.top_spac {
	margin: 20px 0 0;
}

.recent_heading {
	float: left;
	width: 40%;
}

.srch_bar {
	display: inline-block;
	text-align: right;
	width: 60%;
	padding: 0;
}

.headind_srch {
	padding: 10px 29px 10px 20px;
	overflow: hidden;
	border-bottom: 1px solid #c4c4c4;
}

.recent_heading h4 {
	color: #0465ac;
    font-size: 16px;
    margin: auto;
    line-height: 29px;
}

.srch_bar input {
	outline: none;
	border: 1px solid #cdcdcd;
	border-width: 0 0 1px 0;
	width: 80%;
	padding: 2px 0 4px 6px;
	background: none;
}

.srch_bar .input-group-addon button {
	background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
	border: medium none;
	padding: 0;
	color: #707070;
	font-size: 18px;
}

.srch_bar .input-group-addon {
	margin: 0 0 0 -27px;
}

.chat_ib h5 {
	font-size: 15px;
	color: #464646;
	margin: 0 0 8px 0;
}

.chat_ib h5 span {
	font-size: 13px;
	float: right;
}

.chat_ib p {
    font-size: 12px;
    color: #989898;
    margin: auto;
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chat_img {
	float: left;
	width: 11%;
}

.chat_img img {
	width: 100%
}

.chat_ib {
	float: left;
	padding: 0 0 0 15px;
	width: 88%;
}

.chat_people {
	overflow: hidden;
	clear: both;
}

.chat_list {
	border-bottom: 1px solid #ddd;
	margin: 0;
	padding: 18px 16px 10px;
}

.inbox_chat {
	height: 550px;
	overflow-y: scroll;
}

.active_chat {
	background: #e8f6ff;
}

.incoming_msg_img {
	display: inline-block;
	width: 6%;
}

.incoming_msg_img img {
	width: 100%;
}

.received_msg {
	display: inline-block;
	padding: 0 0 0 10px;
	vertical-align: top;
	width: 92%;
}

.received_withd_msg p {
	background: #ebebeb none repeat scroll 0 0;
	border-radius: 0 15px 15px 15px;
	color: #646464;
	font-size: 14px;
	margin: 0;
	padding: 5px 10px 5px 12px;
	width: 100%;
}

.time_date {
	color: #747474;
	display: block;
	font-size: 12px;
	margin: 8px 0 0;
}

.received_withd_msg {
	width: 57%;
}

.mesgs{
	float: left;
	padding: 30px 15px 0 25px;
	width:70%;
}

.sent_msg p {
	background:#0465ac;
	border-radius: 12px 15px 15px 0;
	font-size: 14px;
	margin: 0;
	color: #fff;
	padding: 5px 10px 5px 12px;
	width: 100%;
}

.outgoing_msg {
	overflow: hidden;
	margin: 26px 0 26px;
}

.sent_msg {
	float: right;
	width: 46%;
}

.input_msg_write input {
	background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
	border: medium none;
	color: #4c4c4c;
	font-size: 15px;
	min-height: 48px;
	width: 100%;
	outline:none;
}

.type_msg {
	border-top: 1px solid #c4c4c4;
	position: relative;
}

.msg_send_btn {
	background: #05728f none repeat scroll 0 0;
	border:none;
	border-radius: 50%;
	color: #fff;
	cursor: pointer;
	font-size: 15px;
	height: 33px;
	position: absolute;
	right: 0;
	top: 11px;
	width: 33px;
}

.messaging {
	padding: 0 0 50px 0;
}

.msg_history {
	height: 516px;
	overflow-y: auto;
}
</style>