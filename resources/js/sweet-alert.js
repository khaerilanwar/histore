import Swal from "sweetalert2";

document.querySelector('#submit-trans').addEventListener('click', (e) => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    // Mengecek apakah user sudah menginputkan uang konsumen
    const valueMoney = document.getElementById('input-uang').value;
    const displayMoney = parseInt(document.querySelector('.paid-money').textContent.replace(/\D/g, ''))
    const totalShop = parseInt(document.querySelector('.total-belanja').textContent.replace(/\D/g, ''))

    if (!valueMoney || displayMoney == 0) {
        Toast.fire({
            icon: "error",
            title: "Konsumen belum bayar"
        });
    }
    else if (displayMoney - totalShop < 0) {
        Toast.fire({
            icon: "error",
            title: "Uang Konsumen Kurang"
        });
    }
    else {
        document.querySelector('#form-transaction').submit()
    }

})