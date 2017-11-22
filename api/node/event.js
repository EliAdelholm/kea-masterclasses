var event = {}

event.addEvents = ( aEvents, fcallback ) => {
    global.db.collection('events').insertOne( aEvents , ( err ) => {
      if( err ){
        var jError = { "status":"error","message":"ERROR -> event.js -> 001" }
        console.log( jError )
        return fcallback( true , jError )
      }
      var jOk = { "status":"ok","message":"event.js -> saved -> 000" }
      console.log( jOk )
      return fcallback( false , jOk )
    })
  }

  module.exports = event