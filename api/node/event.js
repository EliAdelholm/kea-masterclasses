var ObjectId = require('mongodb').ObjectID
var event = {}
var fs = require('fs-extra')


/******************** SAVE EVENT ****************/
event.createEvent = (jEvent, fcallback) => {
	global.db.collection('events').insertOne(jEvent, (err, jResult) => {
		if (err) {
			var jError = { "status": "error", "message": "ERROR -> event.js -> 001" }
			console.log(err)
			return fcallback(true, jError, jResult)
		}
		var jOk = { "status": "ok", "message": "event.js -> saved -> 000" }
		console.log(jOk)
		return fcallback(false, jOk, jResult)
	})
}

/******************** UPDATE EVENT ****************/
event.updateEvent = (jEvent, bImageUploaded, fCallback) => {
	var jEventQuery = {
		'$set': {
			"title": jEvent.title,
			"type": jEvent.type,
			"image": jEvent.image,
			"location.room": jEvent.location.room,
			"location.address": jEvent.location.address,
			"location.coordinates": jEvent.location.coordinates,
			"date": jEvent.date,
			"time": jEvent.time,
			"speaker": jEvent.speaker,
			"organizer": jEvent.organizer,
			"description": jEvent.description,
			"requirements": jEvent.requirements
		}
	};

	// If there was no image uploaded, do not update the image
	if (!bImageUploaded){
		delete jEventQuery.$set.image;
	}
	if (jEvent.coordinates == undefined) {
		delete jEventQuery.$set["location.coordinates"];
	}
	global.db.collection('events').updateOne({'_id': ObjectId(jEvent._id)},
		jEventQuery,
	(err)=>{
		if(err){
			console.log(err);
			var jError = {"status": "error", "message": "ERROR, could not update event -> event.js"};
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

/************************* CANCEL EVENT  *************/
event.cancelEvent = (sEventId, fCallback) => {
	global.db.collection('events').updateOne({"_id": ObjectId(sEventId)}, {$set:{"status" : "cancelled"}}, (err, jResult) => {
		if(err) {
			var jError = { "status": "Error", "message": "ERROR -> event.js -> Cannot cancel Event" }
			return fCallback(true, jError);
		}
		var jOk = { "status": "OK", "message": "event.js -> Event was cancelled" }
		return fCallback(false, jOk);
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
	var iUsersLng = Number(usersLng);
	var iUserLat = Number(usersLat);
	
	global.db.collection('events').find({ location:
	{ $geoWithin:
	   { $centerSphere: [ [ iUserLat, iUsersLng ], 60 / 3963.2 ] } } }).toArray((err, ajEvents) => {
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
