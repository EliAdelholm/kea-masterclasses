// THIS CONTROLLER IS ONLY TO PROVIDE EXAMPLES OF THE LOOKUP FUNCTIONALITY IN MONGO
// IT HAS NOTHING TO DO WITH OUR PROJECT

var ObjectId = require('mongodb').ObjectID
var lookup = {}
var fs = require('fs-extra')

/***** CREATE EXAMPLE COLLECTION *******/
lookup.createDocument = (jEvent, collection, fCallback) => {
	global.db.collection(collection).insertOne(jEvent, (err, jResult) => {
		if (err) {
			var jError = { "status": "error", "message": "ERROR - could not save document -> lookup.js -> 001" }
			return fCallback(true, jError, jResults)
		}
		var jOk = { "status": "ok", "message": "lookup.js -> saved -> 000" }
		return fCallback(false, jOk, jResult)
	})
}


/*

*/

/**** SELECTING WITH THE LOOKUP *************/
lookup.selectCourse = (fCallback) => {
    global.db.collection('exampleCourse').aggregate([
        {
            $lookup:
              {
                from: "teachers",         // This is the collection which we want to join with, the "foreign collection"
                localField: "courseName", // This is the field in the local collection which has to have an identical value to the foreignField
                foreignField: "subject",  // This is the field in the foreign collection which has to have an identical value to the localField
                as: "teachers"            // This is the name of the new key under which the data from the foreign collecion will be attached
              }
         }
    ], (err, jResult) => {
        if (err){
            console.log(err);
			var jError = { "status": "error", "message": "ERROR - could not lookup collection -> lookup.js -> 001" }            
            return fCallback(true, jError, jResult)
        }
			var jOk = { "status": "error", "message": "OK - Joined 2 collections -> lookup.js -> 001" }
            console.log(jResult);
            return fCallback(false, jOk, jResult);
    })
}

/**************************************************/
module.exports = lookup