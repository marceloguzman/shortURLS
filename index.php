<!DOCTYPE html>
<html>
<title>shortURLS : a URL shortener</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8"	/>
<meta name="robots" content="noindex, nofollow">

<body>
    <form autocomplete="off" method="post" action="shorten.php" id="shortener" class="form-style-5">
        <label for="longurl">URL to shorten</label> <input placeholder="http://             Paste a link to start" type="text" name="longurl" id="longurl"> <input type="submit" value="Shorten">
        <div id="resultbox" class="hidden">
            <input type="text" name="longurl_result" id="longurl_result">
            <button id="copyButton" class="copybutton">Copy</button>
        </div>
    </form>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script>
        $(function () {
			$('#shortener').submit(function () {
				$.ajax({data: {longurl: $('#longurl').val()}, url: 'shortURLS/shorten.php', complete: function (XMLHttpRequest, textStatus) {
					$('#longurl_result_text').text(XMLHttpRequest.responseText);
					$('#longurl_result').val(XMLHttpRequest.responseText);
					
					$('#resultbox').addClass("visible");

				}});
			return false;
			});
		});

		// https://stackoverflow.com/questions/22581345/click-button-copy-to-clipboard-using-jquery
		document.getElementById("copyButton").addEventListener("click", function() {
		    copyToClipboard(document.getElementById("longurl_result"));
		});

		function copyToClipboard(elem) {
			  // create hidden text element, if it doesn't already exist
		    var targetId = "_hiddenCopyText_";
		    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
		    var origSelectionStart, origSelectionEnd;
		    if (isInput) {
		        // can just use the original source element for the selection and copy
		        target = elem;
		        origSelectionStart = elem.selectionStart;
		        origSelectionEnd = elem.selectionEnd;
		    } else {
		        // must use a temporary form element for the selection and copy
		        target = document.getElementById(targetId);
		        if (!target) {
		            var target = document.createElement("textarea");
		            target.style.position = "absolute";
		            target.style.left = "-9999px";
		            target.style.top = "0";
		            target.id = targetId;
		            document.body.appendChild(target);
		        }
		        target.textContent = elem.textContent;
		    }
		    // select the content
		    var currentFocus = document.activeElement;
		    target.focus();
		    target.setSelectionRange(0, target.value.length);
		    
		    // copy the selection
		    var succeed;
		    try {
		    	  succeed = document.execCommand("copy");
		    } catch(e) {
		        succeed = false;
		    }
		    // restore original focus
		    if (currentFocus && typeof currentFocus.focus === "function") {
		        currentFocus.focus();
		    }
		    
		    if (isInput) {
		        // restore prior selection
		        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
		    } else {
		        // clear temporary content
		        target.textContent = "";
		    }
		    return succeed;
		}

</script>
    <!--https://www.sanwebe.com/2014/08/css-html-forms-designs-->
    <style type="text/css">
    html {
        align-items: center;
        display: flex;
        font-size: 16px;
        font-weight: 400;
        height: 100%;
        justify-content: center;
        line-height: 28px;
        margin: 0;
        padding: 0;
        text-align: left;
        width: 100%;
    }

    body {
        width: 100%;
    }

    .form-style-5 {
        max-width: 600px;
        padding: 10px 20px;
        background: #f4f7f8;
        margin: 10px auto;
        background: #f4f7f8;
        border-radius: 8px;
        font-family: Georgia, "Times New Roman", Times, serif;
    }

    .form-style-5 fieldset {
        border: none;
    }

    .form-style-5 legend {
        font-size: 1.4em;
        margin-bottom: 10px;
    }

    .form-style-5 label {
        display: block;
        margin-bottom: 8px;
    }

    .form-style-5 input[type="text"],
    .form-style-5 input[type="date"],
    .form-style-5 input[type="datetime"],
    .form-style-5 input[type="email"],
    .form-style-5 input[type="number"],
    .form-style-5 input[type="search"],
    .form-style-5 input[type="time"],
    .form-style-5 input[type="url"],
    .form-style-5 textarea,
    .form-style-5 select {
        font-family: Georgia, "Times New Roman", Times, serif;
        background: rgba(255, 255, 255, .1);
        border: none;
        border-radius: 4px;
        font-size: 15px;
        margin: 0;
        outline: 0;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        background-color: #e8eeef;
        color: #777;
        -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
        box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
        margin-bottom: 30px;
    }

    .form-style-5 input[type="text"]:focus,
    .form-style-5 input[type="date"]:focus,
    .form-style-5 input[type="datetime"]:focus,
    .form-style-5 input[type="email"]:focus,
    .form-style-5 input[type="number"]:focus,
    .form-style-5 input[type="search"]:focus,
    .form-style-5 input[type="time"]:focus,
    .form-style-5 input[type="url"]:focus,
    .form-style-5 textarea:focus,
    .form-style-5 select:focus {
        background: #d2d9dd;
    }

    .form-style-5 select {
        -webkit-appearance: menulist-button;
        height: 35px;
    }

    .form-style-5 .number {
        background: #1abc9c;
        color: #fff;
        height: 30px;
        width: 30px;
        display: inline-block;
        font-size: 0.8em;
        margin-right: 4px;
        line-height: 30px;
        text-align: center;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.2);
        border-radius: 15px 15px 15px 0px;
    }

    .form-style-5 input[type="submit"],
    .form-style-5 input[type="button"],
    .copybutton {
        position: relative;
        display: block;
        padding: 6px 39px;
        color: #FFF;
        margin: 0 auto;
        background: #1abc9c;
        font-size: 18px;
        text-align: center;
        font-style: normal;
        width: 30%;
        border: 1px solid #16a085;
        border-width: 1px 1px 3px;
        margin-bottom: 10px;
        border-radius: 7px;
        display: inline;
    }

    .form-style-5 input[type="submit"]:hover,
    .form-style-5 input[type="button"]:hover {
        background: #109177;
    }

    #longurl {
        width: 65%;
        margin-right: 20px;
    }

    .hidden {
        display: none;
    }

    .visible {
        display: initial;
    }

    #longurl_result {
        width: 250px;
        padding-right: 20px;
    }


    #copyButton {
        width: auto;
        padding: 6px 20px;
    }

    #resultbox {
        margin: auto;
        width: 80%;
    }
    </style>
</body>

</html>