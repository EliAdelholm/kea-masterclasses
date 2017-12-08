var ObjectId = require('mongodb').ObjectID
var event = {}

/******************** SAVE EVENT ****************/
event.createEvent = (jEvent, fcallback) => {
	global.db.collection('events').insertOne(jEvent, (err, jResult) => {
		if (err) {
			var jError = { "status": "error", "message": "ERROR -> event.js -> 001" }
			console.log(jError)
			return fcallback(true, jError, jResults)
		}
		var jOk = { "status": "ok", "message": "event.js -> saved -> 000" }
		console.log(jOk)
		return fcallback(false, jOk, jResult)
	})
}

/******************** UPDATE EVENT ****************/
event.updateEvent = (jEvent, fCallback) => {
	global.db.collection('events').updateOne({'_id': ObjectId(jEvent._id)},
		{'$set' : {"title" : jEvent.title , "type": jEvent.type, 
		"location.room" : jEvent.location.room,
		"location.address" : jEvent.location.address,
		"location.coordinates" : jEvent.location.coordinates,
		"date" : jEvent.date,
	"time": jEvent.time, "speaker" : jEvent.speaker, "organizer" : jEvent.organizer, "description" : jEvent.description, "requirements" : jEvent.requirements}},
	(err)=>{
		if(err){
			jError = {"status": "error", "message": "ERROR, could not update event -> event.js"};
			return fCallback(true, jError);
		}
		var jOk = {"status": "ok", "message": "event.js -> event updated" }
	    return fCallback(false, jOk);
	});
}


/******************** DELETE EVENT ****************/
event.deleteEvent = (iEventId, fCallback) => {
	global.db.collection('events').deleteOne({ "_id": ObjectId(iEventId) }, (err, jResult) => {
		if (err) {
			var jError = { "status": "error", "message": "ERROR -> event.js -> 005" }
			console.log(err + jError)
			return fcallback(true, jError)
		}
		var jOk = { "status": "ok", "message": "event.js -> deleted -> 004" }
		console.log(jResult + jOk)
		return fCallback(false, jOk)
	})
}

/******************** GET ALL ACTIVE EVENTS *************/
event.getActiveEvents = (fCallback) => {
	// get the data from the collection events
	global.db.collection('events').find({status: 'active'}).toArray((err, ajEvents) => {
		if (err) {
			var jError = { "status": "ERROR", "message": "ERROR -> event.js -> 007" }
			console.log(jError)
			return fCallback(true, jError, ajEvents)
		}
		
		// We know we fucked up the date format in mongo and this is just a quick fix
		ajEvents.sort(function(a,b) { 
			return new Date(b.date) - new Date(a.date) 
		});

		var jOk = { "status": "Displaying Events", "message": "event.js -> Displaying Events -> 006" }
		// console.log(jOk, ajEvents)
		return fCallback(false, jOk, ajEvents)
	})
}

/******************** GET ALL PENDING EVENTS *************/
event.getPendingEvents = (fCallback) => {
	global.db.collection('events').find({status: 'pending'}).toArray((err, ajEvents) => {
		if (err) {
			var jError = { "status": "Error", "message": "ERROR -> event.js -> Cannot GET Pending Events" }
			return fCallback(true, jError, ajEvents)
		}
		var jOk = { "status": "OK", "message": "event.js -> GET Pending Events" }
		return fCallback(false, jOk, ajEvents)
	})
}

/******************** GET ALL DISSMISSED EVENTS *************/
event.getDissmissedEvents = (fCallback) => {
	global.db.collection('events').find({status: 'dissmissed'}).toArray((err, ajEvents) => {
		if (err) {
			var jError = { "status": "Error", "message": "ERROR -> event.js -> Cannot GET Dissmissed Events" }
			return fCallback(true, jError, ajEvents)
		}
		var jOk = { "status": "OK", "message": "event.js -> GET Dissmissed Events" }
		return fCallback(false, jOk, ajEvents)
	})
}

/******************** COUNT PENDING EVENTS *************/
event.countPendingEvents = (fCallback) => {
	global.db.collection('events').count({ status: "pending" }, (err, iCount) => {
		if (err) {
			var jError = { "status": "Error", "message": "ERROR -> event.js -> Cannot GET Count Pending Events" }
			return fCallback(true, jError, iCount)
		}
		var jOk = { "status": "OK", "message": "event.js -> GET Count Pending Events" }
		return fCallback(false, jOk, iCount)
	})
}

/******************** COUNT ACTIVE EVENTS *************/
event.countActiveEvents = (fCallback) => {
	global.db.collection('events').count({ status: "active" }, (err, iCount) => {
		if (err) {
			console.log(err)
			var jError = { "status": "Error", "message": "Cannot GET Count Active Events" }
			return fCallback(true, jError, iCount)
		}
		var jOk = { "status": "OK", "message": "GET Count Active Events" }
		return fCallback(false, jOk, iCount)
	})
}

/******************** GET EVENTS IN CURRENT SEMESTER *************/
event.getSemesterEvents = (sSemester, fCallback) => {
	// this is terrible D:
	var aMonths = sSemester == "spring" ? [/Feb/, /Mar/, /Apr/, /May/, /Jun/, /Jul/] : [/Aug/, /Sep/, /Oct/, /Nov/, /Dec/, /Jan/];
	global.db.collection('events').find({status: 'active', date: { $in: aMonths } }, {_id: 1}).toArray((err, ajEvents) => {
		if (err) {
			var jError = { "status": "Can't Display Events", "message": "ERROR -> event.js -> 007" }
			console.log(jError)
			return fCallback(true, jError, ajEvents)
		}
		var jOk = { "status": "Displaying Events", "message": "event.js -> Displaying Events -> 006" }
		console.log(jOk, ajEvents)
		return fCallback(false, jOk, ajEvents)
	})
}

/******************** APPROVE EVENT *************/
event.approveEvent = (iEventId, fCallback) => {
	global.db.collection('events').updateOne({ "_id": ObjectId(iEventId) }, { $set: { "status": "active" } }, (err, jResult) => {
		if (err) {
			var jError = { "status": "Error", "message": "ERROR -> event.js -> Cannot Approve Event" }
			return fCallback(true, jError)
		}
		var jOk = { "status": "OK", "message": "event.js -> Approved Event" }
		return fCallback(false, jOk)
	})
}

/******************** DISSMISS EVENT *************/
event.dissmissEvent = (iEventId, fCallback) => {
	global.db.collection('events').updateOne({ "_id": ObjectId(iEventId) }, { $set: { "status": "dissmissed" } }, (err, jResult) => {
		if (err) {
			var jError = { "status": "Error", "message": "ERROR -> event.js -> Cannot Dissmiss Event" }
			return fCallback(true, jError)
		}
		var jOk = { "status": "OK", "message": "event.js -> Dissmissed Event" }
		return fCallback(false, jOk)
	})
}

/******************** DISPLAY EVENT BY ID ************/
event.displayEventById = (iEventId, fCallback) => {
	console.log(iEventId);
	global.db.collection('events').find({ "_id": ObjectId(iEventId) }).toArray((err, ajEvents) => {
		if (err || ajEvents.length != 1) {
			var jError = { "status": "error", "message": "ERROR -> event.js -> 009" }
			return fCallback(true, jError, ajEvents[0])
		}
		var jOk = { "status": "ok", "message": "OK -> event.js -> Displaying Requested Event -> 008" }
		return fCallback(false, jOk, ajEvents[0])
	})
}

/***************** INCREASE CLICKRATE BY 1  **********************/
event.incrementClickrate = (sEventId, fCallback) => {
	global.db.collection('events').updateOne({'_id': ObjectId(sEventId)},
	{$inc: {"clickrate" : 1}}, 
	(err)=>{
		if(err){
			jError = {"status": "error", "message": "ERROR, could not increment clickrate -> event.js"};
			return fCallback(true, jError);
		}
		var jOk = {"status": "ok", "message": "event.js -> clickrate incremented" }
	    return fCallback(false, jOk);
	});
}

/***************** GET EVENTS NEAR USER  **********************/
event.findEventsNearUser = (usersLat, usersLng, fCallback) => {
	//console.log('x');

	// db.events.find({ location: { $nearSphere: { $geometry: { type: "Point", coordinates: [ 55.66, 12.49  ] }, $maxDistance: 10000 } } })
	
	global.db.collection('events').find({ location:
	{ $geoWithin:
	   { $centerSphere: [ [ usersLat, usersLng ], 200 / 3963.2 ] } } }).toArray((err, ajEvents) => {
		if (err) {
			var jError = { "status": "error", "message": "ERROR -> event.js -> 0011" }
			return fCallback(true, jError, ajEvents)
		}
		var jOk = { "status": "ok", "message": "OK -> event.js -> Displaying Requested Event -> 0010" }
		return fCallback(false, jOk, ajEvents)
	})
}


/**************************************************/
module.exports = event
