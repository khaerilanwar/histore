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

const inputQuantities = document.querySelectorAll('input[name="quantity"]');
const quantityLastProducts = document.querySelectorAll('input[name="quantity-last-product"]');

inputQuantities.forEach((item, index, array) => {
    let idProduct = item.getAttribute('id').split('-')[2]
    if (!(index === array.length - 1)) {
        // disable input element
        item.removeAttribute('required')
        item.setAttribute('disabled', 'true')
        // disable increment button
        document.getElementById(`increment-button-${idProduct}`).setAttribute('disabled', 'true')
        // disable decrement button
        document.getElementById(`decrement-button-${idProduct}`).setAttribute('disabled', 'true')
    }

    item.addEventListener('change', function (e) {
        let quantity = parseInt(e.target.value);
        const totals = document.getElementsByClassName('total-belanja');
        // const idProduct = e.target.getAttribute('id').split('-')[2];
        const subTotal = document.getElementById(`subtotal-produk-${idProduct}`);
        const jumlahProduk = document.getElementById('jumlah-produk');


        quantityLastProducts.forEach((item) => {
            item.value = quantity
        })

        subTotal.textContent = (parseInt(document.getElementById(`harga-produk-${idProduct}`).textContent.replace(/\D/g, '')) * quantity).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });

        for (const total of totals) {
            total.textContent = totalBelanja().toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }
        jumlahProduk.textContent = totalProduk();

    });

})

function decrementStock(e) {
    let idProduct = e.getAttribute('data-input-counter-decrement').split('-')[2];
    let hargaProduk = parseInt(document.getElementById(`harga-produk-${idProduct}`).textContent.replace(/\D/g, ''));
    let quantity = parseInt(document.getElementById(`input-stock-${idProduct}`).value) - 1;
    const subTotal = document.getElementById(`subtotal-produk-${idProduct}`);
    const totals = document.getElementsByClassName('total-belanja');
    const jumlahProduk = document.getElementById('jumlah-produk');

    if (quantity >= 0) {
        subTotal.textContent = (hargaProduk * quantity).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
        for (const total of totals) {
            total.textContent = totalBelanja().toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }
        quantityLastProducts.forEach((item) => {
            item.value = quantity
        })
        jumlahProduk.textContent = totalProduk() - 1;
    }
}

function incrementStock(e) {
    let idProduct = e.getAttribute('data-input-counter-increment').split('-')[2];
    let hargaProduk = parseInt(document.getElementById(`harga-produk-${idProduct}`).textContent.replace(/\D/g, ''));
    let quantity = parseInt(document.getElementById(`input-stock-${idProduct}`).value) + 1;
    let maxStock = parseInt(document.getElementById(`input-stock-${idProduct}`).getAttribute('data-input-counter-max'))
    const subTotal = document.getElementById(`subtotal-produk-${idProduct}`);
    const totals = document.getElementsByClassName('total-belanja');
    const jumlahProduk = document.getElementById('jumlah-produk');

    if (totalProduk() != maxStock) {
        subTotal.textContent = (hargaProduk * quantity).toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
        jumlahProduk.textContent = totalProduk() + 1;
        for (const total of totals) {
            total.textContent = totalBelanja().toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }
        quantityLastProducts.forEach((item) => {
            item.value = quantity
        })
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
    const paidMoneys = document.getElementsByClassName('paid-money');
    const changeMoneys = document.getElementsByClassName('change-money');
    const inputMoney = document.getElementById('input-uang');
    inputMoney.value = '';
    for (const changeMoney of changeMoneys) {
        changeMoney.textContent = 'Rp 0';
    }
    for (const paidMoney of paidMoneys) {
        paidMoney.textContent = 'Rp 0';
    }
    inputMoney.removeAttribute('disabled');
});

buttonProcessMoney.addEventListener('click', function (e) {
    const paidMoneys = document.getElementsByClassName('paid-money');
    const inputMoney = document.getElementById('input-uang');
    const changeMoneys = document.getElementsByClassName('change-money');
    const finishTotalPrice = document.querySelector('input[name="totalPriceFinish"]');
    const totalShops = document.getElementsByClassName('total-belanja');
    finishTotalPrice.value = totalBelanja()

    let valueMoney = parseInt(inputMoney.value.replace(/\D/g, ''));
    let valueChange = valueMoney - totalBelanja()

    inputMoney.setAttribute('disabled', 'disabled');
    for (const paidMoney of paidMoneys) {
        paidMoney.textContent = valueMoney.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }
    for (const changeMoney of changeMoneys) {
        changeMoney.textContent = valueChange.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 })
    }
    for (const total of totalShops) {
        total.textContent = totalBelanja().toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 })
    }
});
