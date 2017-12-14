var ObjectId = require('mongodb').ObjectID
var stats = {}


/***************** INCREASE CLICKRATE BY 1  **********************/

stats.incrementClickrate = (sEventId, fCallback) => {
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

/************ GET CLICKRATE BY EVENT TYPE ************/

stats.getClickratesByType = (fCallback) => {
    global.db.collection('events').find( { status: "active" }, { type: 1, clickrate: 1}).toArray( (err, jResult) => {
        if (err) {
            console.log('err ' + err)
            return fCallback(true, jResult);
        }

        var uxSum = 0, uxLen = 0, uiSum = 0, uiLen = 0, devSum = 0, devLen = 0

        for (var i = 0; i < jResult.length; i++) {
            if (jResult[i].type == "ux") {
                uxSum += jResult[i].clickrate
                uxLen++
            } else if (jResult[i].type == "ui") {
                uiSum += jResult[i].clickrate
                uiLen++
            } else {
                devSum += jResult[i].clickrate
                devLen++
            }
        }

        var jAvgClickrates = {
            "ux": [uxSum / uxLen],
            "ui": [uiSum / uiLen],
            "dev": [devSum / devLen],
        }

        console.log(uxSum, uxLen, jAvgClickrates);
        return fCallback(false, jAvgClickrates);
        }
    );
};


/******************** COUNT PENDING EVENTS *************/
stats.countPendingEvents = (fCallback) => {
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
stats.countActiveEvents = (fCallback) => {
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

/******************** GET TOP 10 EVENTS BY CLICKRATE *************/
stats.getPopularEvents = (fCallback) => {
	global.db.collection('events').find({status: 'active'}, {title: 1, type: 1}).sort({clickrate: -1}).limit(10).toArray((err, ajEvents) => {
		if (err) {
			var jError = { "status": "ERROR", "message": "STATS -> Cannot GET Popular Events" }
			return fCallback(true, jError, ajEvents)
		}
		var jOk = { "status": "OK", "message": "STATS -> GET Popular Events" }
		return fCallback(false, jOk, ajEvents)
	})
}

/**************************************************/

/******************** COUNT SPEAKERS *************/
stats.getSpeakers = (fCallback) => {
	global.db.collection('events').find({ status: "active", creator: {$exists: true} }, {creator: 1}).toArray( (err, ajEvents) => {
		if (err) {
			console.log(err)
			var jError = { "status": "Error", "message": "Cannot GET Speakers" }
			return fCallback(true, jError, ajEvents)
		}
		var jOk = { "status": "OK", "message": "GET Speakers" }
		return fCallback(false, jOk, ajEvents)
	})
}

module.exports = stats