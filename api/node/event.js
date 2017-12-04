var ObjectId = require('mongodb').ObjectID
var event = {}

/******************** SAVE EVENT ****************/
event.createEvent = (jEvent, fcallback) => {
	global.db.collection('events').insertOne(jEvent, (err, jResult) => {
		if (err) {
			var jError = { "status": "error", "message": "ERROR -> event.js -> 001" }
			console.log(jError)
			return fcallback(true, jError)
		}
		var jOk = { "status": "ok", "message": "event.js -> saved -> 000" }
		console.log(jOk)
		return fcallback(false, jOk, jResult)
	})
}

/******************** UPDATE EVENT ****************/
event.updateEvent = (jEvent, fcallback) => {
	global.db.collection('events').updateOne({id: jEvent.id}, { jEvent }, (err, jResult) => {
		if (err) {
			var jError = { "status": "error", "message": "ERROR -> event.js -> 003" }
			console.log(jError)
			return fcallback(true, jError)
		}
		var jOk = { "status": "ok", "message": "event.js -> saved -> 002" }
		console.log(jOk)
		return fcallback(false, jOk, jResult)
	})
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
event.getEvents = (fCallback) => {
	// get the data from the collection events
	global.db.collection('events').find({status: 'active'}).toArray((err, ajEvents) => {
		if (err) {
			var jError = { "status": "Can't Display Events", "message": "ERROR -> event.js -> 007" }
			console.log(jError)
			return fCallback(true, jError)
		}
		var jOk = { "status": "Displaying Events", "message": "event.js -> Displaying Events -> 006" }
		console.log(jOk, ajEvents)
		return fCallback(false, jOk, ajEvents)
	})
}

/******************** DISPLAY EVENT BY ID ************/
event.displayEventById = (iEventId, fCallback) => {
	console.log(iEventId);
	global.db.collection('events').find({ "_id": ObjectId(iEventId) }).toArray((err, ajEvents) => {
		if (err || ajEvents.length != 1) {
 			console.log("ajEvents ", ajEvents);
			var jError = { "status": "error", "message": "ERROR -> event.js -> 009" }
			// var jError = (err, "Can't Display Event")
			console.log(jError)
			return fCallback(true, jError)
		}
		var jOk = { "status": "ok", "message": "OK -> event.js -> Displaying Requested Event -> 008" }
		return fCallback(false, jOk, ajEvents[0])
	})
}

/**************************************************/
module.exports = event