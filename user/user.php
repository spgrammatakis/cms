
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application |
            <?php require 'http://localhost/cms/user/user.php'; ?>
            <?php echo $dbh->htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
    <?php require './templates/title.php' ?>

        <h2>
            <?php echo $dbh->htmlEscape($row['title']) ?>
        </h2>
        <div>
            <?php echo $dbh->convertSqlDate($row['created_at']) ?>
        </div>
        <p>
        <?php echo $paraText ?>
        </p>
        <h3><?php echo $dbh->countCommentsForPost($postId) ?> comments</h3>
        <?php foreach ($dbh->getCommentsForPost($postId) as $comment): ?>
            <?php // For now, we'll use a horizontal rule-off to split it up a bit ?>
            <hr />
            <div class="comment">
                <div class="comment-meta">
                    Post Form
                    <?php echo $dbh->htmlEscape($comment['user_name']) ?>
                    on
                    <?php echo $dbh->convertSqlDate($comment['created_at']) ?>
                </div>
                <div class="comment-body">
                    <?php echo $dbh->htmlEscape($comment['content']) ?>
                </div>
                <div class="comment-website">
                    <?php echo $dbh->htmlEscape($comment['website']) ?>
                </div>
            </div>
        <?php endforeach ?>
        <?php require 'templates/post-form.php' ?>
    </body>
</html>