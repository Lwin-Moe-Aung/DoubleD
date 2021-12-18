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
    console.log(channel);
   /*  if (channel == 'private-channel') {
        let data = message.data.data;
        let event = message.event;
        console.log("in stock-upload-channel");
        console.log(data);
        console.log(event);
        io.emit(channel + ':' + event, data);
    } */
});


