<?php
// panggil file koneksi.php 
require_once('koneksi.php');

// membuat query ke / dari database
function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);

    // Check if the query was successful
    if ($result === false) {
        // Handle the error
        echo "Error: " . mysqli_error($koneksi);
        return [];
    } else {
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

function tambah_tamu($data)
{
    global $koneksi;

    $kode = mysqli_real_escape_string($koneksi, $data["id_tamu"]);
    $tanggal = date("Y-m-d");
    $nama_tamu = mysqli_real_escape_string($koneksi, $data["nama_tamu"]);
    $alamat = mysqli_real_escape_string($koneksi, $data["alamat"]);
    $no_hp = mysqli_real_escape_string($koneksi, $data["no_hp"]);
    $bertemu = mysqli_real_escape_string($koneksi, $data["bertemu"]);
    $kepentingan = mysqli_real_escape_string($koneksi, $data["kepentingan"]);

    $query = "INSERT INTO buku_tamu VALUES ('$kode','$tanggal','$nama_tamu','$alamat','$no_hp','$bertemu','$kepentingan')";

    if (mysqli_query($koneksi, $query)) {
        return mysqli_affected_rows($koneksi);
    } else {
        echo "Error: " . mysqli_error($koneksi);
        return 0;
    }
}

function tambah_user($data)
{
    global $koneksi;

    $kode = mysqli_real_escape_string($koneksi, $data["id_user"]);
    $username = mysqli_real_escape_string($koneksi, $data["username"]);
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $user_role = mysqli_real_escape_string($koneksi, $data["user_role"]);

    if (!isset($data["username"]) || !isset($data["user_role"])) {
        echo '<div class="alert alert-danger" role="alert">Error: Tidak ada username dan user_role</div>';
        return 0;
    }

    // Enkripsi password dengan password_hash
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah kode sudah ada di database
    $query = "SELECT * FROM users WHERE id_user = '$kode'";
    $result = mysqli_query($koneksi, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "Error: Kode '$kode' sudah ada di database.";
        return 0;
    }


    $query = "INSERT INTO users VALUES ('$kode','$username','$password_hash','$user_role')";
    if (mysqli_query($koneksi, $query)) {
        return mysqli_affected_rows($koneksi);
    } else {
        echo "Error: " . mysqli_error($koneksi);
        return 0;
    }
}

// function hapus data kamu
function hapus_tamu($id)
{
    global $koneksi;

    $query = "DELETE FROM buku_tamu WHERE id_tamu = '$id'";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
function hapus_user($id)
{
    global $koneksi;

    $query = "DELETE FROM users WHERE id_user = '$id'";
    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function ubah_tamu($data)
{
    global $koneksi;

    $id = mysqli_real_escape_string($koneksi, $data["id_tamu"]);
    $nama_tamu = mysqli_real_escape_string($koneksi, $data["nama_tamu"]);
    $alamat = mysqli_real_escape_string($koneksi, $data["alamat"]);
    $no_hp = mysqli_real_escape_string($koneksi, $data["no_hp"]);
    $bertemu = mysqli_real_escape_string($koneksi, $data["bertemu"]);
    $kepentingan = mysqli_real_escape_string($koneksi, $data["kepentingan"]);

    $query = "UPDATE buku_tamu SET 
            nama_tamu = '$nama_tamu',
            alamat = '$alamat',
            no_hp = '$no_hp',
            bertemu = '$bertemu',
            kepentingan = '$kepentingan'
            WHERE id_tamu = '$id'";

    // echo "Query: " . $query . "<br>";
    // Display the actual query

    if (mysqli_query($koneksi, $query)) {
        return mysqli_affected_rows($koneksi);
    } else {
        echo "Error: " . mysqli_error($koneksi);
        return 0;
    }

}
function ubah_user($data)
{
    global $koneksi;

    $kode = mysqli_real_escape_string($koneksi, $data["id_user"]);
    $username = mysqli_real_escape_string($koneksi, $data["username"]);
    $user_role = mysqli_real_escape_string($koneksi, $data["user_role"]);

    $query = "UPDATE users SET 
            username = '$username',
            user_role = '$user_role'
            WHERE id_user = '$kode'";

    if (mysqli_query($koneksi, $query)) {
        return mysqli_affected_rows($koneksi);
    } else {
        echo "Error: " . mysqli_error($koneksi);
        return 0;
    }

}

function ganti_password($data)
{
    global $koneksi;
    $kode = htmlspecialchars($data["id_user"]);
    $password = htmlspecialchars($data["password"]);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET
        password = '$password_hash'
        WHERE id_user = '$kode'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}



?>