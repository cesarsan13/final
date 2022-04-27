const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const { message } = require('laravel-mix/src/Log');
const { Console } = require('console');
const bcrypt = require('bcrypt');
const app = express();
//conexion
const connection = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'laravel'
});
connection.getConnection(function (err, connection) {
    if (err) {
        connection.release();
        return;
    }
});
// connection.query("Select * from users ",function(err,rows){
//     console.log(rows);
// });
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*" }
});
io.on("connection", (socket) => {
    // var address = socket.handshake.address;
    // console.log(address);
    // app.get('/prueba',(req,res)=>{
    //     socket.broadcast.emit('autorizar');
    // });
    socket.on('sendToServer', (message) => {
        console.log(message);
        // io.sockets.emit('sendToClient', (message));
        socket.broadcast.emit('sendToClient', message);
    });
    socket.on('sendToServer', (message) => {
        console.log(message);
        // io.sockets.emit('sendToClient', (message));
        socket.broadcast.emit('sendToClient', message);
    });
    socket.on('login', (params) => {
        const parametros = JSON.parse(params);
        let { password, user } = parametros;
        // console.log(user,password)
        let decodeUser = Buffer.from(user.toString('utf8'), 'base64').toString('ascii');
        let decodePass = Buffer.from(password.toString('utf8'), 'base64').toString('ascii');
        let tsql = "Select * from users where email='" + decodeUser + "';";
        // console.log(decodeUser)
        // console.log(tsql)
        connection.query(tsql, async function (err, rows) {
            if (err) {
                console.log(err.message)
                return;
            }
            let res = false;
            if (rows[0]) {
                let { id, email, name, password } = rows[0];
                let finalpass = password.replace('$2y$', '$2a$')
                res = await bcrypt.compare(decodePass, finalpass);
            }else{
                res = false;
            }
            socket.emit('isAuth', res );
        });
    });
    socket.on('autorizar', () => {
        console.log('Precionamos el boton si');
    });
    socket.on('noautorizar', () => {
        console.log('Precionamos el boton no');
    });
    socket.on('disconnect', (socket) => {
        console.log('desconectado');
    });
});
server.listen(3000, () => {
    console.log('server web socket corriendo');
});
