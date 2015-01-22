var express = require('express');
var router = express.Router();

router.get('/articles', function(req, res, next) {
console.log(req.params);
    connection.execute('select a.title, a.url, a.description, a.date, b.title blog_name from articles a, blogs b where a.blog_id = b.blog_id order by date desc limit :start, :results'
    ,{
        start : req.query.start || 0
      , results : req.query.results || 20
    }
    ,function (err, rows) {
        res.json(rows);
    });
});

module.exports = router;
