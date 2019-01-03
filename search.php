<?php
    require __DIR__ . '/db_mysqli.php';
    session_start();
    //$current_user=$_SESSION['user_username'];
    if($_POST){
        $q=$_POST['searchword'];
        $sql_res=mysqli_query($database,"select * from staff_tb where fname like '%$q%' or lname like '%$q%' order by staff_id LIMIT 5");
        //$result=  mysql_query($sql_res) or die(mysql_errno());
        $trws= mysqli_num_rows($sql_res);
        if($trws>0){
            while($row=mysqli_fetch_array($sql_res)){
            $fname=$row['fname'];
            $lname=$row['lname'];
            $username=$row['username'];
            $re_fname='<b>'.$q.'</b>';
            $re_lname='<b>'.$q.'</b>';
            $final_fname = str_ireplace($q, $re_fname, $fname);
            $final_lname = str_ireplace($q, $re_lname, $lname);
?>  
<a href="le-edit-user.php?username=<?php echo $username; ?>">    
    <div class="display_box" align="left">
        <i class="fa fa-user"></i>
<?php echo $final_fname; ?>&nbsp;<?php echo $final_lname; ?>    
    </div>    
</a>
<?php
            }
        }
        else{
?>        
<div class="display_box" align="left">    
<?php echo "No results to show"; ?>
</div>
<?php   
        }
    }
    else{
    }
?>