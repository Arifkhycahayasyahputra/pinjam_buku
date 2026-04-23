<?php
require_once "m_koneksi.php";

class m_pengguna {
    private $koneksi;

    public function __construct() {
        $db = new m_koneksi();
        $this->koneksi = $db->koneksi;
    }

    public function tampil_data() {
        $sql = "SELECT * FROM pengguna";
        $query = mysqli_query($this->koneksi, $sql);

        $data = [];
        while ($row = mysqli_fetch_object($query)) {
            $data[] = $row;
        }
        return $data;
    }

    public function tampil_data_by_id($id) {
        $sql = "SELECT * FROM pengguna WHERE id_pengguna = '$id'";
        $query = mysqli_query($this->koneksi, $sql);
        return mysqli_fetch_object($query);
    }

    
    public function tambah_data($nama, $email, $jk, $tgl, $alamat, $pass, $role) {

        $password = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO pengguna 
            (nama_pengguna, email, jenis_kelamin, tanggal_lahir_pengguna, alamat, password, role)
            VALUES 
            ('$nama', '$email', '$jk', '$tgl', '$alamat', '$password', '$role')";

        return mysqli_query($this->koneksi, $sql);
    }

    public function ubah_data($id, $nama, $email, $jk, $tgl, $alamat, $pass, $role) {

        if (!empty($pass)) {
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $pass_sql = ", password='$password'";
        } else {
            $pass_sql = "";
        }

        $sql = "UPDATE pengguna SET
                nama_pengguna='$nama',
                email='$email',
                jenis_kelamin='$jk',
                tanggal_lahir_pengguna='$tgl',
                alamat='$alamat',
                role='$role'
                $pass_sql
            WHERE id_pengguna='$id'";

        return mysqli_query($this->koneksi, $sql);
    }

    public function hapus_data($id) {
        return mysqli_query(
            $this->koneksi,
            "DELETE FROM pengguna WHERE id_pengguna='$id'"
        );
    }

   public function login($username_email, $password) {
    
    $sql = "SELECT * FROM pengguna 
            WHERE nama_pengguna = '$username_email' 
               OR email = '$username_email'
            LIMIT 1";

    $query = mysqli_query($this->koneksi, $sql);

    if ($query && mysqli_num_rows($query) == 1) {
        $data = mysqli_fetch_object($query);

        
        if (password_verify($password, $data->password)) {
            return $data;
        }
    }

    return false;
}
}
?>
