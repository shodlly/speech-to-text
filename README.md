# speech-to-text

This project is a web-based application that leverages the Web Speech API to convert spoken words into text. The application provides real-time speech recognition, supports multiple languages, and allows users to save and view their transcriptions, which are stored in a MySQL database.

## Features

- **Speech Recognition**: Users can record their speech and have it transcribed into text in real time.
- **Language Selection**: Supports speech recognition in both English and Arabic.
- **Save Transcriptions**: Users can save the transcribed text to a MySQL database.
- **View Transcriptions**: Users can view all saved transcriptions in a list format.

## Technologies Used

- **HTML/CSS**: For creating the front-end user interface.
- **JavaScript**: To handle speech recognition and user interactions.
- **PHP**: For server-side logic and database operations.
- **MySQL**: To store and manage transcriptions.

## File Overview

### `index.html`

The main HTML file for the application, which includes:

- **Speech Recognition Interface**: Buttons to start and stop recording speech.
- **Language Selector**: Dropdown menu for selecting the language (English or Arabic).
- **Transcription Display**: Area to display the recognized text.
- **Save Button**: Allows users to save the transcribed text to the database.

```html
<!-- Sample HTML Structure -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speech to Text</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Speech to Text</h1>
        <select id="language-select">
            <option value="en-US">English</option>
            <option value="ar">Arabic</option>
        </select>
        <div class="buttons">
            <button id="start-record-btn">Start Recording</button>
            <button id="stop-record-btn" disabled>Stop Recording</button>
        </div>
        <p id="status"></p>
        <p id="transcription"></p>
        <form id="transcription-form" action="transcribe.php" method="POST">
            <input type="hidden" name="transcription" id="transcription-input">
            <button type="submit" id="save-btn" disabled>Save Transcription</button>
        </form>
        <a href="view_transcriptions.php">View Transcriptions</a>
    </div>

    <script src="app.js"></script>
</body>
</html>
```

### `transcribe.php`

This PHP script handles saving the transcriptions to a MySQL database. It:

- Connects to the MySQL database.
- Inserts the transcription into the `transcriptions` table.
- Displays a link to view saved transcriptions.

```php
<?php
if (isset($_POST['transcription'])) {
    $transcription = $_POST['transcription'];

    $conn = new mysqli('localhost', 'root', '', 'speech_to_text'); // Update credentials here

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO transcriptions (text, transcription_time) VALUES (?, NOW())");
    $stmt->bind_param('s', $transcription);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo "Transcription saved successfully. <a href='view_transcriptions.php'>View transcriptions</a>";
} else {
    echo 'No transcription received.';
}
?>
```

### `view_transcriptions.php`

This PHP script displays all saved transcriptions in a table format. It:

- Connects to the MySQL database.
- Retrieves and displays all transcriptions, sorted by time.

```php
<?php
$conn = new mysqli('localhost', 'root', '', 'speech_to_text'); // Update credentials here

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, text, transcription_time FROM transcriptions ORDER BY transcription_time DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcriptions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Saved Transcriptions</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Text</th>
            <th>Transcription Time</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['text']}</td>
                        <td>{$row['transcription_time']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No transcriptions found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <a href="index.html">Go back</a>
</body>
</html>
```

### `styles.css`

This file contains the CSS styles for the application, including layout, typography, and button styles.

```css
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    max-width: 600px;
    width: 100%;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.buttons {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
}

h1 {
    color: #333;
    text-transform: uppercase;
    margin-bottom: 20px;
}

button {
    margin: 10px;
    padding: 12px 24px;
    font-size: 16px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #45a049;
}

select {
    padding: 10px;
    font-size: 16px;
    margin-bottom: 20px;
    border-radius: 4px;
    border: 1px solid #ddd;
    background-color: #fff;
    cursor: pointer;
}

p {
    margin: 10px 0;
    color: #333;
}

a {
    display: block;
    margin-top: 20px;
    text-align: center;
    text-decoration: none;
    color: #007BFF;
}

a:hover {
    text-decoration: underline;
}
```

## Screenshots
  
*Speech Recognition Interface*

![صورة واتساب بتاريخ 1446-02-12 في 16 17 25_f3168bc7](https://github.com/user-attachments/assets/3fc1c1c2-73a4-4048-908a-f25c181c13a2)

*Saved Transcriptions*

![صورة واتساب بتاريخ 1446-02-12 في 16 17 55_5700f277](https://github.com/user-attachments/assets/d7638b63-5825-480f-b0f0-925041d8f2c4)

