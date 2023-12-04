<!DOCTYPE html>
<html>
<head>
    <title>Подсветка фона вокруг курсора</title>
    <style>
        #highlight {
            position: fixed;
            pointer-events: none;
           	background-color: yellow;
		   	
            opacity: 0.5;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            transform: translate(-50%, -50%);
            z-index: 9999;
		}
		#highlight2 {
    		position: fixed;
			pointer-events: none;
    		/*background-color: yellow;*/

    		background-image: url("../img/background.jpg");
    		opacity: 0.5;
    		border-radius: 50%;
    		width: 100px;
    		height: 100px;
    		transform: translate(-50%, -50%);
    		z-index: 9999;
		}    
    </style>
</head>
<body id = "highlight2" >
    <div id="highlight"></div>

    <script>
        document.addEventListener("mousemove", function(event) {
            var highlight = document.getElementById("highlight");
            highlight.style.top = event.pageY + "px";
            highlight.style.left = event.pageX + "px";
        });
    </script>
</body>
</html>
