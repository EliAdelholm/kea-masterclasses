var express = require('express')
var app = express()
var formidable = require('express-formidable')
var path = require('path')
var fs = require('fs-extra')
var os = require('os')
var cors = require('cors')
app.use(formidable())

// GET CONTROLLERS
var event = require(__dirname + '/event.js')
var stats = require(__dirname + '/stats.js')

// ALLOW CROSS ORIGIN RESSOURCE SHARING
app.use(cors())

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

// DECLARE PENDING EVENT COUNT
var iPendingEventsCount = 0;




///////////// ROUTING //////////////

// ADD EVENT
app.post('/create-event', (req, res) => {

    // Check file extension if any
    var extName = path.extname(req.files.sFile.name)

    if (['.png', '.jpg', '.jpeg'].includes(extName)) {
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
        fs.move(tempPath, targetPath, function (err) {
            if (err) throw err;
            console.log("Upload completed!");
        });

    } else {
        console.log("No valid image")
        // Set the path for default image
        imagePath = "assets/img/default-event.jpg";
    }

    // Create object from form data
    var jEvent = {
        "title": req.fields.sTitle,
        "type": req.fields.sortType,
        "location": {
            "type": "Point",
            "address": req.fields.sAddress,
            "coordinates": [parseInt(req.fields.sLat), parseInt(req.fields.sLng)],
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
            return res.send('{"status": "error"}')
        }
        console.log(jStatus)
        iPendingEventsCount++
        return res.send('{"status": "ok"}')
    })
})

// UPDATE EVENT
app.post('/update-event', (req, res) => {
    var jEvent = {
        "_id": req.fields._id,
        "title": req.fields.eventTitle,
        "type": req.fields.eventType,
        "location": {
            "type": "Point",
            "address": req.fields.eventAddress,
            "coordinates": [parseInt(req.fields.sLat), parseInt(req.fields.sLng)],
            "room": req.fields.eventRoom
        },
        "date": req.fields.eventDate,
        "time": req.fields.eventTime,
        "speaker": req.fields.eventSpeaker,
        "organizer": req.fields.eventResponsible,
        "description": req.fields.eventDescription,
        "requirements": req.fields.eventRequirements
    }
    
    event.updateEvent(jEvent, (err, jStatus) => {
        if (err) {
            console.log(jStatus);
            return res.send('<html><body>ERROR</body></html>')
        }
        console.log(jStatus)
        return res.send('<html><body>OK</body></html>')
    })
})

// APPROVE EVENT
app.get('/approve-event/:id', (req, res) => {
    var iEventId = req.params.id

    event.approveEvent(iEventId, (err, jStatus) => {
        if (err) {
            console.log(jStatus)
            return res.json(jStatus)
        }
        console.log(jStatus)
        iPendingEventsCount--
        return res.json(jStatus)
    })
})

// DISSMISS EVENT
app.get('/dissmiss-event/:id', (req, res) => {
    var iEventId = req.params.id

    event.dissmissEvent(iEventId, (err, jStatus) => {
        if (err) {
            console.log(jStatus)
            return res.json(jStatus)
        }
        console.log(jStatus)
        iPendingEventsCount--
        return res.json(jStatus)
    })
})


// DELETE EVENT
app.get('/delete-event/:id', (req, res) => {
    var sEventId = req.params.id
    event.deleteEvent(sEventId, (err, jStatus) => {
        if (err) {
            console.log(sEventId)
            return res.send('<html><body>ERROR</body></html>')
        }
        console.log('DELETED EVENT WITH ID', sEventId)
        return res.send('<html><body>OK</body></html>')
    })
})

// GET ALL ACTIVE EVENTS
app.get('/events', (req, res, next) => {
    event.getActiveEvents((err, jStatus, ajEvents) => {
        if (err) {
            console.log(jStatus)
            return res.send('<html><body>ERROR</body></html>')
        }
        console.log(jStatus)
        var ajEventsNiceView = JSON.stringify(ajEvents, null, 4)
        return res.send(ajEventsNiceView)
    })
})

// GET ALL PENDING EVENTS
app.get('/pending-events', (req, res) => {
    event.getPendingEvents((err, jStatus, ajEvents) => {
        if (err) {
            console.log(jStatus)
            return res.send('<html><body>ERROR</body></html>')
        }
        console.log(jStatus)
        return res.json(ajEvents)
    })
})

// GET ALL PENDING EVENTS
app.get('/dissmissed-events', (req, res) => {
    event.getDissmissedEvents((err, jStatus, ajEvents) => {
        if (err) {
            console.log(jStatus)
            return res.send('<html><body>ERROR</body></html>')
        }
        console.log(jStatus)
        return res.json(ajEvents)
    })
})

// GET ALL EVENTS FROM CURRENT SEMESTER
app.get('/semester-events/:semester', (req, res) => {
    var sSemester = req.params.semester
    event.getSemesterEvents( sSemester, (err, jStatus, ajEvents) => {
        if (err) {
            console.log(jStatus)
            return res.send('<html><body>ERROR</body></html>')
        }
        console.log(jStatus)
        return res.json(ajEvents)
    })
})

//DISPLAY EVENT BY ID
app.get('/event/:id', (req, res) => {
    var iEventId = req.params.id
    event.displayEventById(iEventId, (err, jStatus, jEvent) => {
        if (err) {
            console.log(jStatus)
            return res.send('<html><body>ERROR</body></html>')
        }
        console.log(jStatus, jEvent)
        var jEventNiceView = JSON.stringify(jEvent, null, 4)
        return res.send(jEventNiceView)
    })
})


// CANCEL EVENT
app.get('/cancel-event/:id', (req, res) => {
    var sEventId = req.params.id
    event.cancelEvent(sEventId, (err, jStatus) => {
        if (err) {
            console.log(jStatus);
            return res.send('<html><body>ERROR</body></html>')   
        }
        console.log(jStatus);
        return res.send('<html><body>OK</body></html>')        
    });
})


///////// ROUTING FOR STATS OPERATIONS //////////

// INCREMENT EVENT CLICKRATE
app.get('/increment-clickrate/:id', (req,res) =>{
    var sEventId = req.params.id;
    stats.incrementClickrate(sEventId, (err, jStatus) => {
        if (err) {
            console.log(jStatus);
            return res.send('<html><body>ERROR</body></html>')
        }
        console.log(jStatus)
        return res.send('<html><body>OK</body></html>')
    })
});

// GET AVERAGE CLICKRATES PER EVENT TYPE
app.get('/average-clickrates', (req, res) => {
    stats.getClickratesByType((err, jAvgClickrates) => {
        if (err) {
            console.log("Indexed collection 'events' by type")
            return res.json({"status": "ERROR"})
        }
        return res.json(jAvgClickrates)
    });

});

// COUNT PENDING EVENTS
app.get('/count-pending-events', (req, res) => {
    if (iPendingEventsCount == 0) {
        stats.countPendingEvents((err, jStatus, iCount) => {
            if (err) {
                console.log(jStatus)
                return res.send('<html><body>ERROR</body></html>')
            } else {
                console.log(jStatus, iCount)
                iPendingEventsCount = iCount;
                return res.json(iCount)
            }
        })
    } else {
        return res.json(iPendingEventsCount);
    }
})

// COUNT ACTIVE EVENTS
app.get('/count-active-events', (req, res) => {
    stats.countActiveEvents((err, jStatus, iCount) => {
        if (err) {
            console.log(jStatus)
            return res.json(jStatus)
        } else {
            console.log(jStatus, iCount)
            return res.json(iCount)
        }
    })
})

// GET POPULAR EVENTS
app.get('/popular-events', (req, res) => {
    stats.getPopularEvents((err, jStatus, ajEvents) => {
        if (err) {
            console.log(jStatus)
            return res.send('<html><body>ERROR</body></html>')
        }
        console.log(jStatus)
        return res.json(ajEvents)
    })
})

///////////// CREATE INDEX FOR TYPE OF EVENT //////////////

// CURRENTLY WE ARE NOT ACTUALLY USING THIS BUT IT'S A REQUIREMENT FOR THE ASSIGNMENT

// iF WE WANT TO QUERY FOR ALL THE EVENTS OF A CERTAIN TYPE IN THE FUTURE IT WILL BE USEFUL

indexByType = (fCallback) => {
    // type 1 is an ascending index, type -1 is a descending index
    global.db.collection('events').createIndex( { status: 1 }, null, (err, jResult) => {
            if (err) {
                console.log('err ' + err)
                return fCallback(true);
            }
            console.log(jResult);
            return fCallback(false);
        }
    );
};

// GO TO THIS ROUTE TO CREATE THE INDEX
app.get('/index-events', (req, res) => {

    indexByType((err) => {
        if (err) {
            console.log("Indexed collection 'events' by type")
            return res.json({"status": "ERROR"})
        }
        console.log("Collection 'events' indexed by type")
        return res.json({"status": "OK"})
    });

});

// LOCATION
app.get("/user-location/:usersLat/:usersLng", (req, res) => {
    var usersLat = 55.660056499999996 //req.params.usersLat;
    var usersLng = 12.4947511 //req.params.usersLng;
    console.log("usersLat: "+usersLat+" usersLng: "+usersLng)
    event.findEventsNearUser(usersLat, usersLng, (err, jResult, ajEvents) => {
        if (err) {
            console.log('err ' + err)
        }
        console.log(err)
        console.log(jResult)
        console.log(ajEvents)
        var ajEventsNiceView = JSON.stringify(ajEvents, null, 4)
        return res.send(ajEventsNiceView)
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