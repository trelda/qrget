<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>QR Detector</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <input type="file" id="files" multiple/>

        <button id="sendBtn"  onclick="sendFiles()">Send</button>

        <div id="response"></div>
    </body>


    <script type="text/javascript">
        function sendFiles () {
            let files = document.getElementById('files').files;
            var formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }

            const request = new XMLHttpRequest();
            request.responseType = 'text';
            const url = 'ajax.php';
            request.onload = () => {
                document.getElementById('response').innerHTML = request.responseText;
            };
            request.open('POST', url, true);
            request.setRequestHeader('file', formData);
            request.send(formData);
		}
    </script>

</html>