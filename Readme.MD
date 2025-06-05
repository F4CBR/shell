readme_content = """
# z43nxshell.php

`z43nxshell.php` adalah webshell ringan yang sengaja dibuat khusus untuk lingkungan yang memiliki **`disable_functions` aktif**. Script ini tetap bisa digunakan untuk eksplorasi lingkungan server, enumerasi, serta interaksi file secara terbatas namun efektif.

---

## 🎯 Tujuan

- Bypass `disable_functions` (seperti: `exec`, `shell_exec`, `system`, `passthru`, etc)
- Memiliki fungsionalitas shell dasar via fungsi **native PHP** yang aman digunakan di shared hosting / restricted env
- Tampil seperti shell terminal klasik (`whoami`, `ls`, `cd`, `pwd`, `cat`, etc)
- Dirancang agar tetap bisa dijalankan meskipun `link`, `proc_*`, `popen`, `symlink`, etc dinonaktifkan

---

## 🧪 Fitur yang Didukung

| Command      | Deskripsi                                                                 |
|--------------|---------------------------------------------------------------------------|
| `pwd`        | Menampilkan current working directory                                     |
| `cd [dir]`   | Pindah direktori                                                          |
| `ls`         | Menampilkan isi direktori                                                 |
| `cat [file]` | Menampilkan isi file                                                      |
| `clear`/`cls`| Clear output (bersihkan layar)                                            |
| `whoami`     | Menampilkan user PHP saat ini                                             |
| `env`        | Dump semua variabel `$_ENV`                                               |
| `ext`        | Menampilkan semua ekstensi PHP yang aktif                                 |
| `uname`      | Informasi sistem (OS, kernel, arch)                                       |
| `phpinfo`    | Menampilkan info detail konfigurasi PHP                                   |
| `ini`        | Menampilkan semua konfigurasi `php.ini` yang aktif                        |

---

## ⚙️ Contoh Lingkungan yang Didukung

- PHP Hosting dengan `disable_functions` aktif
- PHP mode FPM atau CGI
- Tanpa akses `exec`, `shell_exec`, `proc_open`, `system`, `popen`, `passthru`, etc
- Lingkungan CTF/Web Challenge dengan PHP Hardening

---

## 🚫 Fungsi Berbahaya yang Tidak Digunakan

Untuk menjaga kompatibilitas dan stealth, script ini **tidak menggunakan** fungsi-fungsi berikut:
`exec`, `system`, `passthru`, `shell_exec`, `proc_open`, `popen`, `proc_close`, `proc_get_status`, `link`, `symlink`, `pclose`

---

## 🧠 Catatan Tambahan

- Script ini **tidak eksplisit menyisipkan kode berbahaya** seperti RCE langsung, tapi bisa digunakan untuk **enumerasi informasi sistem** dan **pengambilan file sensitif**.
- Bisa dikembangkan lebih lanjut untuk membaca `/etc/passwd`, `.env`, file log, atau konfigurasi `.php` yang terbuka.
- Ideal sebagai entry tool untuk bug bounty, red teaming awal, atau bypass CTF WAF/webshell filter.

---


## 🚧 Disclaimer
Script ini ditujukan untuk edukasi dan pengujian keamanan secara etis dan legal. Segala penyalahgunaan adalah tanggung jawab masing-masing individu. Gunakan pada sistem yang Anda miliki atau Anda izinkan untuk diuji.

## ✍️ Author
Codename: zhaenx

Role: White Hat Penetration Tester

Motto: "Enumerate everything. Assume nothing."
"""
