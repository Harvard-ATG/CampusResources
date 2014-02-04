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
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Libraries" value="Libraries">Libraries</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Teaching" value="Teaching">Teaching</label></p>
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
	        	<p><label class="cat1"><input type="checkbox" id="cat1InformationTechnology" class='cat1' name="Information Technology" value="Information Technology">Information Technology</label><br></p>
	        	<hr>
	        	<p><label class="cat1"><input type="checkbox" id="cat1Residential" class='cat1' name="Residential Life" value="Residential Life">Residential Life</label><br>
		        	<div id="cat2Residential">
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Dorm Living" value="Dorm Living">Dorm Living</label></p>
			        	<p><label class="cat2"><input type="checkbox" class='cat2' name="Other" value="Other">Other</label></p>
		        	</div>
	        	</p>
	        	<hr>
	        	<p><label class="cat1"><input type="checkbox" id="cat1Student" class='cat1' name="Student Activities" value="Student Activities">Student Activities</label><br></p>
	        	<hr>
	        	<p><label class="cat1"><input type="checkbox" id="cat1Work" class='cat1' name="Summer, On-Campus and Career Opportunities" value="Summer, On-Campus and Career Opportunities">Summer, On-Campus and &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Career Opportunities</label><br></p>
	        </div>
		    <div id='resultsWrapper'>
                <div id="searchHelp">
                    Select a category to get started. <a href="https://huit.uservoice.com/forums/239961-resource-finder" target="_blank">Send us your link suggestions</a>.
                </div>
		    	<div id='text_search'>
			    	 <p>&nbsp;&nbsp;<label for="textBox">Filter These Results: </label><input type="text" id="textBox" name="textQuery"> &nbsp;</p>
			    </div>
		        <div id='results'>
                    <div id="loadResultsMask" style="display:none">
                        <p class="ajax-loader">
                            Loading... 
                            <img src="<?php echo asset_url() . 'img/ajax-loader.gif'; ?>" />
                        </p>
                    </div>
		            <table id='resultsTable' aria-live="polite">
						<tbody id ='startResults'>
						</tbody>
		            </table>
				</div>
		    </div>
            <div style="clear:both"/></div>
	    </div>
        <div class="footer"><a href="https://github.com/Harvard-ATG/CampusResources/wiki" target="_blank">Resource finder</a> built by Anne Madoff '15 and Balaji Pandian '15.</div>
    </div>

    <script>
(function() {
    var DEBUG = false;
    var AJAX_SEARCH_URL = '<?php echo site_url('home/search'); ?>';
	var CATEGORIES = [
		['#cat1Academics', '#cat2Academics'],
		['#cat1Athletics', false],
		['#cat1Health', '#cat2Health'],
		['#cat1Residential', '#cat2Residential'],
		['#cat1Student', false],
		['#cat1Work', false],
		['#cat1Finance', false],
		['#cat1InformationTechnology', false]
	];

    var jsonLinkData = []; // updated via AJAX call

    function logdata() {
        // delegate to console.log when debugging is enabled
        if(DEBUG) {
            console.log.apply(console, arguments);
        }
    }

    function emptyresults() {
        var msg = '<tr class="noresults"><td>No results</td></tr>';
        $("#startResults").html(msg)
    }

	function emptycategoryresults() {
		var msg = '<tr class="noresults"><td>Now select specific sub-categories to see results</td></tr>';
		$("#startResults").html(msg);
	}

    function addresult(link) {
		safe_title = link['title'].replace('"', '&quot;').replace('<', '&lt;');
		$("#startResults").append('<tr><td><a href="'+link['url']+'" target="_blank" class="link">'+safe_title+'</a></td></tr>');
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

	function selectedcategories() {
		var categories = [];
		var missing_subcategories = [];
		var selected = {};

		$.each(CATEGORIES, function(index, value) {
			var $cat1 = $(value[0]);
			var $cat2 = (value[1] ? $(value[1] + " input") : false);
			var cat_name = $cat1.attr("name");
			var cat_object = {};

			cat_object[cat_name] = [];

			if($cat1.is(":checked")) {
				if($cat2 === false) {
					categories.push(cat_object);
				} else {
					$cat2.each(function() {
						if($(this).is(":checked")) {
							cat_object[cat_name].push(this.name);
						}
					});

					// In order to add a category with sub-categories to the list,
					// at least one of the sub-categories must be selected.
					if(cat_object[cat_name].length > 0) {
						categories.push(cat_object);
					} else {
						missing_subcategories.push(cat_object);
					}

				}
			}
		});

		return {categories: categories, missing_subcategories: missing_subcategories};
	}

	function search(event)
	{
		var selected = selectedcategories();
		var has_missing_subcategories = selected.missing_subcategories.length > 0;
		var categories = selected.categories;
		var data = { categories:JSON.stringify(selected.categories) };

		$("#textBox").val("");
		trackEvent('link-category', event.target);
		logdata(selected);
        showloadmask(true);

		$.ajax({
			type: "POST",
	        url: AJAX_SEARCH_URL,
	        data: data,
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
						if(has_missing_subcategories) {
							emptycategoryresults();
						} else {
							emptyresults()
						}
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

	function onClickResults(event) {
		if($(event.target).is('a.link')) {
			trackEvent('link', event.target);		
		}
	}

	function trackEvent(eventCategory, target) {
		// Google analytics must be loaded for tracking...
		if(!ga) {
			return;
		}

		var data = {
			'hitType': 'event',
			'eventCategory': eventCategory,
			'eventAction': 'click',
			'eventLabel': '',
			'eventValue': 1
		};

		switch(eventCategory) {
			case 'link':
				data.eventLabel = target.href;
				ga('send', data);
				break;
			case 'link-category':
				if(target.checked) {
					data.eventLabel = target.value;
					ga('send', data);
				}
				break;
			default:
				console.log("invalid event category", eventCategory);
				return; 
		}
	}
    
    $(document).ready(function(){
        // Hide everything
    	$("#startResults").html("").on("click", onClickResults);
    	$("#textBox").val("");
    	$("#text_search").hide();
    	
    	$(".cat1").attr("checked",false);
    	$(".cat2").attr("checked",false);
    	
		// setup slide behavior on categories with sub-categories	
		$.each(CATEGORIES, function(index, value) {
			var cat1 = value[0], cat2 = value[1];
			if(cat2 !== false) {
				$(cat2).hide();
				$(cat1).bind("change", function() {
					if($(cat1).is(":checked")) {
						$(cat2).slideDown();
					} else {
						$(cat2).slideUp();
						$(cat2 + " input").each(function() {
							$(this).attr("checked", false);
						});
					}
				});
			}
		});
        
		// setup search behavior whenever a checkbox is changed
        $("#checkboxes input").bind('change', search);
        
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
})();
	</script>

    <?php $this->load->view("googleanalytics"); ?>
</body>
</html>
