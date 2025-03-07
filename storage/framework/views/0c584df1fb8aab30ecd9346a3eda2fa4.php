<!DOCTYPE html>
<html>
<head>
    <title>Post Comment Notification</title>
</head>
<body>
    <h1>Your Post Was Commented!</h1>
    <p>
        Hello,
    </p>
    <p>
        <?php echo e($commenter->name); ?> commented your post "<?php echo e($post->title); ?>".
    </p>
    <p>
        <a href="<?php echo e(url('/posts/' . $post->id)); ?>">Click here</a> to view the post.
    </p>
    <p>Thank you for using our platform!</p>
</body>
</html><?php /**PATH C:\laragon\www\pusher_test\resources\views/emails/post-comment.blade.php ENDPATH**/ ?>