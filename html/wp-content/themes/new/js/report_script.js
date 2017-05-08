$(function() {
	$("#loginForm").submit(function(evt) {
		evt.preventDefault();
		console.log("chlciked");
		$.blockUI();
		var data = {
			"username": $("input#inputEmail").val(),
			"pwd": $("input#password").val()
		};
    $.ajax({
      type: 'post',
      data: data,
      url: "/checkPwd/",
      error: function(e) { // your error handler
        $.unblockUI();
        alert("Sorry, wrong password. Please try again later.");
        if (window.developer) {
          alert(JSON.stringify(e));
        }
      },
      success: function(response) {
      	$.unblockUI();
      	console.log(response);
      	$("#pwdModal").remove();
      	$(".passwordProtected").show();
      	if (response == "admin") return;
      	$("select[name=team] option").each(function() {
      		if ($(this).val().toLowerCase() != response) {
      			$(this).remove();

      		}
      	});
      	$("select[name=team]").change();
      	//response is the team name.
      }
	});
	return false;
});


	//$.blockUI();
	var $range = "'Aggregate individual stats'!A23:G42";
	$.get(query($range)).then(function(res) {
		$.unblockUI();
		var lastRow = res.values[1];
		var $mainTable = $(".mainTable");
		//window.res = res;
		for (r in res.values) {
			var row = res.values[r];
			var $mainRow = $("<tr>");
			if (r == 15) break;
			row.splice(2, 0, row[6]);
			row.splice(6, 1);
			for (c in row) {
				var cell = row[c];
				if (c == 0 && !cell) continue;
				if (c > 2 && c < 6) {
					cell = "$" + cell;
				}
				if (c == 6) continue; //rank
				$("<td>").text(cell).appendTo($mainRow);
			}
			$mainTable.append($mainRow);
		}
	});
	$(".results").hide();
	var globalStore = {};
	var team;
	$("input[name=families], input[name=sponsors]").click(function() { $(this).select() });
	$("select[name=team]").append("<option value=Bala>Team Bala</option><option value=Yuva>Team Yuva</option>");
	$("select[name=team]").change(function() {
		team = $(this).val();
		//$.blockUI();
		if (window.res) {
			updateResults(window.res);
			return;
		}
		$.get(query("'Total signups'!A1:AA")).then(updateResults);
	});
	var CSS_COLOR_NAMES = ["AliceBlue", "AntiqueWhite", "Aqua", "Aquamarine", "Azure", "Beige", "Bisque", "Black", "BlanchedAlmond", "Blue", "BlueViolet", "Brown", "BurlyWood", "CadetBlue", "Chartreuse", "Chocolate", "Coral", "CornflowerBlue", "Cornsilk", "Crimson", "Cyan", "DarkBlue", "DarkCyan", "DarkGoldenRod", "DarkGray", "DarkGrey", "DarkGreen", "DarkKhaki", "DarkMagenta", "DarkOliveGreen", "Darkorange", "DarkOrchid", "DarkRed", "DarkSalmon", "DarkSeaGreen", "DarkSlateBlue", "DarkSlateGray", "DarkSlateGrey", "DarkTurquoise", "DarkViolet", "DeepPink", "DeepSkyBlue", "DimGray", "DimGrey", "DodgerBlue", "FireBrick", "FloralWhite", "ForestGreen", "Fuchsia", "Gainsboro", "GhostWhite", "Gold", "GoldenRod", "Gray", "Grey", "Green", "GreenYellow", "HoneyDew", "HotPink", "IndianRed", "Indigo", "Ivory", "Khaki", "Lavender", "LavenderBlush", "LawnGreen", "LemonChiffon", "LightBlue", "LightCoral", "LightCyan", "LightGoldenRodYellow", "LightGray", "LightGrey", "LightGreen", "LightPink", "LightSalmon", "LightSeaGreen", "LightSkyBlue", "LightSlateGray", "LightSlateGrey", "LightSteelBlue", "LightYellow", "Lime", "LimeGreen", "Linen", "Magenta", "Maroon", "MediumAquaMarine", "MediumBlue", "MediumOrchid", "MediumPurple", "MediumSeaGreen", "MediumSlateBlue", "MediumSpringGreen", "MediumTurquoise", "MediumVioletRed", "MidnightBlue", "MintCream", "MistyRose", "Moccasin", "NavajoWhite", "Navy", "OldLace", "Olive", "OliveDrab", "Orange", "OrangeRed", "Orchid", "PaleGoldenRod", "PaleGreen", "PaleTurquoise", "PaleVioletRed", "PapayaWhip", "PeachPuff", "Peru", "Pink", "Plum", "PowderBlue", "Purple", "Red", "RosyBrown", "RoyalBlue", "SaddleBrown", "Salmon", "SandyBrown", "SeaGreen", "SeaShell", "Sienna", "Silver", "SkyBlue", "SlateBlue", "SlateGray", "SlateGrey", "Snow", "SpringGreen", "SteelBlue", "Tan", "Teal", "Thistle", "Tomato", "Turquoise", "Violet", "Wheat", "White", "WhiteSmoke", "Yellow", "YellowGreen"];

	function updateResults(res) {
		console.log(res);
		window.res = res;
		var $familyTable = $("table.families");
		var $individualTable = $("table.individuals");
		var $sponsorTable = $("table.sponsors");
		$("table.families, table.individuals, table.sponsors").find("td").remove();
		var empty = true;
		var familyEmailList = [];
		var sponsorEmailList = [];
		for (r in res.values) {
			var row = res.values[r];
			var $familyRow = $("<tr>");
			var $sponsorRow = $("<tr>");
			if (row[6] != team) continue;

			var $$rowToAppend = row[2] == "registration" ? $familyRow : $sponsorRow;
			for (c in row) {
				
				if (c == 1) {row[c] = row[c].slice(-3);}
				var cell = row[c];
				if ($$rowToAppend == $familyRow && (c == 9 || c == 12 || c == 15 || c == 18 || c == 21)) { //walker1, walker2, ... walker5
					var $individualRow = $("<tr>");
					$individualRow.css("id", row[1]);
					var individFields = [row[1], row[c], row[parseInt(c)+1], row[parseInt(c) + 2]];
					if (row[c] == "") continue;
					for (i in individFields) {
						console.log(i, individFields);
						var $td = $("<td>");
						$td.text(individFields[i]);
						if (i == 0) {
							$td.addClass("idTd").attr("id", row[1]).css("background-color", getColor(parseInt(row[1])));
						}
						$td.appendTo($individualRow);
					}
					$individualTable.append($individualRow);
				}
				var fieldsToReport = [
				0, //timestamp
				1, //id
				4, //email
				5, //address
				7, //amount donated
				9, //name
				25, //phone number
				26, //referred
				];
				if (!~fieldsToReport.indexOf(parseInt(c))) continue;
				if (c == 7) { //amount donated
					cell = "$" + cell;
				}
				empty = false;
				var $td = $("<td>").text(cell);
				if ($$rowToAppend == $familyRow && c == 1) { //id
					$td.html("<a href='#" + $td.text() + "' >" + cell + "</a>").addClass("idTd").css("background-color", getColor(parseInt(row[1])));
				}
				$td.appendTo($$rowToAppend);
				if ($$rowToAppend == $familyRow && c == 4) { //email
					familyEmailList.push(cell);
				} else if (c == 4 && $$rowToAppend == $sponsorRow) {
					sponsorEmailList.push(cell);
				}
			}
			if ($$rowToAppend == $familyRow) {
				$familyTable.append($familyRow);
			} else {
				$sponsorTable.append($sponsorRow);
			}
		}
		if (empty) {
			var text = "<tr><td>Sorry, no results found.</td></tr>";
			$("table.families, table.individuals, table.sponsors").append(text);
		} else {
			$("input[name=families]").val(familyEmailList.join(","));
			$("input[name=sponsors]").val(sponsorEmailList.join(","));
		}
		$(".teamName").text(team);
		$(".teamLink").attr("href","/donate/?t="+team);
		$.unblockUI();
		$(".results").slideDown();
	}

	function getColor(seed) {
		/*var f = 100;
		var a1 = f - seed % (255 - f);
		var a2 = 100 - seed % (100 - f);
		var a3 = 50 - seed % (50 - f);
		return "rgb(" + a1 + "," + a1 + "," + a3 + ")";*/
		var CSS_COLOR_NAMES = ["rgba(20,10,200,.7)", "rgba(20,100,80,.2)", "rgba(40,200,80,.2)", "rgba(5,40,200,.2)", "rgba(200,0,80,.2)", "rgba(150,170,30,.2)"];
		//CSS_COLOR_NAMES = 
		return CSS_COLOR_NAMES[seed % CSS_COLOR_NAMES.length];
	}

	function update(range, callback) {
		//if (callback) return;
		return $.get(query(range));
	}

	function query(range) {
		return "https://sheets.googleapis.com/v4/spreadsheets/1eXYberMxmy8c9vV4N1_pM1WyE5AVcNgiK9YKkApIw0U/values/" + range + "?key=AIzaSyBG2JJkYhiFHwhvQn_vGMcZihbwIBxvS_o";
	}
});