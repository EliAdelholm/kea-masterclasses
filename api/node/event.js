var ObjectId = require('mongodb').ObjectID
var event = {}
/******************** SAVE EVENT ****************/
event.createEvent = ( jEvent, fcallback ) => {
    global.db.collection('events').insertOne( jEvent , ( err ) => {
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

/******************** DELETE EVENT ****************/
event.removeCourse = (iEventId, fCallback) => {
  global.db.collection('events').deleteOne(
      {"_id" : ObjectId(iEventId)},

      function (err, results) {
        var jOk = { "status":"ok","message":"event.js -> deleted -> 002" }
        //console.log(results + " deleted")
        console.log(results + " deleted")
        var jError = {"status":"error","message":"ERROR -> event.js -> 003"}
        //console.log(err + " err")
        console.log(err + jError)
        return fCallback(err , iEventId)
      })

}

/******************** DISPLAY ALL EVENTS *************/
event.getEvents = ( fCallback ) => {
  // get the data from the collection events
  global.db.collection('events').find().toArray( ( err , ajEvents) =>{
      if( err ){
          var jError = {"status":"Can't Display Events","message":"ERROR -> event.js -> 005"}
          //var jError = (err, "Can't Display Events")
          console.log( jError )
          return fCallback( true , jError )
        }
        var jOk = { "status":"Displaying Events","message":"event.js -> Displaying Events -> 006" }
        //var jOk = ('Displaying Events')
        console.log( jOk, ajEvents )
        return fCallback( false , ajEvents )
  })
}

/******************** DISPLAY EVENT BY ID ************/
event.displayEventById = (iEventId, fCallback) => {
  global.db.collection('events').find({"_id": ObjectId(iEventId)}).toArray(( err , ajEvents) =>{
    if( err ){
        var jError = {"status":"Can't Display Event","message":"ERROR -> event.js -> 007"}
        //var jError = (err, "Can't Display Event")
        console.log( jError )
        return fCallback( true , jError )
      }
      if (ajEvents.length > 0 ){
        return fCallback( false , ajEvents[0])
      }
      else {
        return fCallback( false ,null)
      }
  })
}

  /**************************************************/
  module.exports = event