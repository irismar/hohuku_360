<!DOCTYPE html>
<html>
  
<head>
    <style>
        img {
            height: 250px;
            width: 250px;
        }
  
        .center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: 250px;
            border: 3px solid #73AD21;
            padding: 2px;
        }
    </style>
</head>
  
<body>
    <script>
        var images = new Array()
        images = [
"https://media.geeksforgeeks.org/wp-content/uploads/20210721215006/frame1.PNG",
"https://media.geeksforgeeks.org/wp-content/uploads/20210721215014/frame2-200x190.PNG",
"https://media.geeksforgeeks.org/wp-content/uploads/20210721215021/frame3-200x182.PNG"
        ];
  
        setInterval("Animate()", 400);
        var x = 0;
  
        function Animate() {
            document.getElementById("img").src = images[x]
            x++;
            if (images.length == x) {
                x = 0;
            }
        }
    </script>
  
    <div class="center">
        <img id="img" src=
"https://media.geeksforgeeks.org/wp-content/uploads/20210721215006/frame1.PNG">
  
        <h3>Frame by Frame Animation</h3>
    </div>
</body>
  
</html>