<?php
 
?>
<div class="form-group">
  <p>Type of User</p>
  <?php
    $connection = dbconnection::getInstance();
    $conn = $connection->getConn();
    $sql = "SELECT user_type FROM user";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      echo "<select name='user_type'>";
      while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['user_type'] . "'>" . $row['user_type'] . "</option>";
      }
      echo "</select>";
    } 
    $conn->close();
  ?>
</div>