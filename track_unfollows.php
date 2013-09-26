<?php include "layout/header.php" ?>
<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Screen name</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>

<?php
  $query_statement = "SELECT * FROM `unfollows_friends` WHERE `user_id`=" . $user["id"];
  $mysql_query = mysql_query($query_statement);

  while ($unfollow = mysql_fetch_assoc($mysql_query)) {
?>
    <tr>
      <td><?php echo $unfollow["screen_name"]; ?></td>
      <td><?php if ($unfollow["status"] == 1) { echo "DONE"; } else { echo "PENDING"; } ?></td>
    </tr>
<?php
  }
?>
    </tbody>
  </table>
</div>

<?php include "layout/footer.php" ?>