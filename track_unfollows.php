<?php include "layout/header.php" ?>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Screen name</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>

<?php
  $query_statement = "SELECT * FROM `unfollows_friends` WHERE `user_id`=" . $row["id"];
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

<?php include "layout/footer.php" ?>