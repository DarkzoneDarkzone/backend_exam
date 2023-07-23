const readline = require('readline').createInterface({
    input: process.stdin,
    output: process.stdout,
});

const readLineAsync = msg => {
    return new Promise(resolve => {
        readline.question(msg, userRes => {
            resolve(userRes);
        });
    });
}

const startApp = async() => {
    const totalPrice = await readLineAsync(`กรอกราคาสินค้ารวม : `);
    const totalDiscount = await readLineAsync(`กรอกส่วนลดรวม : `);
    readline.close();
    const netPrice = totalPrice - totalDiscount
    const vat = netPrice * 7 / 100
    console.log(`ราคาสินค้าหลังส่วนลด : ${netPrice}`)
    console.log(`ภาษีมูลค่าเพิ่ม 7 % : ${vat}`)
    console.log(`ราคารวมสุทธิ : ${netPrice + vat}`)
}

startApp()