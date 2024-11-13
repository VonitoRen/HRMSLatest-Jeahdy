<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <form id="imageForm" enctype="multipart/form-data">
        <input type="file" id="imageInput" name="image" accept="image/*">
        <button type="submit">Upload Image</button>
    </form>

    <div id="progressBarContainer" style="display: none;">
        <div id="progressBar" style="width: 0%; background-color: green;"></div>
        <div id="progressText">Uploading...</div>
    </div>

    <script>
        const form = document.getElementById('imageForm');
        const progressBarContainer = document.getElementById('progressBarContainer');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', 'adduser.php', true);

            xhr.upload.onprogress = function(event) {
                if (event.lengthComputable) {
                    const percentComplete = (event.loaded / event.total) * 100;
                    progressBar.style.width = percentComplete + '%';
                    progressText.innerText = 'Uploading... ' + Math.round(percentComplete) + '%';
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Image Successfully Uploaded',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    resetForm();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while uploading the image. Please try again later.'
                    });
                }
            };

            xhr.onerror = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while uploading the image. Please try again later.'
                });
            };

            xhr.send(formData);

            progressBarContainer.style.display = 'block';
        });

        function resetForm() {
            form.reset();
            progressBarContainer.style.display = 'none';
            progressBar.style.width = '0%';
            progressText.innerText = 'Uploading...';
        }
    </script>
</body>
</html>
