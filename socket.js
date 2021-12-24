const express = require('express');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { 
        // origin: "http://localhost:8000",
        origin: "http://18.183.164.200",
        methods: ["GET", "POST"],
        credentials: true
    },
    allowEIO3: true
});

var Redis = require('ioredis');
var redis = new Redis();

server.listen(8005, function () {
    console.log('Listening to port 8005');
});

redis.subscribe('stock-upload-channel', function() {
    console.log('subscribed to private channel');
});
redis.subscribe('tip-upload-channel', function() {
    console.log('subscribed to private channel');
});
// redis.subscribe('private-channel', function() {
//     console.log('subscribed to private channel');
// });

redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    if (channel == 'stock-upload-channel') {
        let data = message.data.data;
        let event = message.event;
        console.log(channel + ':' + event);
        //console.log(event);
        io.emit("private", data);
    }
    if (channel == 'tip-upload-channel') {
        let data = message.data.data;
        let event = message.event;
        console.log(channel + ':' + event);
        console.log(data);
        io.emit(channel, data);
    }
});

