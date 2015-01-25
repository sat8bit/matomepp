var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', {title:'まとめ速報++'});
});

router.get('/blogs', function(req, res, next) {
  res.render('blogs', {title:'登録中のブログ一覧 - まとめ速報++'});
});

router.get('/about', function(req, res, next) {
  res.render('about', {title:'このサイトについて - まとめ速報++'});
});

module.exports = router;
