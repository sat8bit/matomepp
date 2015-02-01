var express = require('express');
var router = express.Router();

router.get('/', function(req, res, next) {
    res.render('admins', {title:'管理画面 - まとめ速報++'});
});

module.exports = router;
