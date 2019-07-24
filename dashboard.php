<?php include "templates/header.php" ?>
<?php require_once "php/functions.php" ?>
<?php
check_auth();
db_connect();
?>

<!-- main -->
<main class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- profile brief -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>Hello,</p>
                    <h4><?php echo $_SESSION['user_username'] ?></h4>
                </div>
            </div>
            <!-- ./profile brief -->

            <!-- friend requests -->
            <div class="panel panel-default">
                <div class="panel-body">
                <h4>friend requests</h4>
                <?php
                    $sql = "SELECT * FROM friend_requests WHERE friend_id = {$_SESSION['user_id']}";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        ?><ul><?php

                        while($f_request = $result->fetch_assoc()) {
                            ?><li><?php

                            $u_sql = "SELECT * FROM users WHERE id = {$f_request['user_id']} LIMIT 1";
                            $u_result = $conn->query($u_sql);
                            $fr_user = $u_result->fetch_assoc();

                            ?><a href="profile.php?username=<?php echo $fr_user['username']; ?>">
                                <?php echo $fr_user['username']; ?>
                            </a> 

                            <a class="text-success" href="php/accept_request.php?uid=<?php echo $fr_user['id']; ?>">
                                [accept]
                            </a> 

                            <a class="text-danger" href="php/remove_request.php?uid=<?php echo $fr_user['id']; ?>">
                                [decline]
                            </a>

                            </li><?php
                        }

                        ?></ul><?php
                    } else {
                        ?><p class="text-center">No friend requests!</p><?php
                    }
                ?>
                </div>
            </div>
            <!-- ./friend requests -->
        </div>
        <div class="col-md-6">
            <!-- post form -->

            <form method="post" action="php/create_post.php">
                <div >
                    <input class="form-control" type="text" name="content" placeholder="Make a post…">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="privateChec" name="privatePost" value="true">
                    <label class="form-check-label" for="privateChec">Private Post</label>
                </div>
                <div>
                    <button class="btn btn-success" type="submit" name="post">Post</button>
                </div>
            </form>
            <hr>
            <!-- ./post form -->

            <!-- feed -->
            <div>
                <!-- post -->
                <?php
                //$sql = "SELECT * FROM posts ORDER BY date DESC";
                $sql = "SELECT posts.id as post_id, posts.*, users.* FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.user_id = {$_SESSION['user_id']} OR (posts.user_id != {$_SESSION['user_id']} AND posts.isPrivate = 0) ORDER BY date DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($post = $result->fetch_assoc()) {
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p><?php echo $post['text']; ?></p>
                            </div>
                            <div class="panel-footer">
                                <span>posted <?php echo $post['date']; ?> by <?php echo $post['username']; ?></span>
                                <span class="text-muted">
                                    <?php 
                                        if ($post['isPrivate'] == 1) 
                                            echo '(Private)';
                                        else
                                            echo '(Public)';
                                    ?> 
                                </span>
                                <span class="pull-right"><a class="text-danger" href="php/delete_post.php?id=<?php echo $post['post_id']; ?>">[delete]</a></span>
                            </div>
                            <!-- post comments -->
                            <div class="panel-body">
                                <?php
                                    $commentSql = "SELECT post_comments.id as comment_id, post_comments.*, users.* FROM post_comments LEFT JOIN users ON post_comments.user_id = users.id WHERE post_comments.post_id = {$post['post_id']} ORDER BY post_comments.id ASC";
                                    $commentsResult = $conn->query($commentSql);
                                    if ($commentsResult->num_rows > 0){
                                        while ($comment = $commentsResult->fetch_assoc()){
                                        ?>
                                            <li>
                                                <span><?php echo $comment['comment']; ?> (commented by <?php echo $comment['username']; ?>)</span>
                                                <span class="pull-rght"> <a class="text-danger" href="php/delete_comment.php?id=<?php echo $comment['comment_id']; ?>">[delete]</a></span>
                                            </li>
                                        <?php
                                        }
                                    }
                                    else{
                                        ?>
                                            <p class="text-center">No comments yet!</p>
                                        <?php
                                        
                                    }
                                ?>
                            </div>
                            <div class="pannel-footer">
                                <form method="post" action="php/create_comment.php">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="comment" placeholder="Add a comment..." required>
                                        <input class="sr-only" type="text" name="post_id" value="<?php echo $post['post_id']?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" type="submit" name="post">Add</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <p class="text-center">No posts yet!</p>
                <?php
                }
                ?>
                <!-- ./post -->
            </div>
            <!-- ./feed -->
        </div>
        <div class="col-md-3">
            <!-- add friend -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>add friend</h4>
                    <?php
                        $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend = 0";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            ?><ul><?php

                            while($fc_user = $result->fetch_assoc()) {
                                ?><li>
                                    <?php echo $fc_user['username']; ?>
                                    <a href="php/add_friend.php?uid=<?php echo $fc_user['id']; ?>">[add]</a>
                                </li><?php
                            }

                            ?></ul><?php
                        } else {
                            ?><p class="text-center">No users to add!</p><?php
                        }
                    ?>
                </div>
            </div>
            <!-- ./add friend -->

            <!-- friends -->
            <div class="panel panel-default">
                <div class="panel-body">
                   <h4>friends</h4>
                    <?php
                        $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend > 0 ";

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            ?><ul><?php
                            while($fc_user = $result->fetch_assoc()) {
                                ?><li>
                                    <?php echo $fc_user['username']; ?>
                                    <a href="php/unfriend.php?uid=<?php echo $fc_user['id']; ?>">[unfriend]</a>
                                </li><?php
                            }

                            ?></ul><?php
                        } else {
                            ?><p class="text-center">No friends yet!</p><?php
                        }
                    ?>
                </div>
            </div>
            <!-- ./friends -->
        </div>
    </div>
</main>
<!-- ./main -->

<?php include "templates/footer.php" ?>