<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raxsa Catalog</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Gaya untuk body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Putih keabu-abuan untuk latar belakang */
            color: #333; /* Warna teks utama */
            padding: 20px;
        }

        /* Header */
        h1 {
            text-align: center;
            color: #fff;
            background-color: #000; /* Warna hitam untuk kontras */
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Form styling */
        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="file"], select, button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        select {
            background-color: #fff;
            color: #333;
        }

        button {
            background-color: #ffc107; /* Kuning */
            color: #000; /* Teks hitam */
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e0a800; /* Warna kuning lebih gelap */
        }

        /* Pesan sukses */
        div {
            max-width: 500px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ffc107; /* Garis kuning */
            color: #000;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        ul li a {
            color: #ffc107;
            text-decoration: none;
            font-weight: bold;
        }

        ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Catalog Photo Editor</h1>

    <!-- Form untuk upload foto dan memilih border -->
    <form action="{{ route('photo-editor.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="photo">Upload Photo:</label>
        <input type="file" name="photos[]" id="photo" accept="image/*" multiple> <!-- id="photo" di sini sesuai dengan for="photo" pada label -->

        <label for="border">Choose Border:</label>
        <select name="border" id="border" required> <!-- id="border" di sini sesuai dengan for="border" pada label -->
            <option value="TEMPLATE FEEDS HITAM.png">Border Hitam</option>
            <option value="TEMPLATE FEEDS LOGO WARNA.png">Border Warma</option>
        </select>

        <button type="submit">Edit Photo</button>
    </form>

    @if (session('success'))
        <div>
            <p>{{ session('success') }}</p>
            @if (session('editedFiles'))
                <ul>
                    @foreach (session('editedFiles') as $file)
                        <li>
                            <p>Result:</p>
                            <img src="{{ $file }}" alt="Edited Image" style="max-width: 100%; height: auto;">
                            <p><a href="{{ $file }}" download>Download Edited File</a></p><br></br>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif


</body>
</html>
