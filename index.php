<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speech to Text Converter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            padding: 20px;
            margin: 0;
        }
        h1 {
            color: #444;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        textarea {
            width: 100%;
            height: 200px;
            margin-top: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
            resize: none;
        }
        button, select {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button {
            background-color: #007BFF;
            color: #fff;
        }
        button:hover {
            background-color: #0056b3;
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        select {
            background-color: #f8f9fa;
            color: #333;
        }
        select:focus, button:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Speech to Text Converter</h1>
        <button id="startBtn">Start Recording</button>
        <button id="stopBtn" disabled>Stop Recording</button>
        <button id="cleanBtn">Clean Text</button>
        <select id="languageSelect">
            <option value="ar-EG">Arabic</option>
            <option value="en-US">English</option>
        </select>
        <textarea id="outputText" readonly></textarea>
    </div>

    <script>
        let recognition;
        let finalTranscript = '';
        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');
        const cleanBtn = document.getElementById('cleanBtn');
        const outputText = document.getElementById('outputText');
        const languageSelect = document.getElementById('languageSelect');

        startBtn.addEventListener('click', startRecording);
        stopBtn.addEventListener('click', stopRecording);
        cleanBtn.addEventListener('click', cleanText);
        languageSelect.addEventListener('change', updateLanguage);

        function startRecording() {
            if ('webkitSpeechRecognition' in window) {
                recognition = new webkitSpeechRecognition();
                recognition.lang = languageSelect.value;
                recognition.continuous = true;
                recognition.interimResults = true;

                recognition.onresult = function(event) {
                    let interimTranscript = '';
                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        if (event.results[i].isFinal) {
                            finalTranscript += event.results[i][0].transcript + ' ';
                            outputText.value = finalTranscript;
                            saveToDatabase(event.results[i][0].transcript);
                        } else {
                            interimTranscript += event.results[i][0].transcript;
                        }
                    }
                    outputText.value = finalTranscript + interimTranscript;
                };

                recognition.onerror = function(event) {
                    console.error(event.error);
                };

                recognition.start();
                startBtn.disabled = true;
                stopBtn.disabled = false;
            } else {
                alert('Speech recognition not supported in this browser. Use Chrome.');
            }
        }

        function stopRecording() {
            recognition.stop();
            startBtn.disabled = false;
            stopBtn.disabled = true;
        }

        function cleanText() {
            finalTranscript = '';
            outputText.value = '';
        }

        function saveToDatabase(text) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "saveText.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log('Text saved to database: ' + xhr.responseText);
                    } else {
                        console.error('Failed to save text to database: ' + xhr.responseText);
                    }
                }
            };
            xhr.send("text=" + encodeURIComponent(text));
        }

        function updateLanguage() {
            if (recognition) {
                recognition.lang = languageSelect.value;
            }
        }
    </script>
</body>
</html>
