const io = require('socket.io')(3000)

const users = {}

io.on('connection', socket => {
  socket.on('new-user', user => {
    socket.broadcast.emit('user-connected', user)
  })

  socket.on('send-private-message', data => {
    const { message, senderId, recipientId } = data
    const roomName = `${senderId}-${recipientId}` // generate a unique room name based on user IDs
    socket.to(roomName).emit('private-message', { message, name: users[senderId].name })

    // create the chat room if it doesn't already exist
    if (!io.sockets.adapter.rooms.has(roomName)) {
      socket.join(roomName)
    }
  })
})

io.on('connection', socket => {
  socket.on('new-user', name => {
    users[socket.id] = name
    socket.broadcast.emit('user-connected', name)
  })

  socket.on('send-chat-message', message => {
    socket.broadcast.emit('chat-message', { message: message, name: users[socket.id] })

  })
  socket.on('disconnect', () => {
    socket.broadcast.emit('user-disconnected', users[socket.id])
    delete users[socket.id]
  })
})