        function side_open() {
          if (side_getStyleValue(document.getElementById("sidemenu"), "display") == "block") {
            side_close();
            return;
          }
          /*document.getElementById("main").style.marginLeft = "230px";*/
          document.getElementById("sidemenu").style.width = "200px";
          document.getElementById("main").style.transition = ".4s";
          document.getElementById("sidemenu").style.display = "block";
        }
        function side_getStyleValue(elmnt,style) {
          if (window.getComputedStyle) {
            return window.getComputedStyle(elmnt,null).getPropertyValue(style);
          } else {
            return elmnt.currentStyle[style];
          }
        }
        function side_close() {
          /*document.getElementById("main").style.marginLeft = "0%";*/
          document.getElementById("sidemenu").style.display = "none";
        }
    
        var totalCount = 6;
        function ChangeIt() {
            var num =  Math.ceil( Math.random() * totalCount );
            document.body.background = 'images/backgrounds/background'+num+'.jpg';
            document.body.style.backgroundRepeat = "repeat";
        }
        $(document).ready(function(){
            $("body").hide(0).delay(100).fadeIn(1000)
        });
        $(document).ready(function(){
          $(document).on('click', '#appOff',
          function(e){
		
		e.preventDefault();
		
		var uid = $(this).data('id');
		
		$.ajax({
			url: 'app-off.php',
			type: 'POST',
			data: 'id='+uid,
			dataType: 'html'
		    })
          });
        });
function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");}    