var express = require('express')
var app = express()
var formidable = require('express-formidable')
var path = require('path')
var fs = require('fs-extra')
var os = require('os')
app.use(formidable())

// ALLOW CROSS ORIGIN RESSOURCE SHARING
app.use(function (req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
});


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
app.post('/create-event', (req, res) => {


    // Check file extension if any
    var extName = path.extname(req.files.sFile.name)

    if ( ['.png', '.jpg', '.jpeg'].includes(extName) ) {
        console.log("Valid image was uploaded")

        // Handle image upload
        // Get temporary file path
        var tempPath = req.files.sFile.path

        // Generate new path, using timestamp to avoid duplication errors
        var timestamp = + new Date()
        var imagePath = "assets/img/" + timestamp + extName

        // Handle OS file system differences
        if (os.platform() == 'linux') {
            // File path for linux users
            var targetPath = path.resolve('app/' + imagePath)
        } else {
            // For windows n00bs
            var targetPath = path.resolve('../../app/' + imagePath)
        }

        // Actually move the file to permanent storage
        fs.move(tempPath, targetPath, function(err) {
            if (err) throw err;
            console.log("Upload completed!");
        });
        
    } else {
        console.log("No valid image")
        // Set the path for default image
        imagePath = "assets/img/userimage-5a1d3bce0ad1d.png";
    }

    // Create object from form data
    var jEvent = {
        "title": req.fields.sTitle,
        "type": req.fields.sType,
        "location": {
            "type": "Point",
            "address": req.fields.sAddress,
            "coordinates": [req.fields.sLat, req.fields.sLng],
            "room": req.fields.sRoom
        },
        "date": req.fields.sDate,
        "time": req.fields.sTime,
        "speaker": req.fields.sLecturer,
        "organizer": req.fields.sResponsible,
        "status": "pending",
        "image": imagePath,
        "clickrate": 0,
        "description": req.fields.sDescription,
        "requirements": req.fields.sRequirements
    }
    
    console.log(jEvent)
    
    event.createEvent(jEvent, (err, jStatus) => {
        if (err) {
            console.log(jStatus)
            res.send('{"status": "error"}')
            return
        }
        console.log(jStatus)
        res.send('{"status": "ok"}')
        return
    })
})

// UPDATE EVENT
app.post('/update-event', (req, res) => {
    var jEvent = {
        "id": req.query.id
        // Add all fields to update
    }
    event.updateEvent(jEvent, (err, jStatus, jEvent) => {
        if (err) {
            console.log(jStatus)
            res.send('<html><body>ERROR</body></html>')
            return
        }
        console.log(jStatus, jEvent)
        res.send('<html><body>OK</body></html>')
        return
    })
})


// DELETE EVENT
app.get('/delete-event', (req, res) => {
    var iEventId = req.query.id
    event.deleteEvent(iEventId, (err) => {
        if (err) {
            console.log(iEventId)
            res.send('<html><body>ERROR</body></html>')
            return
        }
        console.log('DELETED EVENT WITH ID', iEventId)
        res.send('<html><body>OK</body></html>')
        return
    })
})

//DISPLAY ALL EVENTS
app.get('/events', (req, res) => {
    event.getEvents((err, jStatus, ajEvents) => {
        if (err) {
            console.log(jStatus)
            res.send('<html><body>ERROR</body></html>')
            return
        }
        console.log(jStatus)
        var ajEventsNiceView = JSON.stringify(ajEvents, null, 4)
        res.send(ajEventsNiceView)
        return
    })
})

//DISPLAY EVENT BY ID
app.get('/event/:id', (req, res) => {
 //console.log("req ", req);
    var iEventId = req.params.id
    //console.log("iEventId ", iEventId)

    event.displayEventById(iEventId, (err, jStatus, jEvent) => {
        if (err) {
            console.log(jStatus)
            res.send('<html><body>ERROR</body></html>')
            return
        }
        console.log(jStatus, jEvent)
        var jEventNiceView = "<pre><code>" + JSON.stringify(jEvent, null, 4) + "</code></pre>"
        res.send(jEventNiceView)
        return
    })
})

///////////// CREATE INDEX FOR TYPE OF EVENT //////////////

// CURRENTLY WE ARE NOT ACTUALLY USING THIS BUT IT'S A REQUIREMENT FOR THE ASSIGNMENT

// iF WE WANT TO QUERY FOR ALL THE EVENTS OF A CERTAIN TYPE IN THE FUTURE IT WILL BE USEFUL

var indexByType = function (fCallback) {
    global.db.collection('events').createIndex(
        // type 1 is an ascending index, type -1 is a descending index
        { "type": 1 },
        null,
        (err, jResult) => {
            if (err) {
                console.log('err ' + err)
                return fCallback(false);
            }
            console.log(jResult);
            return fCallback(true);
        }
    );
};

// GO TO THIS ROUTE TO CREATE THE INDEX
app.get('/index-events', (req,res) => {
    
    indexByType((err) => {
        if (err) {
            console.log("Indexed collection 'events' by type")
            return
        }
            console.log("Collection 'events' indexed by type")
            return
    });
  
});

/*****************************************************************/

// START SERVER
app.listen(3333, (err) => {
    if (err) {
        console.log('ERROR 001 -> Cannot listen to port 3333')
        return false
    }
    console.log('OK 000 -> Server listening to port 3333')
})