<?php include "layout/header.php" ?>

<div id="user-list" class="container" rel="0">
  <div class="row">
    <div class="col-md-2">
      <form action="backend/add_to_unfollow_queue.php" method="post">
        <input id="form-user-id" type="hidden" name="user_id" value="<?php echo $row["id"]; ?>">
        <input id="form-friends-ids" type="hidden" name="friends_ids">
        <button type="submit" class="btn btn-md btn-danger">Unfollow</button>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
  function assignCheckboxEvents(lowerBound) {
    $(".user-row .checkbox").each(function() {
      var userId = parseInt($(this).parent().parent().attr("rel").split("|")[0]);
      if (userId > lowerBound) {
        $(this).click(function() {
          refreshUnfollowList();
        })
      }
    })
  }

  function refreshUnfollowList() {
    var unfollowList = "";

    $(".user-row").each(function() {
      var checkbox = $(this).find(".checkbox");
      if (checkbox.is(":checked")) {
        if (unfollowList != "") {
          unfollowList += "|";
        }

        unfollowList += $(this).attr("rel").split("|")[1];
      }
    });

    $("#form-friends-ids").val(unfollowList);
  }

  function refreshList() {
    var userId = parseInt($("body").attr("rel"));
    var lowerBound = parseInt($("#user-list").attr("rel"));
    $.ajax({
      url: "backend/no_profile_image.php",
      type: "GET",
      data: {
        user_id: userId,
        lower_bound: lowerBound
      }, success: function(response) {
        var new_users = $.parseJSON(response);
        var new_html = "";
        var latest_id = lowerBound;

        for (var i = 0; i < new_users.length; i += 1) {
          console.log(new_users[i]);
          new_html += "<div class='row user-row' rel='" + new_users[i]["id"] + "|" + new_users[i]["screen_name"] + "'>";
          new_html += "<div class='col-md-1'><input class='form-control checkbox' type='checkbox'><\/div>";
          new_html += "<div class='col-md-5 screen-name'>" + new_users[i]["screen_name"] + "<\/div>";
          new_html += "<div class='col-md-2 col-md-offset-4'><img src='" + new_users[i]["profile_image_url"] + "'\/><\/div>";
          new_html += "<\/div>";

          latest_id = new_users[i]["id"];
        }

        $("#user-list").append(new_html);
        $("#user-list").attr("rel", latest_id);

        assignCheckboxEvents(lowerBound);
      }
    })
  }

  $(document).ready(function() {
    refreshList();
    setInterval(function() {
      refreshList();
    }, 5000);
  })
</script>

<?php include "layout/footer.php" ?>