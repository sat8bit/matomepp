var express = require('express');
var router = express.Router();

var db = require('../models/db');

console.log(db);

router.get('/articles', function(req, res, next) {
    if (req.query.needle) {
        db.findArticlesByNeedle({
            start: req.query.start || 0,
            results: req.query.results || 20,
            needle: req.query.needle
        }, function(rows) {
            res.json(rows);
        });
    }
    else {
        db.findAllArticles({
            start: req.query.start || 0,
            results: req.query.results || 20
        }, function(rows) {
            res.json(rows);
        });
    }
});

router.get('/blogs', function(req, res, next) {
    db.findAllBlogs({
        start: req.query.start || 0,
        results: req.query.results || 20
    }, function(rows) {
        res.json(rows);
    });
});

router.get('/recommendations', function(req, res, next) {
    db.findAllRecommendations(function(rows) {
        res.json(rows);
    });
});

router.get('/blogs/:blog_id(\\d+)/articles', function(req, res, next) {
    db.findArticlesByBlogId({
        blog_id : req.params.blog_id,
        start : req.query.start || 0,
        results : req.query.results || 20
    }, function(rows) {
        res.json(rows);
    });
});

module.exports = router;
