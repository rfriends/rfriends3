var page = require('webpage').create();
 
page.open('https://news.yahoo.co.jp/', function(status) {
  page.render('cap.png');
  phantom.exit();
});
