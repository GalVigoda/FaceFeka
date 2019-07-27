<?php include "templates/header.php" ?>
<?php require_once "php/functions.php" ?>
<?php
check_auth();
db_connect();
?>
   
<div style="text-align: center;">
    <h1>A Multiplayer Game! Flappy Bird! :)</h1>
   
  
    <form method="post" action="php/create_game_request.php">

     <span style="color: black"> Player Name:</span>
      <input type="text" name="firstName" placeholder="Enter name" required>
        <P>
            <span style="color: black"> Room number:</span>
        <input type="text" name="roomNumber" placeholder="Enter room number" required>
        </P>
        <br>
        <p>
          <span style="color: black"> Select a Player:</span>
          <select name="to_user"> 
              <?php
                $sql = "SELECT id, username, (SELECT COUNT(*) FROM user_friends WHERE user_friends.user_id = users.id AND user_friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend > 0 ";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($fc_user = $result->fetch_assoc()) {
                    ?>
                    <option value = <?php echo $fc_user['id']; ?>> <?php echo $fc_user['username']; ?> </option>
                    <?php
                    }
                }
              ?>
          </select>
        </p>
      <h1> Player Color:
        <P id= color1>
          <span style="color: red">
            <input type="radio" name="color" value="red">Red
          </span>
          <span style="color: blue">
            <input type="radio" name="color" value="blue">Blue
          </span>
            <span style="color: yellow">
            <input type="radio" name="color" value="yellow" checked>Yellow
          </span>
          <span style="color: orange">
            <input type="radio" name="color" value="orange">Orange
          </span>
        </P>
      
        <span style="color: pink">
          <input type="radio" name="color" value="pink">Pink
        </span>
        <span style="color: black">
          <input type="radio" name="color" value="black">Black
        </span>
        <span style="color: gray">
          <input type="radio" name="color" value="gray">Gray
        </span>
        
      </h1>
        <br><br>
        <input type="submit" value="Start Game" 
        style="height:170px;width:450px;background:rgba(243, 149, 8, 0.918)">
    </form>
    </div>
    <?php include "templates/footer.php" ?>