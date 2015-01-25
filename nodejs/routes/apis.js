var express = require('express');
var router = express.Router();

router.get('/articles', function(req, res, next) {

    // default sql
    var sql = 'select a.title, a.url, a.description, DATE_FORMAT(a.date, "%Y/%m/%d %H:%i:%s") date, b.title blog_name from articles a, blogs b where a.blog_id = b.blog_id order by date desc limit :start, :results';
    var binds = { start : req.query.start || 0, results : req.query.results || 20 };

    if (req.query.needle) {
        // has needle
        sql = 'select a.title, a.url, a.description, DATE_FORMAT(a.date, "%Y/%m/%d %H:%i:%s") date, b.title blog_name from articles a, blogs b where a.blog_id = b.blog_id AND a.title LIKE CONCAT("%", :needle, "%") order by date desc limit :start, :results';
        binds = { start : req.query.start || 0, results : req.query.results || 20, needle : req.query.needle };
    }

    connection.execute(sql, binds, function (err, rows) {
        if (err) {
            console.log("[error] db error. :" + err);
            res.json({});
        }
        else {
            res.json(rows);
        }
    });
});

router.get('/blogs', function(req, res, next) {
    connection.execute('select blog_id, title blog_name from blogs order by blog_id desc limit :start, :results'
    ,{
        start : req.query.start || 0
      , results : req.query.results || 20
    }
    ,function (err, rows) {
        if (err) {
            console.log("[error] db error. :" + err);
            res.json({});
        }
        res.json(rows);
    });
});

router.get('/blogs/:id(\\d+)/articles', function(req, res, next) {
    connection.execute('select a.title, a.url, a.description, DATE_FORMAT(a.date, "%Y/%m/%d %H:%i:%s") date, b.title blog_name from articles a, blogs b where a.blog_id = b.blog_id AND a.blog_id = :id order by date desc limit :start, :results'
    ,{
        id : req.params.id,
        start : req.query.start || 0,
        results : req.query.results || 20
    }
    ,function (err, rows) {
        if (err) {
            console.log("[error] db error. :" + err);
            res.json({});
        }
        res.json(rows);
    });
});

module.exports = router;
