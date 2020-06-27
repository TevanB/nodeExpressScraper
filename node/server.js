var express = require('express');
var fs = require('fs');
const opggScrape = require('opgg-scrape');
const cors = require('cors');
var request = require('request');
var cheerio = require('cheerio');
var app     = express();
var jsdom = require("jsdom");
var path = require('path');
app.engine('html', require('ejs').renderFile);

//var $ = jQuery = require('jquery')(window);
//var html = fs.readFileSync(__dirname + '/public' +  file, 'utf8');
//var $ = cheerio.load(html);
var jsonPath = path.join('public', 'output.json');
function updater(){
//$( document ).ready(function() {
  const { JSDOM } = jsdom;
  const { window } = new JSDOM();
  const { document } = (new JSDOM('')).window;
  global.document = document;
  var $ = jQuery = require('jquery')(window);
  $('#hoa').append('<p id="pSInfo">'+process.env.PORT+'</p>');
  process.env.MIX_PORT = process.env.PORT;

  console.log('updated2, port is: '+process.env.PORT + " " + process.env.MIX_PORT);
  //fs.writeFileSync('./output.json', JSON.stringify({port: process.env.PORT}));
  fs.readFile(jsonPath, 'utf8', function(err, data){
    console.log(JSON.parse(data));
  });
  /*fs.writeFile('public/output.json', JSON.stringify({port: process.env.PORT}), function(err,result){
    if(err) console.log('error', err);

  });*/


//});
}
setInterval(updater, 2000);
const PORT = process.env.PORT || 3000;
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

app.listen(PORT);

console.log('Your node server start successfully.... on port '+PORT);

exports = module.exports = app;
