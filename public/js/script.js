const inputQuantities = document.querySelectorAll('input[name="quantity"]');

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function totalBelanja() {
    const allSubTotal = document.querySelectorAll('.subtotal-produk');
    let total = 0;
    for (const item of allSubTotal) {
        total += parseInt(item.textContent.replace(/\D/g, ''));
    }

    return total;
}

function totalProduk() {
    const allQuantity = document.querySelectorAll('input[name="quantity"]');
    let total = 0;
    for (const item of allQuantity) {
        total += parseInt(item.value);
    }

    return total;
}

for (const input of inputQuantities) {
    input.addEventListener('change', function (e) {
        let quantity = parseInt(e.target.value);
        const totals = document.getElementsByClassName('total-belanja');
        const idProduct = e.target.getAttribute('id').split('-')[2];
        const subTotal = document.getElementById(`subtotal-produk-${idProduct}`);
        const jumlahProduk = document.getElementById('jumlah-produk');
        console.log(quantity);

        subTotal.textContent = (parseInt(document.getElementById(`harga-produk-${idProduct}`).textContent.replace(/\D/g, '')) * quantity).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });

        for (const total of totals) {
            total.textContent = totalBelanja().toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }
        jumlahProduk.textContent = totalProduk();

    });
}

function decrementStock(e) {
    let idProduct = e.getAttribute('data-input-counter-decrement').split('-')[2];
    let hargaProduk = parseInt(document.getElementById(`harga-produk-${idProduct}`).textContent.replace(/\D/g, ''));
    let quantity = parseInt(document.getElementById(`input-stock-${idProduct}`).value) - 1;
    const subTotal = document.getElementById(`subtotal-produk-${idProduct}`);
    const totals = document.getElementsByClassName('total-belanja');
    const jumlahProduk = document.getElementById('jumlah-produk');
    console.log(quantity);

    if (quantity >= 0) {
        subTotal.textContent = (hargaProduk * quantity).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
        for (const total of totals) {
            total.textContent = totalBelanja().toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }
        jumlahProduk.textContent = totalProduk() - 1;
    }
}

function incrementStock(e) {
    let idProduct = e.getAttribute('data-input-counter-increment').split('-')[2];
    let hargaProduk = parseInt(document.getElementById(`harga-produk-${idProduct}`).textContent.replace(/\D/g, ''));
    let quantity = parseInt(document.getElementById(`input-stock-${idProduct}`).value) + 1;
    const subTotal = document.getElementById(`subtotal-produk-${idProduct}`);
    const totals = document.getElementsByClassName('total-belanja');
    const jumlahProduk = document.getElementById('jumlah-produk');

    subTotal.textContent = (hargaProduk * quantity).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
    jumlahProduk.textContent = totalProduk() + 1;
    for (const total of totals) {
        total.textContent = totalBelanja().toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }
}

// Input Uang Konsumen Dengan Button
const inputMoney = document.getElementById('input-uang');
const buttonMoneys = document.getElementsByClassName('button-price');

inputMoney.addEventListener('keyup', function (e) {
    inputMoney.value = formatRupiah(inputMoney.value);
});

for (const buttonMoney of buttonMoneys) {
    buttonMoney.addEventListener('click', function (e) {
        let valueMoney = buttonMoney.innerHTML.replace(/\D/g, '');
        let newMoney = (parseInt(inputMoney.value) ? parseInt(inputMoney.value.replace(/\D/g, '')) : 0) + parseInt(valueMoney);

        if (!inputMoney.hasAttribute('disabled')) {
            inputMoney.value = newMoney.toLocaleString('id-ID');
        }
    });
}

const buttonProcessMoney = document.getElementById('process-money');
const buttonClearMoney = document.getElementById('clear-money');

buttonClearMoney.addEventListener('click', function (e) {
    const paidMoney = document.getElementById('paid-money');
    const inputMoney = document.getElementById('input-uang');
    inputMoney.value = '';
    paidMoney.textContent = 'Rp 0';
    inputMoney.removeAttribute('disabled');
});

buttonProcessMoney.addEventListener('click', function (e) {
    const paidMoney = document.getElementById('paid-money');
    const inputMoney = document.getElementById('input-uang');
    let valueMoney = parseInt(inputMoney.value.replace(/\D/g, ''));

    inputMoney.setAttribute('disabled', 'disabled');
    paidMoney.textContent = valueMoney.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
});