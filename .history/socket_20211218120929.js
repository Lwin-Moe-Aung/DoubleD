var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
var users = [];
var groups = [];

http.listen(8005, function () {
    console.log('Listening to port 8005');
});

redis.subscribe('private-channel', function() {
    console.log('subscribed to private channel');
});

redis.subscribe('group-channel', function() {
    console.log('subscribed to group channel');
});

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    console.log(message);
    console.log(channel);
    console.log("lwin moe aung end");
    if (channel == 'private-channel') {
        //let data = message.data.data;
        //let receiver_id = data.receiver_id;
        //let event = message.event;
        console.log("in private-channel");
        //io.to(`${users[receiver_id]}`).emit(channel + ':' + message.event, data);
    }
});
