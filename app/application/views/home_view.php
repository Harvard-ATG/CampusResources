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

	    <div class="body">
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
                    Select a category to get started. <a href="https://huit.uservoice.com/forums/177074/category/77985" target="_blank">Send us your feedback</a>.
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
        <div class="footer"><a href="https://github.com/Harvard-ATG/CampusResources/wiki" target="_blank">Resource finder</a> built by Anne Madoff '15 and Balaji Pandian '15.</div>
    </div>

    <script>
(function() {
    var jsonLinkData = []; // updated via AJAX call
    var AJAX_SEARCH_URL = '<?php echo site_url('home/search'); ?>';
    var debug = false;

    function logdata() {
        // delegate to console.log when debugging is enabled
        if(debug) {
            console.log.apply(console, arguments);
        }
    }

    function emptyresults() {
        var emptyhtml = '<tr class="noresults"><td>No results.</td></tr>';
        $("#startResults").html(emptyhtml)
    }

    function addresult(link) {
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
        var filterDelay = 400; // ms
        var textSearch = $('#textBox');
        textSearch.keyup(function(e) {
	        clearTimeout(timer);

            // filter immediately if the user pressed ENTER, otherwise, user is
            // still typing so let's wait a bit more until they're done
            if(e.keyCode == 13) {
                textFilter();
            } else {
                timer = setTimeout(textFilter, filterDelay);
            }
	    });

        if(jsonLinkData.length == 0) {
            emptyresults();
        }
    });

	function search()
	{
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

		logdata(categories);
		
        showloadmask(true);
		$.ajax({
			type: "POST",
	        url: AJAX_SEARCH_URL,
	        data: {
	        		categories:JSON.stringify(categories)
	        	  },
	        complete: function (xhr, status) {
	        	logdata(xhr);
                showhelp(categories.length==0?true:false);
                resetresults();
		    	if (status === 'error' || xhr.statusText != "OK") {
			        alert("Could not complete search.");
			    } else {
			        // Success
			        if (xhr.responseText == "") {
			        	$("#textBox").val("");
			        	$("#text_search").hide();
                        emptyresults()
			        } else {
                        $("#text_search").show();
                        jsonLinkData = JSON.parse(xhr.responseText);
                        addresults(jsonLinkData);
                    }
			    }
                showloadmask(false);
			}
		});
		
	}
})();
	</script>

    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-46595028-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
</body>
</html>
