<!doctype html>
<html>
<head>
    <title>贡献车牌</title>
    <meta name="viewport" content="width=300, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
    <div data-role="page">
         <!--<div data-role="header"></div><!-- /header -->
 
        <div role="main" class="ui-content" id="content">
			<form id="carForm" name="carForm" action="reg_server.php">
				<label for="carId" class="ui-hidden-accessible">车牌号</label>
				<input type="text" name="carId" id="carId" value="<?php echo $_GET['c'];?>" placeholder="川Axxxx" required>

				<label for="contactName" class="ui-hidden-accessible">车主姓名</label>
				<input type="text" name="contactName" id="contactName" value="" placeholder="车主姓名">
				
				<label for="tel" class="ui-hidden-accessible">手机号</label>
				<input type="tel" name="tel" id="tel" value="" placeholder="手机号" required>
				
				<label id="hint" class="ui-hidden-accessible">输入格式不对</label>
				<input type="text" name="openId" id="openId" value="<?php echo $_GET['o'];?>" class="ui-hidden-accessible">
				<input type="submit" id="carSubmit" name="carSubmit" value="完成">
			</form>
        </div><!-- /content -->
	
        <div data-role="footer">
            <h4>Any questions, please contact "Evan, He".</h4>
        </div><!-- /footer -->
 
    </div><!-- /page -->
<script>

$( "#carId" ).on( "focus", function() {
    $( "#hint" ).addClass("ui-hidden-accessible");
});
$( "#tel" ).on( "focus", function() {
    $( "#hint" ).addClass("ui-hidden-accessible");
});

// Validate the input
$( "#carForm" ).submit(function( event ) {
	var inputtedCarId = $( "#carId" ).val();
    var inputtedPhone = $( "#tel" ).val();
 
    // Match only numbers
	var carIDRegex = /^[\u4e00-\u9fa5]{1}[A-Z]{1}[A-Z_0-9]{5}$/;
    var phoneRegex = /^1[3-9]\d{9}$/;
	
    if ( !carIDRegex.test( inputtedCarId ) ) {
		$( "#hint" ).html("车牌号格式不对");
		$( "#hint" ).removeClass("ui-hidden-accessible");
        event.preventDefault();
    }
    else if ( !phoneRegex.test( inputtedPhone ) ) {
		$( "#hint" ).html("手机号格式不对");
		$( "#hint" ).removeClass("ui-hidden-accessible");
        event.preventDefault();
    } else {

		$.mobile.loading( "show");
		$(this).addClass("ui-state-disabled");
				
		// Stop form from submitting normally
		event.preventDefault();
		
		url = $(this).attr( "action" );
		// Send the data using post

		var posting = $.post( url, $(this).serialize() );

		// Put the results in a div
		var content = "";
		posting.done(function( response ) {
			$.mobile.loading( "hide" );
			content = String(response);
			$( "#content" ).empty().append( content );
		})
		.fail(function() {
			alert("贡献失败，请联系Evan,He");
		});
    }
});
</script>
</body>
</html>