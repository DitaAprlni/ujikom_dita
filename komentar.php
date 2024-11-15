<?php
include 'koneksi.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['FotoID'], $_POST['UserID'], $_POST['IsiKomentar'])) {
        $FotoID = $conn->real_escape_string($_POST['FotoID']);
        $UserID = $conn->real_escape_string($_POST['UserID']);
        $IsiKomentar = $conn->real_escape_string($_POST['IsiKomentar']);
                      
        // Menyimpan komentar ke database
        $sql = "INSERT INTO komentar_foto (FotoID, UserID, IsiKomentar) VALUES ('$FotoID', '$UserID', '$IsiKomentar')";
        if ($conn->query($sql) === TRUE) {
            echo "Komentar berhasil ditambahkan!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Data komentar tidak lengkap."; 
    }
}

// Mengambil semua komentar
$sql = "SELECT * FROM komentar_foto ORDER BY TanggalKomentar DESC";
$result = $conn->query($sql);
?> 
  
  <html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></link>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script>
        function showCommentPrompt(fotoID) {
            const userComment = prompt("localhost says: Tambahkan komentar Anda:");
            if (userComment) {
                document.getElementById('FotoID').value = fotoID;
                document.getElementById('UserID').value = '1'; // Ganti dengan UserID yang sesuai
                document.getElementById('IsiKomentar').value = userComment;
                document.getElementById('commentForm').submit();
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-roboto">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">All Comments:</h2>
        <div class="bg-white shadow-md rounded-lg p-4 mb-6">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">No</th>
                        <th class="py-2">FotoID</th>
                        <th class="py-2">UserID</th>
                        <th class="py-2">IsiKomentar</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'koneksi.php'; 

                    // Mengambil semua komentar
                    $sql = "SELECT * FROM komentar_foto ORDER BY TanggalKomentar DESC";
                    $result = $conn->query($sql);

                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        $fotoID = $row['FotoID'];
                        $commentCountResult = $conn->query("SELECT COUNT(*) as count FROM komentar_foto WHERE FotoID = '$fotoID'");
                        $commentCount = $commentCountResult->fetch_assoc()['count'];
                        echo "
                        <tr class='border-t'>
                          <td class='py-2 px-4'>{$i}</td>
                          <td class='py-2 px-4'>{$row['FotoID']}</td>
                          <td class='py-2 px-4'>{$row['UserID']}</td>
                          <td class='py-2 px-4'>{$row['IsiKomentar']}</td>
                          <td class='py-2 px-4'>
                            <a href='javascript:void(0);' onclick='showCommentPrompt({$row['FotoID']})' style='display: inline-block; margin-top: 10px; color: blue; text-decoration: none;'>
                                <i class='fas fa-comment'></i> ({$commentCount})
                            </a>
                          </td>
                        </tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-xl font-bold mb-4">Add a Comment</h3>
            <form id="commentForm" method="POST" action="">
                <input type="hidden" id="FotoID" name="FotoID">
                <input type="hidden" id="UserID" name="UserID">
                <input type="hidden" id="IsiKomentar" name="IsiKomentar">
                <div class="mb-4">
                    <label for="FotoID" class="block text-gray-700">FotoID</label>
                    <input type="text" id="FotoID" name="FotoID" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="UserID" class="block text-gray-700">UserID</label>
                    <input type="text" id="UserID" name="UserID" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <script>
    function updateFotoID() {
        const fotoInput = document.getElementById('Foto');
        const fotoIDInput = document.getElementById('FotoID');
        
        // Jika ada file yang dipilih, buat FotoID sebagai nama file atau ID unik
        if (fotoInput.files.length > 0) {
            const fileName = fotoInput.files[0].name; // Menggunakan nama file sebagai FotoID
            fotoIDInput.value = fileName; // Set FotoID otomatis
        }
    }
</script>
                <div class="mb-4">
                    <label for="IsiKomentar" class="block text-gray-700">IsiKomentar</label>
                    <textarea id="IsiKomentar" name="IsiKomentar" class="w-full px-3 py-2 border rounded-lg" placeholder="Tulis komentar Anda" required></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Kirim</button>
            </form>
        </div>
    </div>
</body>
</html>