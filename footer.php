    <div class="main-footer">
            <div class="bottom_footer">
              <p class="p">Copyright (c) Human Resource Managent System <?php echo date("Y"); ?><br>Powered by Jose Kinyua<br><i class="fa fa-phone"></i> 0726655321</p>
              
            </div>
        </div>
        <!-- FullCalendar -->
        <script src="bootstrap/js/jquery.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src='js/moment.min.js'></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/facebox.js"></script>
        <script type="text/javascript">
          jQuery(document).ready(function($) {
            $('a[rel*=facebox]').facebox({
              loadingImage : 'images/loading.gif',
              closeImage   : 'images/closelabel.png'
            })
          })
        </script>
        <script>
          $( "#datepicker" ).datepicker({
              inline: true
          });
        </script>
		<script>
		$(document).ready(function(){
			
			$(document).on('click', '#getUser', function(e){
				
				e.preventDefault();
				
				var uid = $(this).data('id');   // it will get id of clicked row
				
				$('#dynamic-content').html(''); // leave it blank before ajax call
				$('#modal-loader').show();      // load ajax loader
				
				$.ajax({
					url: 'getuser.php',
					type: 'POST',
					data: 'id='+uid,
					dataType: 'html'
				})
				.done(function(data){
					console.log(data);	
					$('#dynamic-content').html('');    
					$('#dynamic-content').html(data); // load response 
					$('#modal-loader').hide();		  // hide ajax loader	
				})
				.fail(function(){
					$('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
					$('#modal-loader').hide();
				});
				
			});
			
		});

		</script>
  </body>
</html>