function validateForm() {
    if (document.forms["formInfo"]["nama"].value == "") {
        alert("Nama Tidak Boleh Kosong");
        document.forms["formInfo"]["nama"].focus();
        return false;
    }
    if (document.forms["formInfo"]["nrp"].value == "") {
        alert("NRP Tidak Boleh Kosong");
        document.forms["formInfo"]["nrp"].focus();
        return false;
    }
    if (document.forms["formInfo"]["alamat"].value == "") {
        alert("Alamat Tidak Boleh Kosong");
        document.forms["formInfo"]["alamat"].focus();
        return false;
    }
    if (document.forms["formInfo"]["email"].value == "") {
        alert("Email Tidak Boleh Kosong");
        document.forms["formInfo"]["email"].focus();
        return false;
    }
    if (document.forms["formInfo"]["jurusan"].selectedIndex < 1) {
       alert("Pilih Jurusan.");
       document.forms["formInfo"]["jurusan"].focus();
       return false;
   }
   alert('Berhasil')
}