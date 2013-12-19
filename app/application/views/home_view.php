<!DOCTYPE html>

<html>

<head>
	<title>Search for Harvard's Online Resources</title>
	<link href='http://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo asset_url() . 'css/style.css';?>">
	<!-- jQuery CDN  -->
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	<!-- BootStrap CDN -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
	
</head>

<body>
	<div id='container'>
        <!--
    	<div class="header">
        	<img src = "<?php echo asset_url() . 'img/my_harvard_pic.png';?>" alt="" />
        </div>
        -->

	    <div class="main">

            <div id='checkboxes'>
	        	<p><label><input type="checkbox" id="cat1Academics" class='cat1' name="Academics" value="Academics">Academics</label><br>
	        		<div id='cat2Academics'>
	        			<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Administrivia" value="Administrivia">Administrivia</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Advising" value="Advising">Advising</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Choosing Classes" value="Choosing Classes">Choosing Classes</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Concentrations and Secondary Fields" value="Concentrations and Secondary Fields">Concentrations & Secondaries</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="General Education Information" value="General Education Information">General Education Information</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Libraries" value="Libraries">Libraries</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Research" value="Research">Research</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Other" value="Other">Other</label></p>
	        		</div>
	        	</p>
	        	<hr>
	        	<p><label><input type="checkbox" id="cat1Athletics" class='cat1' name="Athletics" value="Athletics">Athletics</label><br></p>
	        	<hr>
	        	<p><label><input type="checkbox" id="cat1Finance" class='cat1' name="Financial Information" value="Financial Information">Financial Information</label><br></p>
	        	<hr>
	        	<p><label><input type="checkbox" id="cat1Health" class='cat1' name="Health and Safety" value="Health and Safety">Health and Safety</label><br>
	        		<div id="cat2Health">
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Immediate Crisis" value="Immediate Crisis">Immediate Crisis</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Mental Health and Wellness" value="Mental Health and Wellness">Mental Health and Wellness</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Other" value="Other">Other</label></p>
	        		</div>
	        	</p>
	        	<hr>
	        	<p><label><input type="checkbox" id="cat1Residential" class='cat1' name="Residential Life" value="Residential Life">Residential Life</label><br>
		        	<div id="cat2Residential">
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Freshmen Living" value="Freshmen Living">Freshmen Living</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="General Information and Policies" value="General Information and Policies">General Information and Policies</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Upperclassmen Houses" value="Upperclassmen Houses">Upperclassmen Houses</label></p>
			        	<p style="font-size:12px;"><label><input type="checkbox" class='cat2' name="Other" value="Other">Other</label></p>
		        	</div>
	        	</p>
	        	<hr>
	        	<p><label><input type="checkbox" id="cat1Student" class='cat1' name="Student Activities" value="Student Activities">Student Activities</label><br></p>
	        	<hr>
	        	<p><label><input type="checkbox" id="cat1Work" class='cat1' name="Summer, On-Campus and Career Opportunities" value="Summer, On-Campus and Career Opportunities">Summer, On-Campus and &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Career Opportunities</label><br></p>
	        	<hr>
	        </div>
		    <div id='resultsWrapper'>
		    	<div id='text_search'>
			    	 <p>&nbsp;&nbsp;Filter These Results: <input type="text" id="textBox" name="textQuery"> &nbsp;</p>
			    </div>
		        <div id='results'>
		            <table id='resultsTable'>
						<tbody id ='startResults'>
						</tbody>
		            </table>
				</div>
		    </div>
	    </div>
    </div>

    <script>
    
    var jsonLinkData = [];
    
    function textFilter()
    {
    	console.log($("#textBox").val());
    	
    	if ($("#textBox").val() == '')
    	{
	    	for (var i=0; i < jsonLinkData.length; i++) {
				var link = jsonLinkData[i];
				$("#startResults").append('<tr><td><a href="' + link['url'] +'" target="_blank"><b>' + link['title'] + '</b></a></td></tr>');
			}
			
			return;
    	}
    	
    	
    	$("#startResults").html('');
    	
	    for (var i=0; i < jsonLinkData.length; i++) {
			var link = jsonLinkData[i];
			if (link['text'].search($("#textBox").val().toLowerCase()) != -1)
			{
				console.log(link['title']);
				$("#startResults").append('<tr><td><a href="' + link['url'] +'" target="_blank"><b>' + link['title'] + '</b></a></td></tr>');
			}
		}
    }
    
    $(document).ready(function(){
        // Hide everything
    	$("#startResults").html("");
    	$("#textBox").val("");
	    $("#cat2Academics").hide();
    	$("#cat2Health").hide();
    	$("#cat2Residential").hide();
    	$("#text_search").hide();
    	$("#results").height(600);
    	
    	$(".cat1").attr("checked",false);
    	$(".cat2").attr("checked",false);
    	
    	
    	$("#cat1Academics").bind('change', function(){
    		if ($("#cat1Academics").is(":checked")) {
	    		$("#cat2Academics").slideDown();
    		}
    		else {
	    		$("#cat2Academics").slideUp();
	    		$("#cat2Academics input").each(function () {
		    		$(this).attr("checked",false);
	    		});
    		}

        });
        
        $("#cat1Health").bind('change', function(){
    		if ($("#cat1Health").is(":checked")) {
	    		$("#cat2Health").slideDown();
    		}
    		else {
	    		$("#cat2Health").slideUp();
	    		$("#cat2Health input").each(function () {
		    		$(this).attr("checked",false);
	    		});
    		}
    		
        });
        
        $("#cat1Residential").bind('change', function(){
    		if ($("#cat1Residential").is(":checked")) {
	    		$("#cat2Residential").slideDown();
    		}
    		else {
	    		$("#cat2Residential").slideUp();
	    		$("#cat2Residential input").each(function () {
		    		$(this).attr("checked",false);
	    		});
    		}
        });
        
        $("#checkboxes input").bind('change', function() {
	    	search(); 
        });
        
        // Textual Search Settings
        var timer = null;
        
        textSearch = $('#textBox');
        
        textSearch.keyup(function(e) {
	        clearTimeout(timer);
	        timer = setTimeout(textFilter, 1500);
	    });
        
    });

	function search()
	{
		$("#startResults").html("");
		$("#textBox").val("");
		
		categories = [];
		
		tempArray = [];
		if ($("#cat1Academics").is(":checked"))
		{	
			var cat2Checked = 0;
			$("#cat2Academics input").each(function() {
				if ($(this).is(":checked"))
				{
					cat2Checked++;
					tempArray.push(this.name);
				}
			});
			
			if (cat2Checked !=0)
			{
				object = {'Academics': tempArray};
				categories.push(object);
			}
		}

		if ($("#cat1Athletics").is(":checked"))
		{	
			object = {'Athletics': []};
			categories.push(object);
		}
		
		tempArray = [];
		if ($("#cat1Health").is(":checked"))
		{	
			var cat2Checked = 0;
			$("#cat2Health input").each(function() {
				if ($(this).is(":checked"))
				{
					cat2Checked++;
					tempArray.push(this.name);
				}

			});
			
			if (cat2Checked != 0)
			{
				object = {'Health and Safety': tempArray};
				categories.push(object);
			}
		}
		
		tempArray = [];
		if ($("#cat1Residential").is(":checked"))
		{	
			var cat2Checked = 0;
			$("#cat2Residential input").each(function() {
				if ($(this).is(":checked"))
				{
					cat2Checked++;
					tempArray.push(this.name);
				}

			});
			
			if (cat2Checked != 0)
			{
				object = {'Residential Life': tempArray};
				categories.push(object);
			}
		}

		
		if ($("#cat1Student").is(":checked"))
		{	
			object = {'Student Activities': []};
			categories.push(object);
		}
		
		if ($("#cat1Work").is(":checked"))
		{	
			object = {'Summer, On-Campus and Career Opportunities': []};
			categories.push(object);
		}
		
		if ($("#cat1Finance").is(":checked"))
		{	
			object = {'Financial Information': []};
			categories.push(object);
		}
		console.log(categories);
		
		$.ajax({
			type: "POST",
	        url: '<?php echo site_url('home/search'); ?>',
	        data: {
	        		categories:JSON.stringify(categories)
	        	  },
	        complete: function (xhr, status) {
	        	console.log(xhr);
		    	if (status === 'error' || xhr.statusText != "OK") {
		    		console.log(xhr);
			        alert("Could not complete search.");
			    }
			    else {
			        // Success
			        if (xhr.responseText == "")
			        {
			        	$("#textBox").val("");
			        	$("#text_search").hide();
			        	$("#results").height(600);
			        	return;
			        }
			        $("#text_search").show();
			        $("#results").height(560);
			        jsonLinkData = JSON.parse(xhr.responseText);
			        
					for (var i=0; i < jsonLinkData.length; i++) {
					    var link = jsonLinkData[i];
					    /*$("#startResults").append('<li><p><b>' + link['title'] + '</b></p><p> <a href="' + link['url'] +'">' + link['url'] + '</a> score: '+ link['score'] +' ' + link['cat1'] + ' '+ link['cat2'] + ' ' + link['debug'] + '</p></li>');*/
					    /*$("#startResults").append('<li><p> <a href="' + link['url'] +'"><b>' + link['title'] + '</b></a></p></li>');*/
					    $("#startResults").append('<tr><td><a href="' + link['url'] +'" target="_blank"><b>' + link['title'] + '</b></a></td></tr>');
					}
			    }
			}
		});
		
	}
	</script>

</body>
</html>
