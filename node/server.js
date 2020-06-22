var express = require('express');
var fs = require('fs');
const opggScrape = require('opgg-scrape');
const cors = require('cors');
var request = require('request');
var cheerio = require('cheerio');
var app     = express();
app.use(express.json());
//app.use(cors);
//Scraping start
app.use(function(req, res, next){
  res.header("Access-Control-Allow-Origin", "*"); // update to match the domain you will make the request from
  res.header("Access-Control-Allow_methods", "GET, PUT, POST, DELETE");
  res.header("Access-Control-Allow-Headers", "Content-Type, x-socket-id");
  next();
});
app.get('/rankings/:name', function(req, res){

	    //var parsedResults = [];
      //console.log(req.params);
       opggScrape.getStats(req.params.name, {region: 'na', refresh: false}).then(stats => {
         //console.log(req.params);
         //var path = './public/output.json';
         res.send(JSON.stringify(stats));

  	  	/*fs.writeFile('./public/output.json', JSON.stringify(stats, null, 4), function(err){
  	    	console.log('Sraping data successfully written! - Check your project public/output.json file');
          //res.end();

  	    });*/
       });
       //res.send('test');

});

app.listen('8001');

console.log('Your node server start successfully....');

exports = module.exports = app;
