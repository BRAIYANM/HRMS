<?php
		 
	require_once 'database.php';
    $conn = db();
	
	if (isset($_REQUEST['id'])) {
			
		$id = intval($_REQUEST['id']);
		$query = "SELECT * FROM staff_tb WHERE staffid=:staffid";
		$stmt = $conn->prepare( $query );
		$stmt->execute(array(':staffid'=>$id));
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
			
		?>
			
        <div class="">
          <form method="post">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">Username</span>
                <input type="text" class="form-control" value="<?php echo $username; ?>" name="username" readonly>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="password" class="form-control" value="<?php echo $password; ?>" name="password" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">Role</span>
                <input type="text" class="form-control" value="<?php echo $role; ?>" name="role" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">Department</span>
                <input type="text" class="form-control" value="<?php echo $department; ?>" name="department" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">Status</span>
                <input type="text" class="form-control" value="<?php echo $status; ?>" name="status" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">Office</span>
                <input type="text" class="form-control" value="<?php echo $office_no; ?>" name="office_no" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">Ext</span>
                <input type="text" class="form-control" value="<?php echo $ext; ?>" name="ext" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon">Supervisor</span>
                <input type="text" class="form-control" value="<?php echo $supervisor; ?>" name="supervisor" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary" name="">Update</button>
          </form>
        </div>
			
		<?php				
	}