const express = require('express');
const app = express();
const server = require('http').createServer(app);
// const cors = require('cors');
// app.use(
//     cors({
//         origin: "http://localhost:8000",
//     })
// )
// const io = require('socket.io')(server);
const io = require('socket.io')(server, {
    cors: { 
        origin: "http://localhost:8000",
        methods: ["GET", "POST"],
        allowedHeaders: ["my-custom-header"],
        credentials: true
    },
    allowEIO3: true
});

var Redis = require('ioredis');
var redis = new Redis();

server.listen(8005, function () {
    console.log('Listening to port 8005');
});

redis.subscribe('private-channel', function() {
    console.log('subscribed to private channel');
});
// redis.subscribe('*', function(err, count) {
//     console.log('Subscribed');
// });


redis.on('message', function(channel, message) {
    message = JSON.parse(message);
    //console.log(channel);
    if (channel == 'private-channel') {
        let data = message.data.data;
        let event = message.event;
        console.log("in stock-upload-channel");
        console.log(channel + ':' + event);
        //console.log(event);
        io.emit("private", data);
    }
});


