const http = require('http');
const WebSocket = require('ws');

// Configuración del servidor HTTP
const server = http.createServer();
const wss = new WebSocket.Server({ server });

// Manejo de conexiones
wss.on('connection', (ws) => {
    console.log('Cliente conectado');

    ws.on('message', (message) => {
        console.log('Mensaje recibido:', message);
    });

    ws.on('close', () => {
        console.log('Cliente desconectado');
    });
});

// Iniciar el servidor en el puerto 3001
server.listen(3001, () => {
    console.log('Servidor WebSocket escuchando en ws://localhost:3001');
});
