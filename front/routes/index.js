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

/* GET home page. */
router.get('/', function(req, res, next) {
    db.findAllArticles({start:0, results:20}, function(articles) {
        rendering(res, 'index', {
            title :'まとめ速報++',
            articles : articles
        });
    });
});

router.get('/blogs', function(req, res, next) {
    db.findAllBlogs({start:0, results:20}, function(blogs) {
        rendering(res, 'blogs', {
            title:'登録中のブログ一覧 - まとめ速報++',
            blogs:blogs
        });
    });
});

router.get('/selection/:needle', function(req, res, next) {
    db.findArticlesByNeedle({start:0, results:20, needle:req.params.needle}, function(articles) {
        rendering(res, 'selection', {
            title :req.params.needle + 'まとめ速報++',
            articles : articles,
            needle : req.params.needle
        });
    });
});

router.get('/pickup/:article_id(\\d+)', function(req, res, next) {
    db.findArticle(req.params.article_id, function(pickupArticles) {
        if (!pickupArticles.length) {
            res.redirect('/');
        }

        var pickup = pickupArticles[0];

        db.findAllArticles({start:0, results:20}, function(articles) {
            rendering(res, 'pickup', {
                title:'【Pickup】' + pickup.title + ' - まとめ速報++',
                articles : articles,
                pickup : pickup
            });
        });
    });
});

router.get('/about', function(req, res, next) {
   rendering(res, 'about', {
       title:'このサイトについて - まとめ速報++'
   });
});

module.exports = router;
