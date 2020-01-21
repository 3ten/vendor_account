var app = require('express')();
//var http = require('http').createServer(app);
var server = app.listen(3030);
var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis();

redis.psubscribe('chat-channel.*');
redis.on('pmessage', (pattern, channel, message) => {
    console.log('Message recieved: ' + message);
    console.log('Channel: ' + channel);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});


