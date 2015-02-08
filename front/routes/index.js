var express = require('express');
var merge = require('merge');
var router = express.Router();
var db = require('../models/db');

var rendering = function(res, template, params) {
    db.findAllRecommendations(function(recommendations) {
        var binds = {
            recommendations : recommendations,
            tracking_id : process.env.TRACKING_ID
        };

        res.render(template, merge(binds, params));
    });
}

router.get('/', function(req, res, next) {
    db.findAllArticles({start:0, results:20}, function(articles) {
        rendering(res, 'index', {
            title :'まとめ速報++',
            articles : articles,
            description : '暇つぶしに最適！スマホ対応の軽量なまとめのまとめサイト'
        });
    });
});

router.get('/blogs', function(req, res, next) {
    db.findAllBlogs({start:0, results:20}, function(blogs) {
        rendering(res, 'blogs', {
            title : '登録中のブログ一覧 - まとめ速報++',
            blogs : blogs
        });
    });
});

router.get('/selection/:needle', function(req, res, next) {
    res.redirect('/s/' + req.params.needle);
});

router.get('/s/:needle', function(req, res, next) {
    db.findArticlesByNeedle({start:0, results:20, needle:req.params.needle}, function(articles) {
        rendering(res, 'selection', {
            title : req.params.needle + 'のまとめ記事集めました。 - まとめ速報++' ,
            articles : articles,
            needle : req.params.needle,
            description : req.params.needle + 'のまとめ記事を集めたスマホ対応の軽量なまとめのまとめサイト'
        });
    });
});

router.get('/pickup/:article_id(\\d+)', function(req, res, next) {
    db.findArticle(req.params.article_id, function(pickupArticles) {
        if (!pickupArticles.length) {
            res.redirect('/');
            return;
        }

        var pickup = pickupArticles[0];

        db.findAllArticles({start:0, results:20}, function(articles) {
            rendering(res, 'pickup', {
                title:'【Pickup】' + pickup.title + ' - まとめ速報++',
                articles : articles,
                pickup : pickup,
                description : '「' + pickup.title + '」をピックアップ！'
            });
        });
    });
});

router.get('/about', function(req, res, next) {
    rendering(res, 'about', {
        title:'このサイトについて - まとめ速報++'
    });
});

router.get('/rd', function(req, res, next) {
    if (!req.query.article_id) {
        res.redirect('/');
        return;
    }

    db.findArticle(req.query.article_id, function(articles) {
        if (!articles.length) {
            res.redirect('/');
            return;
        }

        var article = articles[0];

        res.redirect(article.url);

        db.countupAccess(req.query.article_id, function(rows){});
    });
});

router.get('/sitemap.xml', function(req, res, next) {
    res.set('Content-Type', 'application/xml;charset=UTF-8');
    rendering(res, 'sitemap', {});
});

module.exports = router;
