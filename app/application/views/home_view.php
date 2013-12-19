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
	        	<p><label class="cat1"><input type="checkbox" id="cat1Academics" class='cat1' name="Academics" value="Academics">Academics</label><br>
	        		<div id='cat2Academics'>
	        			<p><label class="cat2"><input type="checkbox" class='cat2' name="Administrivia" value="Administrivia">Administrivia</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Advising" value="Advising">Advising</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Choosing Classes" value="Choosing Classes">Choosing Classes</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Concentrations and Secondary Fields" value="Concentrations and Secondary Fields">Concentrations & Secondaries</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="General Education Information" value="General Education Information">General Education Information</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Libraries" value="Libraries">Libraries</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Research" value="Research">Research</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Other" value="Other">Other</label></p>
	        		</div>
	        	</p>
	        	<hr>
	        	<p><label class="cat1"><input type="checkbox" id="cat1Athletics" class='cat1' name="Athletics" value="Athletics">Athletics</label><br></p>
	        	<hr>
	        	<p><label class="cat1"><input type="checkbox" id="cat1Finance" class='cat1' name="Financial Information" value="Financial Information">Financial Information</label><br></p>
	        	<hr>
	        	<p><label class="cat1"><input type="checkbox" id="cat1Health" class='cat1' name="Health and Safety" value="Health and Safety">Health and Safety</label><br>
	        		<div id="cat2Health">
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Immediate Crisis" value="Immediate Crisis">Immediate Crisis</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Mental Health and Wellness" value="Mental Health and Wellness">Mental Health and Wellness</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Other" value="Other">Other</label></p>
	        		</div>
	        	</p>
	        	<hr>
	        	<p><label class="cat1"><input type="checkbox" id="cat1Residential" class='cat1' name="Residential Life" value="Residential Life">Residential Life</label><br>
		        	<div id="cat2Residential">
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Freshmen Living" value="Freshmen Living">Freshmen Living</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="General Information and Policies" value="General Information and Policies">General Information and Policies</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Upperclassmen Houses" value="Upperclassmen Houses">Upperclassmen Houses</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Other" value="Other">Other</label></p>
		        	</div>
	        	</p>
	        	<hr>
	        	<p><label class="cat1"><input type="checkbox" id="cat1Student" class='cat1' name="Student Activities" value="Student Activities">Student Activities</label><br></p>
	        	<hr>
	        	<p><label class="cat1"><input type="checkbox" id="cat1Work" class='cat1' name="Summer, On-Campus and Career Opportunities" value="Summer, On-Campus and Career Opportunities">Summer, On-Campus and &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Career Opportunities</label><br></p>
	        	<hr>
	        </div>
		    <div id='resultsWrapper'>
                <div id="searchHelp">
                    <p>Welcome to the Campus Resources Finder. All URLs that exist on my.harvard are searchable here along with additional links that have been identified by students, GSAS students, and the College administration as being of high value.</p>
                    <p>If you have comments, or suggestions for links that should be included in the database, please let us know.</p>
                </div>
		    	<div id='text_search'>
			    	 <p>&nbsp;&nbsp;Filter These Results: <input type="text" id="textBox" name="textQuery"> &nbsp;</p>
			    </div>
		        <div id='results'>
                    <div id="loadResultsMask" style="display:none">
                        <p class="ajax-loader">
                            Loading... 
                            <img src="<?php echo asset_url() . 'img/ajax-loader.gif'; ?>" />
                        </p>
                    </div>
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

    function emptyresults() {
        var emptyhtml = '<tr class="noresults"><td>No results.</td></tr>';
        $("#startResults").html(emptyhtml)
    }

    function addresult(link) {
        var url = link['url']; 
        var title = link['title'];
        $("#startResults").append('<tr><td><a href="' + link['url'] +'" target="_blank"><b>' + link['title'] + '</b></a></td></tr>');
    }

    function addresults(results) {
        if(results.length == 0) {
            emptyresults();
        } else {
            for (var i=0; i<results.length; i++) {
                addresult(results[i]);
            }
        }
    }

    function resetresults() {
        $("#startResults").html('');
    }
    
    function textFilter() {
        var searchvalue = $("#textBox").val();
        resetresults();
    	if (searchvalue == '') {
            addresults(jsonLinkData);
    	} else {
            addresults($.grep(jsonLinkData, function(link, index) { 
                var needle = searchvalue.toLowerCase();
                var haystack = (link['title'] || link['text']).toLowerCase();
                return (haystack.search(needle) !== -1);
            }));
        }
    }

    function showloadmask(state) {
        $("#loadResultsMask")[state?'show':'hide']();
    }

    function showhelp(state) {
        $("#searchHelp")[state?'show':'hide']();
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

        if(jsonLinkData.length == 0) {
            emptyresults();
        }
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

        showhelp(categories.length==0?true:false);
		console.log(categories);
		
        showloadmask(true);
		$.ajax({
			type: "POST",
	        url: '<?php echo site_url('home/search'); ?>',
	        data: {
	        		categories:JSON.stringify(categories)
	        	  },
	        complete: function (xhr, status) {
                showloadmask(false);
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
                        emptyresults();
			        	return;
			        }
			        $("#text_search").show();
			        $("#results").height(560);
			        jsonLinkData = JSON.parse(xhr.responseText);
                    addresults(jsonLinkData);
			    }
			}
		});
		
	}
	</script>

</body>
</html>
