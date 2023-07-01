function confirmVoting(kandidatId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah sudah yakin dengan pilihan Anda?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('voting-form-' + kandidatId).submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.close(); // Menutup alert
        }
    });
}

function disableButton(kandidatId) {
    var button = document.getElementById('button-' + kandidatId);
    button.disabled = true;
    button.innerHTML = 'Sudah Dipilih';
    button.classList.remove('btn-success');
    button.classList.add('btn-danger');
}

function showDetails(button) {
    // Mengambil data terkait dari atribut data-* tombol
    var nama = button.dataset.nama;
    var jenisKelamin = button.dataset.jenisKelamin;
    var usia = button.dataset.usia;
    var visi = button.dataset.visi;
    var misi = button.dataset.misi;

    // Mengonversi karakter baris baru menjadi tag <br>
    misi = misi.replace(/\n/g, '<br>');
    // Membangun konten HTML modal
    var modalContent = `
    <div align="left">
    <strong>Nama:</strong> ${nama}
    </div>
    <div align="left">
    <strong>Jenis Kelamin:</strong> ${jenisKelamin}
    </div>
    <div align="left">
    <strong>Usia:</strong> ${usia}
    </div>
    <div>
    <strong>Visi:</strong>
    <p>${visi}</p>
    </div>
    <div>
    <strong>Misi:</strong>
    <p align="justify">${misi}</p>
    </div>
    `;

    Swal.fire({
        title: 'Detail Kandidat',
        html: modalContent,
        confirmButtonText: 'OK',
    });
}
