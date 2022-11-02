<?php
$reason="SELECT * FROM  appointment where status = '1'";
$result = $conn->query($reason);
$num=mysqli_num_rows( $result );
?>
<section class="breadcrumbs">
        <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li>Dashboard</li>
                </ol>
            </div>
            <div class="col-sm-3">
            <button class="btn btn-primary position-relative" id="col" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <i class="fas fa-bell h5"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo $num?>
            </span>
            </button>
                    
            <?php
            if(isset($_POST['resc'])){
                $app_id=$_POST['app_id'];
                $app_date=$_POST['app_date'];
                $app_time=$_POST['app_time'];
                $update="UPDATE `appointment` SET `date` = '$app_date', `time` = '$app_time', `status` = '1' WHERE `appointment`.`id` ='$app_id'";
                if(mysqli_query($conn,$update)){
                    echo'
                    <script>
                        alert("Appointment Rescheduled");
                    </script>
                    ';
                }else{
                    echo'
                    <script>
                        alert("Appointment Rescheduling Failed");
                    </script>
                    ';
                }
            }
            ?>
            
            <div class="collapse bg-secondary mt-2 text-center text-light" id="collapseExample" >
                <?php
                    $reason="SELECT * FROM  appointment where status ='1'";
                    $result = $conn->query($reason);
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            if($row['status']=='0')
                            {?>
                                <div class="bg-danger text-light p-2" style="border-bottom: solid 1px black; width:120%"> 
                                <a href="include/user/user-cancel.php?id=<?php echo $row["id"].'/'.$row["Rdate"].'/'.$row["Rtime"]?>" class="text-warning">
                                <i class="far fa-trash-alt me-2 h5"></i></a>                
                                Canceled : <?php echo $row["reason"] ?></div>
                           <?php }else if($row['status']=='1')
                            { ?>
                            Notification. You <br> have new <br> appointment
                                <!-- <div class="bg-success text-light p-2" style="border-bottom: solid 1px black; width:120%"> 
                                For Reschedule : <?php echo $row["reason"]?> <br>
                                To be Scheduled on <?php echo $row["Rdate"]?> <br>
                                <a href="include/user/user-confirm.php?id=<?php echo $row['id'].'/'.$row["Rdate"].'/'.$row["Rtime"]?>" class="btn btn-success">Confirm</a>
                                <button data-bs-toggle="modal" data-bs-target="#exampleModal"  class="btn btn-primary">Reschedule</button>
                                <a href="include/user/user-cancel.php?id=<?php echo $row['id'].'/'.$row["Rdate"].'/'.$row["Rtime"]?>" class="btn btn-danger">Cancel</a>
                            </div> -->
                          
            <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reschedule Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                        <input type="hidden" class="form-control" name="app_id" value="<?php echo $row['id']?>">
                        <input type="date" class="form-control" name="app_date" value="<?php echo $row['Rdate']?>" required>
                        <input type="time" class="form-control" name="app_time" value="<?php echo $row['Rtime']?>" required>

                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="resc" class="btn btn-primary">Reschedule</button>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
                    <!-- Modal -->
                          <?php }

                        }
                      } else {
                        echo 'There is no notification.';
                      }
                ?>
                
            </div>
            </div>
        </div>
    </section>