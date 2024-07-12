<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload and List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        #dropZone {
            width: 100%;
            padding: 50px;
            border: 2px dashed #ccc;
            text-align: center;
            margin-top: 20px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        input[type="file"] {
            display: none;
        }
    </style>
</head>
<body>

<h2>Upload File</h2>
<form id="uploadForm" enctype="multipart/form-data">
    <input type="file" id="fileInput" multiple>
    <div id="dropZone">Drop files here or click to upload</div>
    <button type="submit">Upload</button>
</form>

<h2>List of Files</h2>
<table id="fileTable">
    <thead>
        <tr>
            <th>Time</th>
            <th>File Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script>
    document.getElementById('dropZone').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });

    document.getElementById('dropZone').addEventListener('dragover', function(event) {
        event.preventDefault();
        event.stopPropagation();
        this.style.backgroundColor = '#f0f0f0';
    });

    document.getElementById('dropZone').addEventListener('dragleave', function(event) {
        event.preventDefault();
        event.stopPropagation();
        this.style.backgroundColor = '#fff';
    });

    document.getElementById('dropZone').addEventListener('drop', function(event) {
        event.preventDefault();
        event.stopPropagation();
        this.style.backgroundColor = '#fff';

        let files = event.dataTransfer.files;
        handleFiles(files);
    });

    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        let files = document.getElementById('fileInput').files;
        handleFiles(files);
    });

    function handleFiles(files) {
        let tableBody = document.getElementById('fileTable').getElementsByTagName('tbody')[0];

        for (let file of files) {
            let newRow = tableBody.insertRow();
            let cellTime = newRow.insertCell(0);
            let cellName = newRow.insertCell(1);
            let cellStatus = newRow.insertCell(2);

            cellTime.textContent = new Date().toLocaleString();
            cellName.textContent = file.name;
            cellStatus.textContent = 'Uploaded';
        }

        document.getElementById('fileInput').value = ''; // Clear the input after listing the files
    }
</script>

</body>
</html>
