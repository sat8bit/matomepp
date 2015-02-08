var express = require('express');
var merge = require('merge');
var router = express.Router();
var db = require('../models/db');

var rendering = function(res, template, params) {
    db.findAllRecommendations(function(recommendations) {
        var binds = {
            recommendations : recommendations
        };

        res.render(template, merge(binds, params));
    });
}

router.get('/', function(req, res, next) {
    rendering(res, 'admins', {
        title :'管理用領域 - まとめ速報++'
    });
});

router.get('/ranking', function(req, res, next) {
    db.findAllArticlesOrderByAccess({start:0, results:100}, function(articles) {
        rendering(res, 'ranking', {
            title :'アクセスランキング - まとめ速報++',
            articles : articles,
            description : 'アクセス数順のランキング'
        });
    });
});

module.exports = router;
