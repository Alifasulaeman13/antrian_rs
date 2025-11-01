http://127.0.0.1:8000/api/login
Endpoint Autentikasi
Register (Pendaftaran)

URL: /api/register
Method: POST
Body: name, email, password, role (opsional)
{
  "name": "Nama Pengguna",
  "email": "email@example.com",
  "password": "password123",
  "role": "admin" // opsional, default: "user"
}
Login (Masuk)

URL: /api/login
Method: POST
Body: email, password
{
  "email": "email@example.com",
  "password": "password123"
}
Logout (Keluar)

URL: /api/logout
Method: POST
Header: Authorization: Bearer {token}
Profile (Profil)

URL: /api/profile
Method: GET
Header: Authorization: Bearer {token}
Endpoint Loket
Daftar Semua Loket

URL: /api/lokets
Method: GET
Header: Authorization: Bearer {token}
Tambah Loket Baru

URL: /api/lokets
Method: POST
Header: Authorization: Bearer {token}
Body: nama_loket
Detail Loket

URL: /api/lokets/{loket}
Method: GET
Header: Authorization: Bearer {token}
Update Loket

URL: /api/lokets/{loket}
Method: PUT
Header: Authorization: Bearer {token}
Body: nama_loket
Hapus Loket

URL: /api/lokets/{loket}
Method: DELETE
Header: Authorization: Bearer {token}
Endpoint Antrian
Generate Nomor Antrian

URL: /api/lokets/{loket}/antrians/generate
Method: POST
Header: Authorization: Bearer {token}
Update Status Antrian

URL: /api/antrians/{antrian}/status
Method: PUT
Header: Authorization: Bearer {token}
Body: status (menunggu/dipanggil/selesai)
Daftar Antrian yang Sedang Dipanggil

URL: /api/antrians/dipanggil
Method: GET
Header: Authorization: Bearer {token}
Daftar Antrian yang Menunggu

URL: /api/lokets/{loket}/antrians/menunggu
Method: GET
Header: Authorization: Bearer {token}
Semua endpoint kecuali register dan login memerlukan token autentikasi yang didapatkan setelah login.