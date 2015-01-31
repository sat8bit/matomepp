var mysql = require('mysql2');

exports.findArticle = function(articleId, callback) {
    var sql = 'select a.title, a.url, a.description, DATE_FORMAT(a.date, "%Y/%m/%d %H:%i:%s") date, b.title blog_name from articles a, blogs b where a.blog_id = b.blog_id and a.article_id = :article_id';

    execute(sql, {article_id: articleId}, callback);
};

exports.findAllArticles = function(binds, callback) {
    var sql = 'select a.title, a.url, a.description, DATE_FORMAT(a.date, "%Y/%m/%d %H:%i:%s") date, b.title blog_name from articles a, blogs b where a.blog_id = b.blog_id order by date desc limit :start, :results';

    execute(sql, binds, callback);
};

exports.findArticlesByNeedle = function(binds, callback) {
    var sql = 'select a.title, a.url, a.description, DATE_FORMAT(a.date, "%Y/%m/%d %H:%i:%s") date, b.title blog_name from articles a, blogs b where a.blog_id = b.blog_id AND a.title LIKE CONCAT("%", :needle, "%") order by date desc limit :start, :results';

    execute(sql, binds, callback);
};

exports.findArticlesByBlogId = function(binds, callback) {
    var sql = 'select a.title, a.url, a.description, DATE_FORMAT(a.date, "%Y/%m/%d %H:%i:%s") date, b.title blog_name from articles a, blogs b where a.blog_id = b.blog_id AND a.blog_id = :blog_id order by date desc limit :start, :results';

    execute(sql, binds, callback);
};

exports.findAllBlogs = function(binds, callback) {
    var sql = 'select blog_id, title blog_name, index_url, DATE_FORMAT(updated_at, "%Y/%m/%d %H:%i:%s") updated_at from blogs order by blog_id desc limit :start, :results';

    execute(sql, binds, callback);
};

exports.findAllRecommendations = function(callback) {
    var sql = 'select keyword from recommendations order by keyword';

    execute(sql, {}, callback);
};

var getConnection = function() {
    var connection = mysql.createConnection({
        host: process.env.DB_HOST,
        user: process.env.DB_USER,
        password: process.env.DB_PASSWORD,
        database: process.env.DB_NAME
    });
    connection.config.namedPlaceholders = true;

    return connection;
};

var execute = function(sql, binds, callback) {
    var connection = getConnection();

    connection.execute(sql, binds, function (err, rows) {
        if (err) {
            console.log("[error] db error. :" + err);
            callback({});
        }
        callback(rows);
        connection.end();
    });

};
