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
event.getActiveEvents = (fCallback) => {
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

/******************** GET ALL PENDING EVENTS *************/
event.getPendingEvents = (fCallback) => {
	global.db.collection('events').find({status: 'pending'}).toArray((err, ajEvents) => {
		if (err) {
			var jError = { "status": "Error", "message": "ERROR -> event.js -> Cannot GET Pending Events" }
			return fCallback(true, jError)
		}
		var jOk = { "status": "OK", "message": "event.js -> GET Pending Events" }
		return fCallback(false, jOk, ajEvents)
	})
}

/******************** COUNT PENDING EVENTS *************/
event.countPendingEvents = (fCallback) => {
	global.db.collection('events').count({ status: "pending" }, (err, iCount) => {
		if (err) {
			var jError = { "status": "Error", "message": "ERROR -> event.js -> Cannot GET Count Pending Events" }
			return fCallback(true, jError)
		}
		var jOk = { "status": "OK", "message": "event.js -> GET Count Pending Events" }
		return fCallback(false, jOk, iCount)
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
			return fCallback(true, jError)
		}
		var jOk = { "status": "ok", "message": "OK -> event.js -> Displaying Requested Event -> 008" }
		return fCallback(false, jOk, ajEvents[0])
	})
}

/**************************************************/
module.exports = event