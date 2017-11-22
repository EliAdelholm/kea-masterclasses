var express = require('express')
var app = express()
var formidable = require('express-formidable');
app.use(formidable());


// GET EVENT CONTROLLER
var event = require( __dirname+ '/event.js')


// CONNECT TO DATABASE
var mongo = require('mongodb').MongoClient
global.db = null
var sDatabasePath = 'mongodb://localhost:27017/masterclases'

mongo.connect( sDatabasePath , ( err , db) => {
  if( err ){
    console.log('ERROR 003 -> Cannot connect to the database')
    return false
  }
  global.db = db
  console.log('OK 002 -> Connected to the database')
  return true
})


///////////// ROUTING //////////////

// GET ALL EVENTS
app.get( '/get-events' , ( req , res ) => {
    
      event.getEvents( jUser , ( err , jStatus ) => {
        if( err ){
          console.log( jStatus )
          res.send('<html><body>ERROR</body></html>')
          return
        }
        console.log( jStatus )
        res.send('<html><body>OK<br/>User <b>' + jUser.name + ' ' + jUser.lastName + ', ' + jUser.age + '</b> saved</body></html>')
        
        // Set userName for later use
        sUserName = jUser.name;
        console.log(sUserName)
        return
      })
    })


// START SERVER
app.listen( 3333 , ( err )=>{
  if( err ){
    console.log('ERROR 001 -> Cannot listen to port 3333')
    return false
  }
  console.log('OK 000 -> Server listening to port 3333')
})