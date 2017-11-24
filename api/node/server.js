var express = require('express')
var app = express()
var formidable = require('express-formidable')
app.use(formidable())


// GET EVENT CONTROLLER
var event = require(__dirname + '/event.js')


// CONNECT TO DATABASE
var mongo = require('mongodb').MongoClient
global.db = null
var sDatabasePath = 'mongodb://localhost:27017/masterclasses'

mongo.connect(sDatabasePath, (err, db) => {
    if (err) {
        console.log('ERROR 003 -> Cannot connect to the database')
        return false
    }
    global.db = db
    console.log('OK 002 -> Connected to the database')
    return true
})


///////////// ROUTING //////////////


// ADD EVENT
app.get('/create-event', (req, res) => {
    // Fake data from frontend
    var jEvent = {
            "title": "Photoshop art – retouching skills",
            "type": "UI",
            "location": {
                "type": "Point",
                "coordinates": [null, null],
                "room": "Tellus"
            },
            "time": "6 November at 13:30–15:00",
            "speaker": "Marie Christiansen",
            "organizer": "Jonas Fannikke Holbech",
            "status": "active",
            "image": "",
            "clickrate": 0,
            "description": "What is Photoshop art and what does it take? We are going to look at some art pieces made in Photoshop and discuss what it actually takes to produce a piece. We will demonstrate tools like the Liquify filter, Content-aware fill and discuss cut out techniques.",
            "requirements": "Basic Photoshop skills and an eagerness to get inspired"
        }

    event.createEvent(jEvent, (err, jStatus) => {
        if (err) {
            console.log(jStatus)
            res.send('<html><body>ERROR</body></html>')
            return
        }
        console.log(jStatus)
        res.send('<html><body>OK</body></html>')
        return
    })
})

// UPDATE EVENT

// DELETE EVENT
app.get('/delete-event',(req,res) =>{
    var iEventId = req.query.id
    event.deleteEvent(iEventId, ( err, iEventId ) => {
        if( err ){
          console.log( iEventId )
          res.send('<html><body>ERROR</body></html>')
          return
        }
        console.log( 'DELETED EVENT WITH ID', iEventId )
        res.send('<html><body>OK</body></html>')
        return
      }) 
})

//DISPLAY ALL EVENTS
app.get('/display-all-events', function (req, res) {
    event.getEvents( ( err , ajEvents )=>{
        if( err ) {
            console.log( err )
            console.log( ajEvents )
            res.send('<html><body>ERROR</body></html>')
            return
        }
        var ajEventsNiceView =  "<pre><code>"+ JSON.stringify(ajEvents, null, 4) +"</code></pre>"
        res.send( ajEventsNiceView )
        return
    })
    
})

//DISPLAY EVENT BY ID
app.get('/display-event',(req,res) =>{
    var iEventId = req.query.id
    event.displayEventById(iEventId, ( err, jEvent ) => {
        if( err ){
          console.log( iEventId )
          res.send('<html><body>ERROR</body></html>')
          return
        }
        var jEventNiceView =  "<pre><code>"+ JSON.stringify(jEvent, null, 4) +"</code></pre>"
        res.send( jEventNiceView )
        return
      }) 
})
/*****************************************************************/
// START SERVER
app.listen(3333, (err) => {
    if (err) {
        console.log('ERROR 001 -> Cannot listen to port 3333')
        return false
    }
    console.log('OK 000 -> Server listening to port 3333')
})