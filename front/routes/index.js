var express = require('express');
var router = express.Router();
var db = require('../models/db');

/* GET home page. */
router.get('/', function(req, res, next) {
    res.render('index', {title:'まとめ速報++'});
});

router.get('/blogs', function(req, res, next) {
    res.render('blogs', {title:'登録中のブログ一覧 - まとめ速報++'});
});

router.get('/pickup/:article_id(\\d+)', function(req, res, next) {
    pickup = db.findArticle(req.params.article_id, function(rows) {
        if (rows.length) {
            var pickup = rows[0];
            res.render('index', {title:'【Pickup】' + pickup.title + ' - まとめ速報++', pickup: pickup});
        }
        else {
            res.redirect('/');
        }
    });
});

router.get('/about', function(req, res, next) {
    res.render('about', {title:'このサイトについて - まとめ速報++'});
});

module.exports = router;
