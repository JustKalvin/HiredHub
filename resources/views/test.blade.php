<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF & Data ke N8N</title>
</head>

<body>
    <h2>Upload PDF dan Data ke N8N</h2>

    <label for="pdfFile">Pilih File PDF:</label><br>
    <input type="file" id="pdfFile" accept="application/pdf"><br><br>

    <label for="keyword">Keyword:</label><br>
    <input type="text" id="keyword" placeholder="Masukkan keyword"><br><br>

    <label for="geoId">Geo ID:</label><br>
    <input type="text" id="geoId" placeholder="Masukkan geoId"><br><br>

    <button id="uploadBtn">Kirim ke N8N</button>

    <p id="status"></p>

    <script>
        const uploadBtn = document.getElementById('uploadBtn');
        const statusEl = document.getElementById('status');

        uploadBtn.addEventListener('click', async () => {
            const fileInput = document.getElementById('pdfFile');
            const keywordInput = document.getElementById('keyword');
            const geoIdInput = document.getElementById('geoId');

            const file = fileInput.files[0];
            const keyword = keywordInput.value.trim();
            const geoId = geoIdInput.value.trim();


            // Buat FormData dan tambahkan semua data
            const formData = new FormData();
            formData.append('file', file);
            formData.append('keyword', keyword);
            formData.append('geoId', geoId);

            try {
                statusEl.textContent = 'Sedang mengupload...';

                const response = await fetch('https://upinganteng123.app.n8n.cloud/webhook-test/jobscrapping', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const result = await response.text(); // gunakan .json() jika response berupa JSON
                statusEl.textContent = '✅ Berhasil dikirim! Respons: ' + result;
            } catch (error) {
                statusEl.textContent = '❌ Terjadi kesalahan: ' + error.message;
            }
        });
    </script>
</body>

</html>
