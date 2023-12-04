document.addEventListener("mousemove", function(event) {
            var highlight = document.getElementById("highlight");
            highlight.style.top = event.pageY + "px";
            highlight.style.left = event.pageX + "px";
        });