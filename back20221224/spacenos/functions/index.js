const functions = require("firebase-functions");
const http =  require("https");
// Create and deploy your first functions
// https://firebase.google.com/docs/functions/get-started

exports.helloWorld = functions.https.onRequest((request, response) => {
  functions.logger.info("Hello logs!", {structuredData: true});

  var url=`https://api.openweathermap.org/data/2.5/weather?lat=${request.query.lat}&lon=${request.query.lon}&appid=c36b43e9d37c0c5bc6984afb781899dc`
  http.get(url, res => {

    let rawData = ''

    res.on('data', chunk => {
        rawData += chunk
    })
    
    res.on('end', () => {
    const parsedData = JSON.parse(rawData)
    response.json(parsedData)
    })

})
});
